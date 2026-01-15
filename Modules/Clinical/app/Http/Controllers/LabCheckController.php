<?php

namespace Modules\Clinical\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Clinical\App\Models\LabCheck;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse;
class LabCheckController extends Controller
{
    public function index(Request $request)
    {
        $query = LabCheck::with('patient')->latest();

        if ($request->search) {
            $query->whereHas('patient', function($q) use ($request) {
                $q->where('name', 'ilike', '%'.$request->search.'%');
            });
        }

        $checks = $query->paginate(10);
        return view('clinical::lab_checks.index', compact('checks'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        // Ambil data Dokter & Perawat Aktif
        $doctors = Doctor::active()->orderBy('name')->get();
        $nurses = Nurse::where('is_active', true)->orderBy('name')->get();

        return view('clinical::lab_checks.create', compact('patients', 'doctors', 'nurses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'petugas_selection' => 'required',
            // Minimal satu harus diisi
            'gula_darah' => 'nullable|integer',
            'kolesterol' => 'nullable|integer',
            'asam_urat' => 'nullable|numeric',
        ]);

        $petugasType = explode('_', $request->petugas_selection)[0]; // 'doc' atau 'nur'
        $petugasId   = explode('_', $request->petugas_selection)[1]; // ID-nya
        
        LabCheck::create([
            'patient_id' => $request->patient_id,
            // Tentukan masuk ke kolom mana
            'doctor_id' => ($petugasType == 'doc') ? $petugasId : null,
            'nurse_id'  => ($petugasType == 'nur') ? $petugasId : null,
            
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
}