<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal langsung ke dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ================= ADMIN AREA =================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Resource Acara (Handle: index, create, store, edit, update, destroy)
    // URL: admin/acara, admin/acara/create, dsb.
    Route::resource('acara', AcaraController::class);

    // 3. Custom Route untuk Tiket (Karena tidak ada di resource default)
    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 4. Route Profile Admin
    // URL: admin/profile
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

});

// Placeholder Login
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');