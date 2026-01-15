<?php

use Illuminate\Support\Facades\Route;
use Modules\Clinical\Http\Controllers\ClinicalController;
use Modules\Clinical\App\Http\Controllers\MedicalRecordController;
use Modules\Clinical\App\Http\Controllers\LabCheckController;
Route::middleware(['auth'])->prefix('clinical')->name('clinical.')->group(function () {
    
    // Route Khusus Print
    Route::get('records/{id}/print', [MedicalRecordController::class, 'print'])->name('records.print');
    
    // Route Resource (Index, Create, Store, Show)
    Route::resource('records', MedicalRecordController::class);

    Route::resource('lab', LabCheckController::class); // URL: /clinical/lab
});