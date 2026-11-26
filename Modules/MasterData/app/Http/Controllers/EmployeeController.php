<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Modules\MasterData\App\Models\Department;
use Modules\MasterData\App\Models\SubDepartment;
use Modules\MasterData\App\Models\Unit;
use Modules\MasterData\App\Models\Position;

class EmployeeController extends Controller
{
    /**
     * Tampilkan List Karyawan
     */
    public function index(Request $request)
    {
        // 1. Ambil nilai per_page dari request, default 10
        $perPage = $request->input('per_page', 10);

        $query = Employee::with(['department', 'subDepartment', 'unit', 'position']);
        
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function($q) use ($term) {
                $q->where('nama', 'ilike', $term)
                ->orWhere('nik', 'ilike', $term)
                ->orWhere('jabatan', 'ilike', $term)
                ->orWhere('bag_dept', 'ilike', $term);
            });
        }
        $employees = $query
        ->orderByRaw("CASE WHEN is_active != 'KO' THEN 1 ELSE 0 END")
        ->orderBy('nama', 'asc')
        ->whereIn('is_active', ['','KT', 'KK'])
        ->paginate($perPage)
        ->onEachSide(1)
        ->withQueryString();

        return view('masterdata::employees.index', compact('employees'));
    }

    /**
     * Form Tambah Manual
     */
    public function create()
    {
        $departments = Department::orderBy('code')->get();
        $subDepartments = SubDepartment::orderBy('code')->get();
        $units = Unit::orderBy('code')->get();
        $positions = Position::orderBy('code')->get();
            return view('masterdata::employees.create', compact(
            'departments', 
            'subDepartments', 
            'units', 
            'positions'
        ));
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
        $query = Employee::query();
        $departments = Department::orderBy('code')->get();
        $subDepartments = SubDepartment::orderBy('code')->get();
        $units = Unit::orderBy('code')->get();
        $positions = Position::orderBy('code')->get();

        return view('masterdata::employees.edit', compact('employee',
        'departments', 
        'subDepartments', 
        'units', 
        'positions'));
    }

    /**
     * Update Data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:pgsql.sc_master.employees,nik,' . $id,
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
    public function bulkTrim()
    {
        // Gunakan DB::raw untuk menjalankan fungsi TRIM() level database
        // Ini support MySQL dan PostgreSQL
        try {
            \Modules\MasterData\App\Models\Employee::query()->update([
                'nik'             => DB::raw("TRIM(nik)"),
                'ktp'             => DB::raw("TRIM(ktp)"),
                'phone'             => DB::raw("TRIM(phone)"),
                'blood_type'             => DB::raw("TRIM(blood_type)"),
                'bag_dept'        => DB::raw("TRIM(bag_dept)"),
                'subbag_dept'     => DB::raw("TRIM(subbag_dept)"),
                'sub_subbag_dept' => DB::raw("TRIM(sub_subbag_dept)"),
                'jabatan'         => DB::raw("TRIM(jabatan)"),
            ]);
            \Modules\MasterData\App\Models\Department::query()->update([
                'code'      => DB::raw("TRIM(code)")
            ]);
             \Modules\MasterData\App\Models\SubDepartment::query()->update([
                'code'      => DB::raw("TRIM(code)")
            ]);
             \Modules\MasterData\App\Models\Unit::query()->update([
                'code'      => DB::raw("TRIM(code)")
            ]);
             \Modules\MasterData\App\Models\Position::query()->update([
                'code'      => DB::raw("TRIM(code)")
            ]);

            return back()->with('success', 'Berhasil! Spasi berlebih pada data Jabatan & Departemen telah dibersihkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan trimming: ' . $e->getMessage());
        }
    }

    public function syncData()
    {
        DB::beginTransaction();
        try {
            // 1. Ambil Data Mentah dari Database Luar
            $countEmployees = $this->_syncEmployees();
            $countDepartments = $this->_syncDepartments();
            $countSubDepartments = $this->_syncSubDepartments();
            $countSubSubDepartments = $this->_syncSubSubDepartments();
            $countPositions = $this->_syncPositions();

            DB::commit();
            return back()->with('success', "Sukses! Karyawan: $countEmployees, Departemen: $countDepartments, Bagian: $countSubDepartments, Sub Bagian: $countSubSubDepartments, Jabatan: $countPositions. ");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal sinkronisasi: ' . $e->getMessage());
        }
    }

    private function _syncDepartments()
    {
        // 1. Ambil data dari DB Luar
        $source = DB::connection('db_external')->table('sc_mst.departmen')->get();
        $count = 0;
        foreach ($source as $row) {
            // Trim & Bersihkan
            $codeClean = strtoupper(trim($row->kddept)); // Misal: ' TE ' -> 'TE'

            // Simpan ke DB Lokal (Table: sub_departments atau departments)
            Department::updateOrInsert(
                ['code' => $codeClean], // Kunci Pencocokan
                [
                    'name' => $row->nmdept,
                    'updated_at' => now()
                ]
            );
            $count++;
        }
        return $count;
    }

    private function _syncSubDepartments()
    {
        // 1. Ambil data dari DB Luar
        $source = DB::connection('db_external')->table('sc_mst.subdepartmen')->get();
        $count = 0;
        foreach ($source as $row) {
            // Trim & Bersihkan
            $codeClean = strtoupper(trim($row->kdsubdept)); // Misal: ' TE ' -> 'TE'

            // Simpan ke DB Lokal (Table: sub_departments atau departments)
            SubDepartment::updateOrInsert(
                ['code' => $codeClean], // Kunci Pencocokan
                [
                    'name' => $row->nmsubdept,
                    'updated_at' => now()
                ]
            );
            $count++;
        }
        return $count;
    }

    private function _syncSubSubDepartments()
    {
        // 1. Ambil data dari DB Luar
        $source = DB::connection('db_external')->table('sc_mst.section')->get();
        $count = 0;
        foreach ($source as $row) {
            // Trim & Bersihkan
            $codeClean = strtoupper(trim($row->section_code)); // Misal: ' TE ' -> 'TE'

            // Simpan ke DB Lokal (Table: sub_departments atau departments)
            Unit::updateOrInsert(
                ['code' => $codeClean], // Kunci Pencocokan
                [
                    'name' => $row->section_name,
                    'updated_at' => now()
                ]
            );
            $count++;
        }
        return $count;
    }

    private function _syncPositions()
    {
        // 1. Ambil data dari DB Luar
        $source = DB::connection('db_external')->table('sc_mst.jabatan')->get();
        $count = 0;
        foreach ($source as $row) {
            // Trim & Bersihkan
            $codeClean = strtoupper(trim($row->kdjabatan)); // Misal: ' TE ' -> 'TE'

            // Simpan ke DB Lokal (Table: sub_departments atau departments)
            Position::updateOrInsert(
                ['code' => $codeClean], // Kunci Pencocokan
                [
                    'name' => $row->nmjabatan,
                    'updated_at' => now()
                ]
            );
            $count++;
        }
        return $count;
    }

    private function _syncEmployees()
    {
        // 1. Ambil data dari DB Luar
        $sourceData = DB::connection('db_external')->table('sc_mst.karyawan')->get();
        $count = 0;
        foreach ($sourceData as $row) {
            // --- STEP 1: BERSIHKAN DATA (TRIM) DISINI ---
            // Kita tampung dulu ke variabel baru yang sudah bersih
            
            $nikClean     = trim($row->nik); 
            $ktpClean     = trim($row->noktp);
            $phoneClean   = trim($row->nohp1);
            $bloodTypeClean = trim($row->gol_darah);
            $genderClean = trim($row->jk);
            $deptClean    = trim($row->bag_dept);
            $subDeptClean = trim($row->subbag_dept);
            $subSubDeptClean = trim($row->sub_subbag_dept);
            $jabatanClean = trim($row->jabatan);
   
            // 1. Cari berdasarkan NIK. Jika tidak ada, buat Instance Baru (tapi belum save ke DB)
            $employee = Employee::firstOrNew([
                'nik' => $nikClean
            ]);

            // --- STEP 2: BARU DI-PROSES KE DATABASE ---
            $employee->nama            = $row->nmlengkap;
            $employee->ktp             = $ktpClean;
            $employee->alamat          = $row->alamatktp;
            $employee->phone           = $phoneClean;
            $employee->blood_type      = $bloodTypeClean;
            $employee->gender          = $genderClean; // Tanggal biasanya aman tanpa trim
            $employee->bag_dept        = $deptClean;
            $employee->subbag_dept     = $subDeptClean;
            $employee->sub_subbag_dept = $subSubDeptClean;
            $employee->jabatan         = $jabatanClean;
            $employee->birth_date      = $row->tgllahir;
            $employee->is_active       = trim($row->statuskepegawaian);

            if ($employee->isDirty() || !$employee->exists) {
                $employee->save();
                $count++;
            }    
        }
        return $count;
    }
}