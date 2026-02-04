<?php

namespace Modules\Clinical\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clinical\App\Models\LabCheck;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse;
use Barryvdh\DomPDF\Facade\Pdf;
class LabCheckController extends Controller
{
   public function index(Request $request)
    {
        $query = LabCheck::with('patient')->latest();

        if ($request->search) {
            $term = '%'.$request->search.'%';

            // Bungkus dalam satu where(function) agar logika OR tidak bocor
            $query->where(function($q) use ($term) {
                
                // 1. Cari berdasarkan KODE LAB (di tabel lab_checks sendiri)
                $q->where('code', 'ilike', $term) 
                
                // 2. ATAU cari berdasarkan Data Pasien (Relasi)
                  ->orWhereHas('patient', function($subQ) use ($term) {
                      $subQ->where('name', 'ilike', $term)
                           ->orWhere('nik', 'ilike', $term) // Ganti 'code' pasien dgn NIK/NoRM jika perlu
                           ->orWhere('code', 'ilike', $term); // Jika pasien punya kolom code (No RM)
                  });
            });
        }

        $checks = $query->paginate(10);
        return view('clinical::lab_checks.index', compact('checks'));
    }

   public function create()
    {
        $patients = Patient::orderBy('name')->get();
        
        // Ambil Dokter (Pastikan kolom statusnya benar, misal 'status' = 'active')
        $doctors = Doctor::where('is_active', true)->orderBy('name')->get();
        
        // Ambil Perawat (Pastikan kolom statusnya benar, misal 'is_active' = true)
        $nurses = Nurse::where('is_active', true)->orderBy('nama')->get();

        return view('clinical::lab_checks.create', compact('patients', 'doctors', 'nurses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'examiner'   => 'required',
            // Minimal satu harus diisi
            'gula_darah' => 'nullable|integer',
            'kolesterol' => 'nullable|integer',
            'asam_urat' => 'nullable|numeric',
        ]);

        $parts = explode('|', $request->examiner);
        $type  = $parts[0];
        $id    = $parts[1];
        
        LabCheck::create([
            'patient_id' => $request->patient_id,
            // Tentukan masuk ke kolom mana
            'examiner_type' => $type, // Masuk ke kolom examiner_type
            'examiner_id'   => $id,
            
            'gula_darah' => $request->gula_darah,
            'kolesterol' => $request->kolesterol,
            'asam_urat'  => $request->asam_urat,
            'tensi'      => $request->tensi,
            'notes'      => $request->notes,
        ]);

        return redirect()->route('clinical.lab.index')->with('success', 'Hasil Lab tercatat.');
    }
    
    // Tambahkan method destroy jika perlu hapus
    public function destroy($id) {
        LabCheck::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus');
    }

    public function print($id)
    {
        $check = LabCheck::with(['patient', 'examiner'])->findOrFail($id);

        // Load view PDF
        $pdf = Pdf::loadView('clinical::lab_checks.print', compact('check'));
        
        // Ukuran kertas A5 Landscape (biasanya hasil lab kecil) atau A4 Portrait
        // Kita pakai A4 Portrait standar saja agar rapi
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('LAB-' . $check->code . '.pdf');
    }
}