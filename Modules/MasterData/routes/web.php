<?php

use Illuminate\Support\Facades\Route;
use Modules\MasterData\Http\Controllers\MasterDataController;
use Modules\MasterData\App\Http\Controllers\DoctorController;
use Modules\MasterData\App\Http\Controllers\NurseController;
use Modules\MasterData\App\Http\Controllers\EmployeeController;
use Modules\MasterData\App\Http\Controllers\PatientController;
use Modules\MasterData\App\Http\Controllers\DepartmentController;
use Modules\MasterData\App\Http\Controllers\SubDepartmentController;
use Modules\MasterData\App\Http\Controllers\UnitController;
use Modules\MasterData\App\Http\Controllers\PositionController;

Route::middleware(['auth', 'verified'])->prefix('master')->name('master.')->group(function () {
    Route::resource('masterdatas', MasterDataController::class)->names('masterdata');
    Route::resource('doctors', DoctorController::class);
    Route::resource('nurses', NurseController::class);
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::resource('employees', EmployeeController::class);
    Route::resource('patients', PatientController::class);

    Route::prefix('departments')->name('departments.')->group(function() {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
        
        // Route Import
        Route::post('/import', [DepartmentController::class, 'import'])->name('import');
        Route::get('/template', [DepartmentController::class, 'downloadTemplate'])->name('template');
    });

    Route::prefix('sub-departments')->name('sub-departments.')->group(function() {
        Route::get('/', [SubDepartmentController::class, 'index'])->name('index');
        Route::get('/create', [SubDepartmentController::class, 'create'])->name('create');
        Route::post('/', [SubDepartmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SubDepartmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SubDepartmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubDepartmentController::class, 'destroy'])->name('destroy');
        
        // Import
        Route::post('/import', [SubDepartmentController::class, 'import'])->name('import');
        Route::get('/template', [SubDepartmentController::class, 'downloadTemplate'])->name('template');
    });

    Route::prefix('units')->name('units.')->group(function() {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UnitController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/{id}', [UnitController::class, 'destroy'])->name('destroy');
        
        // Import
        Route::post('/import', [UnitController::class, 'import'])->name('import');
        Route::get('/template', [UnitController::class, 'downloadTemplate'])->name('template');
    });

    Route::prefix('positions')->name('positions.')->group(function() {
        Route::get('/', [PositionController::class, 'index'])->name('index');
        Route::get('/create', [PositionController::class, 'create'])->name('create');
        Route::post('/', [PositionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PositionController::class, 'update'])->name('update');
        Route::delete('/{id}', [PositionController::class, 'destroy'])->name('destroy');
        
        // Import
        Route::post('/import', [PositionController::class, 'import'])->name('import');
        Route::get('/template', [PositionController::class, 'downloadTemplate'])->name('template');
    });
});
