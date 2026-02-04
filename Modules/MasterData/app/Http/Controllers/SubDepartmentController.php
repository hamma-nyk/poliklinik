<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\SubDepartment;
use Modules\MasterData\App\Imports\SubDepartmentsImport;
use Maatwebsite\Excel\Facades\Excel;

class SubDepartmentController extends Controller
{
    public function index()
    {
        $subDepartments = SubDepartment::orderBy('code')->paginate(10);
        return view('masterdata::sub_departments.index', compact('subDepartments'));
    }

    public function create()
    {
        return view('masterdata::sub_departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:sc_master.sub_departments,code|max:10',
            'name' => 'required|string|max:255',
        ]);

        SubDepartment::create($request->all());
        return redirect()->route('master.sub-departments.index')->with('success', 'Sub Bagian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $subDepartment = SubDepartment::findOrFail($id);
        return view('masterdata::sub_departments.edit', compact('subDepartment'));
    }

    public function update(Request $request, $id)
    {
        $subDepartment = SubDepartment::findOrFail($id);
        
        $request->validate([
            'code' => 'required|max:10|unique:sc_master.sub_departments,code,'.$id,
            'name' => 'required|string|max:255',
        ]);

        $subDepartment->update($request->all());
        return redirect()->route('master.sub-departments.index')->with('success', 'Sub Bagian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        SubDepartment::findOrFail($id)->delete();
        return redirect()->route('master.sub-departments.index')->with('success', 'Sub Bagian dihapus.');
    }

    // --- IMPORT & TEMPLATE ---
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        Excel::import(new SubDepartmentsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Sub Bagian berhasil diimport!');
    }

    public function downloadTemplate()
    {
        $headers = ['Content-Type' => 'text/csv'];
        $columns = ['code', 'name'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['PMP', 'Pemper (Pemeliharaan Perbaikan)']); // Contoh
            fputcsv($file, ['LOG', 'Logistik']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}