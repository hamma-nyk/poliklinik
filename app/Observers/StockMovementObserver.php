<?php

namespace App\Observers;

use Modules\Inventory\App\Models\MedicineTransactionItem;

class StockMovementObserver
{
    /**
     * Handle the MedicineTransactionItem "created" event.
     * Dijalankan otomatis SETELAH item tersimpan di database.
     */
    public function created(MedicineTransactionItem $item)
    {
        // 1. Ambil data obat terkait
        $medicine = $item->medicine;
        
        // 2. Ambil data Header Transaksi untuk tahu tipenya (in/out)
        // Kita pakai refresh() atau load() untuk memastikan relasi terbaca
        $transaction = $item->transaction;

        if (!$medicine || !$transaction) {
            return; // Safety check
        }

        // 3. Logic Update Stok
        if ($transaction->type === 'in') {
            // Jika Pembelian (IN) -> Tambah Stok
            $medicine->increment('current_stock', $item->quantity);
        } elseif ($transaction->type === 'out') {
            // Jika Pemakaian (OUT) -> Kurangi Stok
            $medicine->decrement('current_stock', $item->quantity);
        }
    }

    /**
     * Handle jika item dihapus (misal transaksi dibatalkan)
     */
    public function deleted(MedicineTransactionItem $item)
    {
        $medicine = $item->medicine;
        $transaction = $item->transaction;

        if ($transaction->type === 'in') {
            // Jika pembelian dihapus -> Stok harus dikurangi lagi
            $medicine->decrement('current_stock', $item->quantity);
        } elseif ($transaction->type === 'out') {
            // Jika pemakaian dihapus -> Stok dikembalikan (ditambah)
            $medicine->increment('current_stock', $item->quantity);
        }
    }
}