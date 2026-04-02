<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\App\Http\Controllers\MedicineController;
use Modules\Inventory\App\Http\Controllers\TransactionController;
use Modules\Inventory\App\Http\Controllers\InventoryReportController;
use Modules\Inventory\App\Http\Controllers\StockOpnameController;
use Modules\Inventory\App\Http\Controllers\StockAdjustmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('inventory')->name('inventory.')->group(function () {
    
    // Resource route otomatis membuat url: index, create, store, edit, update, destroy
    Route::get('medicines/export-excel', [MedicineController::class, 'exportExcel'])->name('medicines.export_excel');

    Route::resource('medicines', MedicineController::class);
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
    // Transaksi stok sebaiknya tidak diedit/hapus sembarangan untuk menjaga integritas data audit.
    // Jika ada salah, buat transaksi koreksi (Stok Opname).
    Route::get('/reports/stock-card', [InventoryReportController::class, 'stockCard'])->name('reports.stock_card');
    Route::get('stock-opname/{id}/export-excel', [StockOpnameController::class, 'exportExcel'])->name('stock_opname.export_excel');
    Route::get('stock-opname/{id}/export-pdf', [StockOpnameController::class, 'exportPdf'])->name('stock_opname.export_pdf');
    Route::resource('stock-opnames', StockOpnameController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('adjustments/export-period', [StockAdjustmentController::class, 'exportPeriod'])->name('stock_adjustment.export_period');
    Route::resource('adjustments', StockAdjustmentController::class)->only(['index', 'create', 'store']);
    
});