<?php

namespace App\Observers;

use Modules\Inventory\App\Models\MedicineTransactionItem;
use Exception;

class StockMovementObserver
{
    /**
     * Handle the MedicineTransactionItem "creating" event.
     * Dijalankan SEBELUM item disimpan.
     * Kita pakai ini untuk VALIDASI STOK.
     */
    public function creating(MedicineTransactionItem $item)
    {
        // Pastikan load relasi transaction & medicine
        $transaction = $item->transaction; 
        $medicine = $item->medicine;

        if (!$transaction || !$medicine) {
            return; // Safety check
        }

        // LOGIC BLOCKING STOK MINUS
        // Cek jika tipe 'out' (keluar) DAN stok saat ini < jumlah yang diminta
        if ($transaction->type === 'out' && $medicine->current_stock < $item->quantity) {
            
            // Lempar Error agar Controller menangkapnya dan Transaksi Batal (Rollback)
            throw new Exception("Stok tidak mencukupi! Stok {$medicine->name} sisa {$medicine->current_stock}, diminta {$item->quantity}.");
        }
    }

    /**
     * Handle the MedicineTransactionItem "created" event.
     * Dijalankan SETELAH item sukses tersimpan (dan lolos cek di atas).
     */
    public function created(MedicineTransactionItem $item)
    {
        $medicine = $item->medicine;
        $transaction = $item->transaction;

        // Logic Update Stok (Sama seperti kode Anda)
        if ($transaction->type === 'in') {
            $medicine->increment('current_stock', $item->quantity);
        } elseif ($transaction->type === 'out') {
            $medicine->decrement('current_stock', $item->quantity);
        }
    }

    /**
     * Handle jika item dihapus
     */
    public function deleted(MedicineTransactionItem $item)
    {
        $medicine = $item->medicine;
        $transaction = $item->transaction;

        if ($transaction->type === 'in') {
            $medicine->decrement('current_stock', $item->quantity);
        } elseif ($transaction->type === 'out') {
            $medicine->increment('current_stock', $item->quantity);
        }
    }
}