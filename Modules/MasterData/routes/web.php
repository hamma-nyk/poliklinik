<?php

use Illuminate\Support\Facades\Route;
use Modules\MasterData\Http\Controllers\MasterDataController;
use Modules\MasterData\App\Http\Controllers\DoctorController;
use Modules\MasterData\App\Http\Controllers\NurseController;
use Modules\MasterData\App\Http\Controllers\EmployeeController;
use Modules\MasterData\App\Http\Controllers\PatientController;
Route::middleware(['auth', 'verified'])->prefix('master')->name('master.')->group(function () {
    Route::resource('masterdatas', MasterDataController::class)->names('masterdata');
    Route::resource('doctors', DoctorController::class);
    Route::resource('nurses', NurseController::class);
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::resource('employees', EmployeeController::class);
    Route::resource('patients', PatientController::class);
});
