<?php

namespace Modules\Inventory\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransaction;
use Modules\Inventory\App\Models\MedicineTransactionItem;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        // Ambil transaksi yang tidak memiliki medical_record_id (bukan resep)
        // Dan catatan mengandung kata 'Adjustment' atau manual input
        $query = MedicineTransaction::with(['items.medicine'])
            ->whereNull('medical_record_id') 
            ->latest('transaction_date');

        if ($request->search) {
            $query->where('notes', 'like', '%' . $request->search . '%');
        }

        $adjustments = $query->paginate(10);
        
        return view('inventory::adjustments.index', compact('adjustments'));
    }

    public function create()
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('inventory::adjustments.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'type'             => 'required|in:in,out',
            'medicine_id'      => 'required|exists:pgsql.sc_inventory.medicines,id',
            'quantity'         => 'required|integer|min:1',
            'notes'            => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Header Transaksi
            $transaction = MedicineTransaction::create([
                'transaction_date' => $request->transaction_date,
                'type'             => $request->type, // 'in' atau 'out'
                'notes'            => 'Adjustment: ' . $request->notes, // Tandai sebagai adjustment
            ]);

            // 2. Buat Detail Item (Itemnya cuma 1 kalau adjustment harian)
            MedicineTransactionItem::create([
                'medicine_transaction_id' => $transaction->id,
                'medicine_id'             => $request->medicine_id,
                'quantity'                => $request->quantity,
                'price_at_moment'         => 0, // Adjustment biasanya tidak ada harga beli baru
            ]);
            
            // Trigger update stok otomatis dijalankan oleh Model Event / Observer (jika ada)
            // Atau logic Stok Card Anda sudah menghitung ini otomatis.
        });

        return redirect()->route('inventory.adjustments.index')
            ->with('success', 'Penyesuaian stok berhasil disimpan.');
    }
}