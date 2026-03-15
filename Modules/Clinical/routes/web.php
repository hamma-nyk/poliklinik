<?php

use Illuminate\Support\Facades\Route;
use Modules\Clinical\Http\Controllers\ClinicalController;
use Modules\Clinical\App\Http\Controllers\MedicalRecordController;
use Modules\Clinical\App\Http\Controllers\LabCheckController;
use Modules\Clinical\App\Http\Controllers\ReportController;
use Modules\Clinical\App\Http\Controllers\SickLeaveController;


// --- AREA PUBLIC (Hanya untuk Cetak dengan Link Rahasia) ---
Route::get('clinical/records/{id}/print', [MedicalRecordController::class, 'print'])
    ->name('clinical.records.print')
    ->middleware('signed'); // WAJIB: Hanya link yang punya "tanda tangan" yang bisa buka

Route::get('clinical/lab/{id}/print', [LabCheckController::class, 'print'])
    ->name('clinical.lab.print')
    ->middleware('signed');

Route::middleware(['auth'])->prefix('clinical')->name('clinical.')->group(function () {
    
    // 1. Route Medical Records
    Route::get('records/{id}/send-wa', [MedicalRecordController::class, 'sendToWhatsApp'])->name('records.send_wa');
    Route::resource('records', MedicalRecordController::class);

    // 2. Route Lab
    Route::resource('lab', LabCheckController::class);

    Route::resource('sick-leaves', SickLeaveController::class);
    Route::get('sick-leaves/{id}', [SickLeaveController::class, 'show'])->name('sick-leaves.show');

    // 2. Route Khusus Cetak PDF / Print (Opsional tapi sangat disarankan)
    Route::get('sick-leaves/{id}/print', [SickLeaveController::class, 'print'])->name('sick-leaves.print');

    // 3. Route Reports (PERBAIKAN DISINI)
    // Cukup tulis 'reports' karena sudah di dalam grup 'clinical'
    // Middleware auth juga tidak perlu ditulis ulang karena mewarisi dari induknya
    Route::prefix('reports')->name('reports.')->group(function() {
        
        // URL Akhir: /clinical/reports
        // Nama Akhir: clinical.reports.index
        Route::get('/', [ReportController::class, 'index'])->name('index'); 
        
        // URL Akhir: /clinical/reports/visits
        // Nama Akhir: clinical.reports.visits
        Route::get('/visits', [ReportController::class, 'visits'])->name('visits');
        
        Route::get('/diseases', [ReportController::class, 'diseases'])->name('diseases');
        Route::get('/medicines', [ReportController::class, 'medicines'])->name('medicines');
        Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low_stock');
        Route::get('/incoming', [ReportController::class, 'incoming'])->name('incoming');
        Route::get('/mutation', [ReportController::class, 'mutation'])->name('mutation');
        Route::get('/skd', [ReportController::class, 'indexSkd'])->name('skd');
        Route::post('/skd/export', [ReportController::class, 'exportSkd'])->name('skd_export');
    });

});