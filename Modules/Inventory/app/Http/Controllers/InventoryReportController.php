<?php

namespace Modules\Inventory\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransactionItem;
use Carbon\Carbon;

class InventoryReportController extends Controller
{
    public function stockCard(Request $request)
    {
        $medicines = Medicine::orderBy('name')->get();
        
        $transactions = collect(); // Kosong default
        $openingStock = 0;
        $selectedMedicine = null;

        if ($request->has('medicine_id') && $request->medicine_id != '') {
            $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
            $endDate   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();
            $medicineId = $request->medicine_id;
            
            $selectedMedicine = Medicine::find($medicineId);

            // 1. HITUNG STOK AWAL (Semua transaksi SEBELUM Start Date)
            // Rumus: Total Masuk - Total Keluar
            $qtyInBefore = MedicineTransactionItem::where('medicine_id', $medicineId)
                ->whereHas('transaction', function($q) use ($startDate) {
                    $q->where('transaction_date', '<', $startDate)
                      ->where('type', 'in'); // Adjustment Plus / Pembelian
                })->sum('quantity');

            $qtyOutBefore = MedicineTransactionItem::where('medicine_id', $medicineId)
                ->whereHas('transaction', function($q) use ($startDate) {
                    $q->where('transaction_date', '<', $startDate)
                      ->where('type', 'out'); // Adjustment Minus / Pemakaian
                })->sum('quantity');

            $openingStock = $qtyInBefore - $qtyOutBefore;

            // 2. AMBIL TRANSAKSI DALAM PERIODE (Range Date)
            $transactions = MedicineTransactionItem::with('transaction')
                ->where('medicine_id', $medicineId)
                ->whereHas('transaction', function($q) use ($startDate, $endDate) {
                    $q->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                // Urutkan berdasarkan tanggal transaksi, lalu ID (agar urut waktu input)
                ->join('sc_inventory.medicine_transactions as t', 't.id', '=', 'medicine_transaction_id')
                ->orderBy('t.transaction_date', 'asc')
                ->orderBy('t.created_at', 'asc')
                ->select('sc_inventory.medicine_transaction_items.*') // Ambil kolom item saja agar tidak bentrok
                ->get();
        }

        return view('inventory::reports.stock_card', compact('medicines', 'transactions', 'openingStock', 'selectedMedicine'));
    }
}