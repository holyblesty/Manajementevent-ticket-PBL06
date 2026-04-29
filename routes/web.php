<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;

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
    Route::resource('acara', AcaraController::class);

    // 3. Custom Route untuk Tiket
    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 4. Route Profile Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    // 5. Route Kelola Peserta & Check-In (VERSI FIXED)
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        
        // Route untuk Check-in Individu
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
        
        // Route untuk Check-in Anggota Tim (Accordion)
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });

});

// Placeholder Login
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');