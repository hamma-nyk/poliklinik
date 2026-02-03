<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Nurse;
use Modules\MasterData\App\Models\Employee;
use Illuminate\Validation\Rule;
class NurseController extends Controller
{
    public function index(Request $request)
    {
        $query = Nurse::query();

        if ($request->search) {
            $query->where('nama', 'ilike', '%' . $request->search . '%')
                  ->orWhere('code', 'ilike', '%' . $request->search . '%')
                  ->orWhere('str', 'ilike', '%' . $request->search . '%');
        }

        $nurses = $query->orderBy('is_active', 'desc')
                        ->orderBy('nama', 'asc')
                        ->paginate(10);

        return view('masterdata::nurses.index', compact('nurses'));
    }

    public function create()
    {
        // Ambil semua karyawan untuk dropdown
        // Kita bisa ambil name, nik, phone, address untuk auto-fill
        $employees = Employee::where('is_active', NULL)->orderBy('nama')->get();
        
        return view('masterdata::nurses.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|required_if:type,karyawan|string|max:50',            
            'ktp' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:20',
            'str' => 'nullable|string|max:50', // Surat Tanda Registrasi
            'phone' => 'nullable|string|max:20',
            'employee_id' => ['nullable', Rule::exists(Employee::class, 'id')],
        ]);

        Nurse::create([
            'nama' => $request->nama,
            'employee_id'  => $request->type == 'karyawan' ? $request->employee_id : null,
            'nik' => $request->type == 'karyawan' ? $request->nik : null,
            'ktp' => $request->ktp,
            'type' => $request->type,
            'str' => $request->str,
            'phone' => $request->phone,
            'is_active' => true
        ]);

        return redirect()->route('master.nurses.index')->with('success', 'Data perawat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $nurse = Nurse::findOrFail($id);

        // --- TAMBAHKAN BARIS INI (Ambil data karyawan) ---
        $employees = Employee::orderBy('nama')->get();

        // --- JANGAN LUPA TAMBAHKAN 'employees' KE DALAM COMPACT ---
        return view('masterdata::nurses.edit', compact('nurse', 'employees'));
    }
    public function update(Request $request, $id)
    {
        $nurse = Nurse::findOrFail($id);

        $request->validate([
            'type'         => 'required|in:karyawan,eksternal',
            'nama'         => 'required|string|max:255',
            'ktp'      => 'nullable|string|max:20',
            // Validasi Kondisional
            'nik' => 'nullable|required_if:type,karyawan|string|max:50',
            'employee_id'  => 'nullable|exists:pgsql.sc_master.employees,id', // Ganti sc_master.employees sesuai config DB Anda (misal: 'pgsql.sc_master.employees' atau pakai Rule::exists)
        ]);

        $nurse->update([
            'type'         => $request->type,
            // Jika berubah jadi Eksternal, hapus link ke employee
            'employee_id'  => $request->type == 'karyawan' ? $request->employee_id : null,
            'nik' => $request->type == 'karyawan' ? $request->nik : null,
            'ktp'      => $request->ktp,
            'nama'         => $request->nama,
            'str'          => $request->str,
            'phone'        => $request->phone,
            'alamat'      => $request->alamat,
            'is_active'    => $request->has('is_active') // Checkbox logic
        ]);

        return redirect()->route('master.nurses.index')->with('success', 'Data perawat berhasil diperbarui.');
    }
    public function destroy($id)
    {
        Nurse::findOrFail($id)->delete();
        return redirect()->route('master.nurses.index')->with('success', 'Data perawat dihapus.');
    }
}