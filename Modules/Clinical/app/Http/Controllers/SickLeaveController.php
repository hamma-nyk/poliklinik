<?php

namespace Modules\Clinical\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clinical\App\Models\SickLeave;
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\Clinical\App\Models\LabCheck;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Employee;
use Carbon\Carbon;

class SickLeaveController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = SickLeave::with(['patient', 'medicalRecord']);

        // Fitur Pencarian
        if ($request->search) {
            $term = '%' . $request->search . '%';
            $query->where(function($q) use ($term) {
                $q->where('reg_number', 'ilike', $term) // Cari Kode RM
                  ->orWhereHas('patient', function($subQ) use ($term) {
                      $subQ->where('name', 'ilike', $term) // Cari Nama Pasien
                           ->orWhere('nik', 'ilike', $term)
                            ->orWhere('ktp', 'ilike', $term);;
                  });
            });
                  
        }

        // Filter Tanggal (Opsional: Default bulan ini, atau tampilkan semua latest)
        // $query->whereMonth('created_at', now()->month);

        $letters = $query->latest()->paginate($perPage);
        return view('clinical::sick_leaves.index', compact('letters'));
    }

    public function create()
    {
        // --- UBAH BAGIAN INI (Sesuaikan nama kolom di database Anda) ---
        $kategoriKaryawan = 'karyawan'; // Contoh value di database
        // ---------------------------------------------------------------

        // 1. Ambil List Rekam Medis INTERNAL
        $internalCandidates = MedicalRecord::with(['patient', 'doctor', 'nurse'])
            ->whereHas('patient', function($query) use ($kategoriKaryawan) {
                $query->where('type', $kategoriKaryawan); 
            })
            ->where('is_sick_leave', true)
            ->whereDoesntHave('sickLeave') 
            ->latest()
            ->get();

        // 2. GABUNGKAN DATA UNTUK EKSTERNAL (Pasien + Master Karyawan)
        // Ambil data pasien karyawan
        $patients = Patient::where('type', $kategoriKaryawan)->get();

        // Ambil semua NIK pasien yang sudah terdaftar (abaikan yang NIK-nya kosong)
        $registeredNiks = $patients->pluck('nik')->filter()->toArray();

        // Ambil data dari Master Karyawan yang NIK-nya BELUM ADA di tabel Pasien
        // Asumsi model master karyawan Anda bernama Employee (Sesuaikan jika beda)
        $employees = Employee::whereNotIn('nik', $registeredNiks)
            ->whereIn('is_active', ['', 'KT', 'KK'])
            ->orderByRaw("CASE WHEN is_active != 'KO' THEN 1 ELSE 0 END")
            // ->orderBy('nama', 'asc') // Sesuaikan: apakah nama kolomnya 'nama' atau 'name' di DB Anda?
            ->get();

        // Buat Collection baru untuk digabungkan ke Dropdown Blade
        $combinedList = collect();

        foreach ($patients as $p) {
            $combinedList->push([
                // Value diberi prefix untuk membedakan sumber datanya saat di method store
                'value' => 'patient_' . $p->id, 
                'name'  => $p->name,
                'label' => $p->name . ' (Data Pasien - NIK: ' . ($p->nik ?? '-') . ')'
            ]);
        }

        foreach ($employees as $e) {
            $combinedList->push([
                'value' => 'employee_' . $e->id, 
                'name'  => $e->nama,
                'label' => $e->nama . ' (Master Karyawan - NIK: ' . ($e->nik ?? '-') . ')'
            ]);
        }

        // Urutkan dropdown berdasarkan nama sesuai abjad
        $externalCandidates = $combinedList->sortBy('name');

        // Generate No Surat
        $count = SickLeave::whereMonth('created_at', date('m'))->count() + 1;
        $regNumber = 'SKD' . date('Ym') . '' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('clinical::sick_leaves.create', compact('patients', 'externalCandidates', 'internalCandidates', 'regNumber'));
    }

    public function store(Request $request)
    {
        // Validasi Dasar
        $request->validate([
            'type'        => 'required|in:internal,external',
            'start_date'  => 'required|date',
            'days'        => 'required|integer|min:1',
        ]);

        $data = [
            'reg_number'    => $request->reg_number,
            'type'          => $request->type,
            'start_date'    => $request->start_date,
            'duration_days' => $request->days,
            'end_date'      => Carbon::parse($request->start_date)->addDays($request->days - 1),
            'notes'         => $request->notes,
        ];

        if ($request->type == 'internal') {
            // Validasi Internal
            $request->validate(['medical_record_id' => 'required']);
            
            $mr = MedicalRecord::findOrFail($request->medical_record_id);
            
            $data['medical_record_id'] = $mr->id;
            $data['patient_id']        = $mr->patient_id; // Pasien ambil dari MR
            
        } else {
            // Validasi External
            $request->validate([
                'target_person'        => 'required', // Di blade, name select-nya ganti jadi target_person
                'external_clinic_name' => 'required',
                'external_doctor_name' => 'required',
            ]);
       
            // Pecah value dari dropdown (Contoh: "patient_10" atau "employee_5")
            $personParts = explode('_', $request->target_person);
            $sourceType  = $personParts[0]; 
            $sourceId    = $personParts[1];

            if ($sourceType === 'patient') {
                // Jika dia sudah ada di tabel pasien, langsung pakai ID-nya
                $data['patient_id'] = $sourceId;
            } else {
                // Jika dia dari Master Karyawan, AUTO-CREATE ke tabel Pasien dulu
                $employee = Employee::findOrFail($sourceId);
                
                $newPatient = Patient::create([
                    'employee_id' => $employee->id,
                    'type'        => 'karyawan',
                    'name'        => $employee->nama,
                    'gender'      => $employee->gender,
                    'birth_date'  => $employee->birth_date,
                    'phone'       => $employee->phone,
                    'alamat'      => $employee->alamat,
                    'blood_type'  => $employee->blood_type,
                    'nik'         => $employee->nik ?? NULL,
                    'ktp'         => $employee->ktp ?? NULL,
                    'bag_dept'    => $employee->bag_dept ?? NULL,
                    'subbag_dept' => $employee->subbag_dept ?? NULL,
                    'sub_subbag_dept' => $employee->sub_subbag_dept ?? NULL,
                    'jabatan'     => $employee->jabatan ?? NULL,
                    'allergies'   => NULL,
                    'family_of_employee_id' => NULL   // Inputan manual medis
                ]);
                // Gunakan ID Pasien yang baru saja dibuat
                $data['patient_id'] = $newPatient->id;
            }
            $data['external_clinic_name'] = $request->external_clinic_name;
            $data['external_doctor_name'] = $request->external_doctor_name;
        }

        SickLeave::create($data);

        return redirect()->route('clinical.sick-leaves.index')->with('success', 'Surat Keterangan Dokter berhasil diterbitkan.');
    }

    public function show($id)
    {
        // Kita perlu data Pasien, dan jika Internal kita perlu data Dokter Pemeriksa (via MedicalRecord)
        $letter = SickLeave::with(['patient', 'medicalRecord.doctor', 'medicalRecord.nurse'])->findOrFail($id);
        
        return view('clinical::sick_leaves.show', compact('letter'));
    }

    /**
     * Menampilkan halaman khusus cetak (Print Mode)
     */
    public function print($id)
    {
        $letter = SickLeave::with(['patient', 'medicalRecord.doctor', 'medicalRecord.nurse'])->findOrFail($id);
        
        // Pastikan view ini ada di folder resources/views/sick_leaves/print.blade.php
        return view('clinical::sick_leaves.print', compact('letter'));
    }
}