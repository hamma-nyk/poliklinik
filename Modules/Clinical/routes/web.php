<?php

use Illuminate\Support\Facades\Route;
use Modules\Clinical\Http\Controllers\ClinicalController;
use Modules\Clinical\App\Http\Controllers\MedicalRecordController;
use Modules\Clinical\App\Http\Controllers\LabCheckController;
use Modules\Clinical\App\Http\Controllers\ReportController;

Route::middleware(['auth'])->prefix('clinical')->name('clinical.')->group(function () {
    
    // 1. Route Medical Records
    Route::get('records/{id}/print', [MedicalRecordController::class, 'print'])->name('records.print');
    Route::resource('records', MedicalRecordController::class);

    // 2. Route Lab
    Route::get('lab/{id}/print', [LabCheckController::class, 'print'])->name('lab.print');
    Route::resource('lab', LabCheckController::class);

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
    });
});