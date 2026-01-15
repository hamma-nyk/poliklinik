<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Tampilkan List Karyawan
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->search) {
            $query->where('nama', 'ilike', '%' . $request->search . '%')
                  ->orWhere('nik', 'ilike', '%' . $request->search . '%')
                  ->orWhere('bag_dept', 'ilike', '%' . $request->search . '%');
        }

        // Urutkan: Yang aktif diatas, lalu urut nama
        $employees = $query->orderByRaw("CASE WHEN is_active IS NULL THEN 0 ELSE 1 END")
                           ->orderBy('nama', 'asc')
                           ->paginate(10);

        return view('masterdata::employees.index', compact('employees'));
    }

    /**
     * Form Tambah Manual
     */
    public function create()
    {
        return view('masterdata::employees.create');
    }

    /**
     * Simpan Data Manual
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:sc_master.employees,nik',
            'nama' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
        ]);

        Employee::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'ktp' => $request->ktp,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
            'blood' => $request->blood,
            'bag_dept' => $request->bag_dept,
            'jabatan' => $request->jabatan,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'is_active' => null // Default Aktif
        ]);

        return redirect()->route('master.employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('masterdata::employees.edit', compact('employee'));
    }

    /**
     * Update Data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:sc_master.employees,nik,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        $employee = Employee::findOrFail($id);

        // Logika Status: Jika checkbox dicentang -> NULL (Aktif). Jika tidak -> 'KO'
        $status = $request->has('is_active') ? null : 'KO';

        $employee->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'ktp' => $request->ktp,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
            'blood' => $request->blood,
            'bag_dept' => $request->bag_dept,
            'jabatan' => $request->jabatan,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'is_active' => $status
        ]);

        return redirect()->route('master.employees.index')->with('success', 'Data karyawan diperbarui.');
    }

    /**
     * Hapus Data
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasRole('superadmin')) {
             return back()->with('error', 'Hanya Superadmin yang boleh menghapus.');
        }
        
        Employee::findOrFail($id)->delete();
        return redirect()->route('master.employees.index')->with('success', 'Data karyawan dihapus.');
    }

    /**
     * Import CSV (Fitur Khusus)
     */
    public function import(Request $request)
    {
        // 1. Perpanjang Waktu & Memori
        set_time_limit(600); // 10 Menit
        ini_set('memory_limit', '1024M');

        if(!auth()->user()->hasRole('superadmin')) {
            return back()->with('error', 'Akses ditolak.');
        }

        $request->validate(['csv_file' => 'required|mimes:csv,txt']);

        $file = $request->file('csv_file');
        
        // 2. Buka file mode stream (Hemat Memori)
        $handle = fopen($file->getPathname(), 'r');

        DB::beginTransaction();
        try {
            $header = true; // Penanda baris pertama (Header)
            $count = 0; // Hitung baris untuk commit bertahap

            // Baca baris per baris
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                // Skip baris pertama (Header)
                if ($header) {
                    $header = false;
                    continue;
                }

                // Skip jika baris kosong atau NIK kosong
                if (empty($data[0])) continue;

                // Mapping Data (Sesuaikan urutan kolom CSV)
                // 0:NIK, 1:Nama, 2:Dept, 3:Jabatan, 4:Gender(L/P), 5:Status(KO/Active)
                
                $status = (isset($data[12]) && trim($data[12]) == 'KO') ? 'KO' : null;

                    Employee::updateOrCreate(
                        ['nik' => $data[0]], 
                        [
                            'nama' => $data[1] ?? NULL,
                            'ktp' => $data[2] ?? NULL,
                            'alamat' => $data[3] ?? NULL,
                            'phone' => $data[4] ?? NULL,
                            'blood_type' => $data[5] ?? NULL,
                            'bag_dept' => $data[6] ?? NULL,
                            'subbag_dept' => $data[7] ?? NULL,
                            'sub_subbag_dept' => $data[8] ?? NULL,
                            'birth_date' => $data[9] ?? NULL,
                            'jabatan' => $data[10] ?? NULL,
                            'gender' => $data[11] ?? NULL,
                            'is_active' => $status
                        ]
                    );

                $count++;

                // OPTIMASI: Commit database setiap 500 data
                // Ini mencegah transaksi database terlalu berat
                if ($count % 500 == 0) {
                    DB::commit();
                    DB::beginTransaction(); // Mulai transaksi baru
                }
            }

            fclose($handle); // Tutup file
            DB::commit(); // Commit sisa data terakhir
            
            return back()->with('success', "Import berhasil! Total $count karyawan diproses.");

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle); // Pastikan file tertutup jika error
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}