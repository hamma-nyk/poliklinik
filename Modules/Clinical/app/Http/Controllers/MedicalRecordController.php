<?php

namespace Modules\Clinical\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransaction; // Import Transaksi
use Modules\MasterData\App\Models\Diagnosis; // <--- Import Model Diagnosis
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'diagnosis']);

        // Fitur Pencarian
        if ($request->search) {
            $term = '%' . $request->search . '%';
            $query->where(function($q) use ($term) {
                $q->where('code', 'ilike', $term) // Cari Kode RM
                  ->orWhereHas('patient', function($subQ) use ($term) {
                      $subQ->where('name', 'ilike', $term) // Cari Nama Pasien
                           ->orWhere('nik', 'ilike', $term)
                            ->orWhere('ktp', 'ilike', $term);;
                  })
                  ->orWhereHas('diagnosis', function($subQ) use ($term) {
                      $subQ->where('name', 'ilike', $term); // Cari Nama Penyakit
                  });
            });
        }

        // Filter Tanggal (Opsional: Default bulan ini, atau tampilkan semua latest)
        // $query->whereMonth('created_at', now()->month);

        $records = $query->latest()->paginate(10);
        
        return view('clinical::medical_records.index', compact('records'));
    }

    public function create()
    {
        // Data Master untuk Dropdown
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::active()->orderBy('name')->get();
        $nurses = Nurse::where('is_active', true)->orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        $diagnoses = Diagnosis::orderBy('name')->get();
        return view('clinical::medical_records.create', compact('patients', 'doctors', 'nurses', 'medicines', 'diagnoses'));    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'keluhan_utama' => 'required',
            //'diagnosa' => 'required',
            'diagnosa_input' => 'required',
            // Validasi Obat (Array)
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'required',
            'medicines.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 1. LOGIKA DIAGNOSA (Cari atau Buat Baru)
            $diagnosisId = null;
            $diagnosisName = null;

            if ($request->filled('diagnosa_input')) {
                $input = $request->diagnosa_input;

                if (is_numeric($input)) {
                    // KASUS A: User memilih Diagnosa yang sudah ada (Input berupa ID)
                    $diag = Diagnosis::find($input);
                    if ($diag) {
                        $diagnosisId = $diag->id;
                        $diagnosisName = $diag->name;
                    }
                } else {
                    // KASUS B: User mengetik Diagnosa baru (Input berupa String)
                    $diag = Diagnosis::firstOrCreate(
                        ['name' => $input],
                        ['code' => 'DIAG' . rand(1000, 9999)]
                    );
                    $diagnosisId = $diag->id;
                    $diagnosisName = $diag->name;
                }
            }
            
            // 1. Simpan Header
            $record = MedicalRecord::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'nurse_id' => $request->nurse_id,

                
                'diagnosis_id' => $diagnosisId,
                'diagnosa' => $diagnosisName,

                'tensi' => $request->tensi,
                'suhu_tubuh' => $request->suhu_tubuh,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'keluhan_utama' => $request->keluhan_utama,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'riwayat_alergi' => $request->riwayat_alergi,
                'riwayat_psikososial' => $request->riwayat_psikososial,
                'tindakan' => $request->tindakan,
            ]);

            // 2. Simpan Detail Obat
            if ($request->medicines && count($request->medicines) > 0) {
                // Buat Header Transaksi Inventory
                $inventoryTrx = MedicineTransaction::create([
                    'type' => 'out',
                    'transaction_date' => now(),
                    'medical_record_id' => $record->id,
                    'notes' => "Resep Pasien: " . $record->patient->name . " (" . $record->code . ")",
                ]);

                foreach ($request->medicines as $med) {
                    if(empty($med['id'])) continue; 

                    // Simpan ke History Medis
                    $record->medicines()->create([
                        'medicine_id' => $med['id'],
                        'quantity' => $med['qty'],
                        'instructions' => $med['instructions'] ?? '-',
                    ]);

                    // Simpan ke History Inventory
                    $inventoryTrx->items()->create([
                        'medicine_id' => $med['id'],
                        'quantity' => $med['qty'],
                        'price_at_moment' => 0, 
                    ]);

                    // Kurangi Stok
                    // Medicine::where('id', $med['id'])->decrement('current_stock', $med['qty']);
                }
            }

            DB::commit();
            return redirect()->route('clinical.records.index')->with('success', 'Rekam Medis berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        // Load semua relasi yang dibutuhkan: Pasien, Dokter, Diagnosa, Obat
        $record = MedicalRecord::with(['patient', 'doctor', 'nurse', 'diagnosis', 'medicines.medicine'])
                    ->findOrFail($id);
        
        return view('clinical::medical_records.show', compact('record'));
    }

    public function print($id)
    {
        $record = MedicalRecord::with(['patient', 'doctor', 'diagnosis', 'medicines.medicine'])
                    ->findOrFail($id);

        // Load view khusus PDF (tanpa navbar/sidebar)
        $pdf = Pdf::loadView('clinical::medical_records.print', compact('record'));
        
        // Setup Kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        // Stream: Tampilkan di browser (bisa didownload manual)
        return $pdf->stream('RM-' . $record->code . '.pdf');
    }
}