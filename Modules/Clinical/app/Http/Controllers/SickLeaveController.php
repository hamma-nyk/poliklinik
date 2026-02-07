<?php

namespace Modules\Clinical\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clinical\App\Models\SickLeave;
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\Clinical\App\Models\LabCheck;
use Modules\MasterData\App\Models\Patient;
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
        // 1. Ambil List Pasien (Untuk opsi External)
        $patients = Patient::orderBy('name')->get();

        // 2. Ambil List Rekam Medis INTERNAL yang:
        //    - Dicentang "is_sick_leave"
        //    - Belum pernah dibuatkan SKD (agar tidak duplikat)
        $internalCandidates = MedicalRecord::with(['patient', 'doctor', 'nurse'])
            ->where('is_sick_leave', true)
            ->whereDoesntHave('sickLeave') // Pastikan relasi di model MedicalRecord ada: public function sickLeave()
            ->latest()
            ->get();

        // Generate No Surat Otomatis (SKD/TahunBulan/Urut)
        $count = SickLeave::whereMonth('created_at', date('m'))->count() + 1;
        $regNumber = 'SKD' . date('Ym') . '' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('clinical::sick_leaves.create', compact('patients', 'internalCandidates', 'regNumber'));
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
                'patient_id'           => 'required',
                'external_clinic_name' => 'required',
                'external_doctor_name' => 'required',
            ]);

            $data['patient_id']           = $request->patient_id;
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