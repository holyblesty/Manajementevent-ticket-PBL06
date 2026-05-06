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

// Halaman awal langsung ke dashboard admin
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ================= ADMIN AREA =================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Resource Acara
    Route::resource('acara', AcaraController::class);

    // 3. Custom Route Tiket
    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 4. Profile Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    // 5. Peserta
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');

        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');

        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });

});

// ================= AUTH =================
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');


// ================= PENGUNJUNG AREA =================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard');
    })->name('dashboard');

    // Riwayat
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');

    // Profil
    Route::get('/profil', function () {
        return view('Pengunjung.profil');
    })->name('profil');

    // Halaman lain
    Route::get('/about', function () {
        return view('Pengunjung.about');
    })->name('about');

    Route::get('/contact', function () {
        return view('Pengunjung.contact');
    })->name('contact');

    Route::get('/pembelian-tiket', function () {
        return view('Pengunjung.pembelian-tiket');
    })->name('pembelian');

});