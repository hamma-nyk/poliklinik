<?php

namespace Modules\Inventory\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventory\App\Models\Medicine;
class MedicineController extends Controller
{
    /**
     * Menampilkan daftar obat.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Medicine::query();

        // Pencarian
        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('code', 'ilike', '%' . $request->search . '%');
        }

        $medicines = $query->latest()
        ->paginate($perPage)
        ->onEachSide(1)
        ->withQueryString();
       
        return view('inventory::medicines.index', compact('medicines'));
    }

    /**
     * Menampilkan form tambah obat.
     */
    public function create()
    {
        return view('inventory::medicines.create');
    }

    /**
     * Menyimpan obat baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50', // cth: Tablet, Botol, Strip
            // 'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Code digenerate otomatis oleh Trait (OB2026...)
        // Stock default 0, nanti bertambah lewat Transaksi Pembelian
        Medicine::create([
            'name' => $request->name,
            'unit' => $request->unit,
            // 'price' => $request->price,
            'description' => $request->description,
            'current_stock' => 0,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('inventory.medicines.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('inventory::medicines.edit', compact('medicine'));
    }

    /**
     * Update data obat.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            // 'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $medicine = Medicine::findOrFail($id);
        
        // Kita update data master saja. 
        // STOK JANGAN DIUPDATE DISINI agar konsisten dengan riwayat transaksi.
        $medicine->update([
            'name' => $request->name,
            'unit' => $request->unit,
            // 'price' => $request->price,
            'description' => $request->description,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('inventory.medicines.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    /**
     * Hapus obat (Soft Delete).
     */
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        
        // Cek apakah stok masih ada? (Opsional: Cegah hapus jika stok > 0)
        if($medicine->current_stock > 0) {
             return back()->with('error', 'Gagal hapus! Obat masih memiliki stok. Lakukan transaksi keluar atau penyesuaian stok dulu.');
        }

        $medicine->delete();

        return redirect()->route('inventory.medicines.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }
}