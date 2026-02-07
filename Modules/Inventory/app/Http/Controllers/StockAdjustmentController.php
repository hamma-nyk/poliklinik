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

        $adjustments = $query->latest()->paginate(10);
        
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
            'medicine_id'      => 'required|exists:medicines,id',
            'type'             => 'required|in:in,out',
            'quantity'         => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes'            => 'required|string|max:255',
        ]);

        $medicine = Medicine::findOrFail($request->medicine_id);

        // 2. Proteksi Stok Minus (Hanya jika tipe keluar/out)
        if ($request->type === 'out' && $medicine->current_stock < $request->quantity) {
                return back()->withErrors([
                    'quantity' => "Stok tidak mencukupi. Sisa stok {$medicine->name} saat ini adalah {$medicine->current_stock} {$medicine->unit}."
                ])->withInput();
        }

        try {
            // 3. Eksekusi Transaksi Database
            DB::transaction(function () use ($request, $medicine) {
                
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

                // UPDATE STOK UTAMA
                // GWEJ PAKE OBSERVER JIR
            });

            return redirect()->route('inventory.adjustments.index')
                ->with('success', 'Penyesuaian stok berhasil disimpan.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}