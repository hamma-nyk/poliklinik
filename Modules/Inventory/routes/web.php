<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\App\Http\Controllers\MedicineController;
use Modules\Inventory\App\Http\Controllers\TransactionController;
use Modules\Inventory\App\Http\Controllers\InventoryReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('inventory')->name('inventory.')->group(function () {
    
    // Resource route otomatis membuat url: index, create, store, edit, update, destroy
    Route::resource('medicines', MedicineController::class);
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
    // Transaksi stok sebaiknya tidak diedit/hapus sembarangan untuk menjaga integritas data audit.
    // Jika ada salah, buat transaksi koreksi (Stok Opname).
    Route::get('/reports/stock-card', [InventoryReportController::class, 'stockCard'])->name('reports.stock_card');
});