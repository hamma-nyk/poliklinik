<?php

use App\Http\Controllers\ProfileController; // <--- Pastikan ini ada
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login'); // Redirect root ke login
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grouping untuk user yang sudah login
Route::middleware('auth')->group(function () {
    
    // --- FITUR BAWAAN BREEZE (Profile) ---
    // Bagian ini yang sebelumnya hilang menyebabkan error profile.edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- FITUR MANAJEMEN USER (RBAC) ---
    // Hanya bisa diakses oleh Superadmin (role:superadmin)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('permissions', PermissionController::class); // <--- INI
    });

    Route::prefix('settings')->group(function () {
        Route::get('/whatsapp', [App\Http\Controllers\WhatsAppController::class, 'index'])->name('settings.whatsapp');
    });

});

require __DIR__.'/auth.php';