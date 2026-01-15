<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MasterData\App\Models\Nurse;

class NurseController extends Controller
{
    public function index(Request $request)
    {
        $query = Nurse::query();

        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('code', 'ilike', '%' . $request->search . '%')
                  ->orWhere('str', 'ilike', '%' . $request->search . '%');
        }

        $nurses = $query->orderBy('is_active', 'desc')
                        ->orderBy('name', 'asc')
                        ->paginate(10);

        return view('masterdata::nurses.index', compact('nurses'));
    }

    public function create()
    {
        return view('masterdata::nurses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik_ktp' => 'nullable|string|max:50',
            'str' => 'nullable|string|max:50', // Surat Tanda Registrasi
            'phone' => 'nullable|string|max:20',
        ]);

        Nurse::create([
            'name' => $request->name,
            'nik_ktp' => $request->nik_ktp,
            'str' => $request->str,
            'phone' => $request->phone,
            'is_active' => true
        ]);

        return redirect()->route('master.nurses.index')->with('success', 'Data perawat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $nurse = Nurse::findOrFail($id);
        return view('masterdata::nurses.edit', compact('nurse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $nurse = Nurse::findOrFail($id);
        
        $nurse->update([
            'name' => $request->name,
            'nik_ktp' => $request->nik_ktp,
            'str' => $request->str,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('master.nurses.index')->with('success', 'Data perawat diperbarui.');
    }

    public function destroy($id)
    {
        Nurse::findOrFail($id)->delete();
        return redirect()->route('master.nurses.index')->with('success', 'Data perawat dihapus.');
    }
}