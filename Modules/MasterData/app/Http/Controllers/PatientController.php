<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Employee;
use Illuminate\Validation\Rule;
class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('employee');

        // Pencarian
        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('code', 'ilike', '%' . $request->search . '%') // Cari ID Pasien
                  ->orWhere('nik_ktp', 'ilike', '%' . $request->search . '%');
        }

        $patients = $query->latest()->paginate(10);
        
        return view('masterdata::patients.index', compact('patients'));
    }

    public function create()
    {
        // Ambil Karyawan Aktif untuk dropdown
        // Kita urutkan nama agar mudah dicari
        $employees = Employee::active()->orderBy('nama')->get();
        
        return view('masterdata::patients.create', compact('employees'));
    }

    public function store(Request $request)
    {
        // LOGIKA: Jalur Karyawan vs Umum
        if ($request->registration_type == 'employee') {
            
            // --- JALUR 1: DARI KARYAWAN ---
            $request->validate([
             'employee_id' => [
                'required',
                // Cara Modern & Aman:
                // Laravel akan cek model Employee, melihat tabel 'sc_master.employees'
                // dan koneksi 'pgsql', lalu membuat query yang benar otomatis.
                Rule::exists(Employee::class, 'id'),
                ]
            ]);

            $emp = Employee::findOrFail($request->employee_id);

            // Cek Duplikasi: Apakah karyawan ini sudah terdaftar sebagai pasien?
            $exist = Patient::where('employee_id', $emp->id)->first();
            if($exist) {
                return back()->with('error', "Karyawan atas nama $emp->nama sudah terdaftar sebagai pasien (ID: $exist->code).");
            }

            // Copy data dari HR ke Pasien
            Patient::create([
                // 'code' otomatis diisi Trait
                'employee_id' => $emp->id,
                'type'        => 'karyawan',
                'name'        => $emp->nama,
                'gender'      => $emp->gender,
                'birth_date'  => $emp->birth_date,
                'phone'       => $emp->phone,
                'alamat'      => $emp->alamat,
                'blood_type'  => $emp->blood_type,
                'nik'         => $emp->nik ?? NULL,
                'ktp'         => $emp->ktp ?? NULL,
                'subbag_dept' => $emp->subbag_dept ?? NULL,
                'allergies'   => $request->allergies,
                'family_of_employee_id' => NULL   // Inputan manual medis
            ]);

        } else {
            
            // --- JALUR 2: UMUM / KELUARGA / TAMU ---
            $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:L,P',
                //'nik_ktp' => 'nullable|unique:sc_master.patients,nik_ktp',
                'ktp' => [
                'nullable',
                // Cara Modern & Aman:
                // Laravel akan cek model Employee, melihat tabel 'sc_master.employees'
                // dan koneksi 'pgsql', lalu membuat query yang benar otomatis.
                Rule::unique(Patient::class, 'ktp'),
                ]
            ]);

            Patient::create([
                'employee_id' => null,
                'type'        => 'umum', // Default umum
                'name'        => $request->name,
                'gender'      => $request->gender,
                'birth_date'  => $request->birth_date,
                'phone'       => $request->phone,
                'alamat'      => $request->address,
                'blood_type'  => $request->blood_type,
                'nik'         => NULL,
                'ktp'         => $request->ktp,
                'subbag_dept' => NULL,
                'allergies'   => $request->allergies,
                'family_of_employee_id' => $request->family_of_employee_id
            ]);
        }

        return redirect()->route('master.patients.index')->with('success', 'Pasien baru berhasil didaftarkan.');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('masterdata::patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            //'nik_ktp' => 'nullable|unique:sc_master.patients,nik_ktp,' . $id,
            'ktp' => [
                'nullable',
                // Cara Modern & Aman:
                // Laravel akan cek model Employee, melihat tabel 'sc_master.employees'
                // dan koneksi 'pgsql', lalu membuat query yang benar otomatis.
                Rule::unique(Patient::class, 'ktp')->ignore($id),
                ]
        ]);

        $patient->update([
            'name'        => $request->name,
            'nik'     => $request->nik,
            'ktp'     => $request->ktp,
            'subbag_dept' => $request->subbag_dept,
            'gender'      => $request->gender,
            'birth_date'  => $request->birth_date,
            'alamat'      => $request->address,
            'phone'       => $request->phone,
            'blood_type'  => $request->blood_type,
            'allergies'   => $request->allergies,
            'family_of_employee_id' => $request->family_of_employee_id  
            // Tipe & Employee ID biasanya tidak diubah saat edit
        ]);

        return redirect()->route('master.patients.index')->with('success', 'Data pasien diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus pasien (biasanya dilarang kalau sudah ada rekam medis)
        // Disini kita hard delete untuk contoh
        Patient::findOrFail($id)->delete();
        return redirect()->route('master.patients.index')->with('success', 'Data pasien dihapus.');
    }
}