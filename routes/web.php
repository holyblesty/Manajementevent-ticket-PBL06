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
Route::prefix('admin')->group(function () {
    
    // 1. Dashboard (Daftar Acara)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 2. Tambah Acara
    Route::get('/acara/tambah', [DashboardController::class, 'create'])->name('admin.acara.create');
    Route::post('/acara/simpan', [DashboardController::class, 'store'])->name('admin.acara.store');

// Grouping rute admin supaya lebih rapi
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute utama Dashboard (Tabel Daftar Acara)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Resource untuk Acara (Otomatis handle: create, store, edit, update, destroy)
    Route::resource('acara', AcaraController::class);

});
});

// Placeholder Login
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');