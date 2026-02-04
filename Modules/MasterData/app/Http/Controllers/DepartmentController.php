<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Department;
use Modules\MasterData\App\Imports\DepartmentsImport;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('code')->paginate(10);
        return view('masterdata::departments.index', compact('departments'));
    }

    public function create()
    {
        return view('masterdata::departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:sc_master.departments,code|max:10',
            'name' => 'required|string|max:255',
        ]);

        Department::create($request->all());
        return redirect()->route('master.departments.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('masterdata::departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $request->validate([
            'code' => 'required|max:10|unique:sc_master.departments,code,'.$id,
            'name' => 'required|string|max:255',
        ]);

        $department->update($request->all());
        return redirect()->route('master.departments.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return redirect()->route('master.departments.index')->with('success', 'Departemen dihapus.');
    }

    // --- FITUR IMPORT ---
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new DepartmentsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Departemen berhasil diimport!');
    }

    public function downloadTemplate()
    {
        // Buat file CSV sederhana untuk template
        $headers = ['Content-Type' => 'text/csv'];
        $columns = ['code', 'name']; // Header wajib

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['TE', 'Teknik']); // Contoh data
            fputcsv($file, ['AK', 'Akuntansi']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}