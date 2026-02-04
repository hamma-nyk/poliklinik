<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Position;
use Modules\MasterData\App\Imports\PositionsImport;
use Maatwebsite\Excel\Facades\Excel;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('code')->paginate(10);
        return view('masterdata::positions.index', compact('positions'));
    }

    public function create()
    {
        return view('masterdata::positions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:sc_master.positions,code|max:10',
            'name' => 'required|string|max:255',
        ]);

        Position::create($request->all());
        return redirect()->route('master.positions.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('masterdata::positions.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);
        
        $request->validate([
            'code' => 'required|max:10|unique:sc_master.positions,code,'.$id,
            'name' => 'required|string|max:255',
        ]);

        $position->update($request->all());
        return redirect()->route('master.positions.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Position::findOrFail($id)->delete();
        return redirect()->route('master.positions.index')->with('success', 'Jabatan dihapus.');
    }

    // --- IMPORT & TEMPLATE ---
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        Excel::import(new PositionsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Jabatan berhasil diimport!');
    }

    public function downloadTemplate()
    {
        $headers = ['Content-Type' => 'text/csv'];
        $columns = ['code', 'name'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['MGR', 'Manager']); // Contoh
            fputcsv($file, ['STF', 'Staff Administrasi']);
            fputcsv($file, ['SPV', 'Supervisor']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}