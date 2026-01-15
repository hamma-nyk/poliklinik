<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Doctor;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        // Fitur Pencarian
        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('code', 'ilike', '%' . $request->search . '%')
                  ->orWhere('sip', 'ilike', '%' . $request->search . '%');
        }

        $doctors = $query->orderBy('is_active', 'desc') // Yang aktif di atas
                         ->orderBy('name', 'asc')
                         ->paginate(10);

        return view('masterdata::doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('masterdata::doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik_ktp' => 'nullable|string|max:50',
            'sip' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'required',
        ]);

        // Kolom 'code' otomatis diisi oleh Trait, tidak perlu diinput manual
        Doctor::create([
            'name' => $request->name,
            'nik_ktp' => $request->nik_ktp,
            'sip' => $request->sip,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'is_active' => true // Default aktif saat dibuat
        ]);

        return redirect()->route('master.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('masterdata::doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $doctor = Doctor::findOrFail($id);
        
        $doctor->update([
            'name' => $request->name,
            'nik_ktp' => $request->nik_ktp,
            'sip' => $request->sip,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            // Checkbox: Jika dicentang return true, jika tidak return false
            'is_active' => $request->has('is_active'), 
        ]);

        return redirect()->route('master.doctors.index')->with('success', 'Data dokter diperbarui.');
    }

    public function destroy($id)
    {
        Doctor::findOrFail($id)->delete();
        return redirect()->route('master.doctors.index')->with('success', 'Data dokter dihapus.');
    }
}