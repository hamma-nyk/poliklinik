<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Unit;
use Modules\MasterData\App\Imports\UnitsImport;
use Maatwebsite\Excel\Facades\Excel;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('code')->paginate(10);
        return view('masterdata::units.index', compact('units'));
    }

    public function create()
    {
        return view('masterdata::units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:sc_master.units,code|max:10',
            'name' => 'required|string|max:255',
        ]);

        Unit::create($request->all());
        return redirect()->route('master.units.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('masterdata::units.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        
        $request->validate([
            'code' => 'required|max:10|unique:sc_master.units,code,'.$id,
            'name' => 'required|string|max:255',
        ]);

        $unit->update($request->all());
        return redirect()->route('master.units.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return redirect()->route('master.units.index')->with('success', 'Unit dihapus.');
    }

    // --- IMPORT & TEMPLATE ---
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        Excel::import(new UnitsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Unit berhasil diimport!');
    }

    public function downloadTemplate()
    {
        $headers = ['Content-Type' => 'text/csv'];
        $columns = ['code', 'name'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['U01', 'Unit Layanan A']); // Contoh
            fputcsv($file, ['U02', 'Unit Layanan B']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}