<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal tetap ke ADMIN (TIDAK DIUBAH)
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});


// =====================================================
// ADMIN AREA (TIDAK DIUBAH)
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('acara', AcaraController::class);

    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
        
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });
});


// =====================================================
// PENGUNJUNG AREA (SUDAH DISESUAIKAN)
// =====================================================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // ✅ BERANDA (INI YANG KITA BUAT DARI MOCKUP)
    Route::get('/beranda', function () {
        return view('pengunjung'); // file: resources/views/pengunjung.blade.php
    })->name('beranda');


    // Dashboard lama (kalau masih mau dipakai)
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


    // About
    Route::get('/about', function () {
        return view('Pengunjung.about');
    })->name('about');


    // Contact
    Route::get('/contact', function () {
        return view('Pengunjung.contact');
    })->name('contact');


    // Pembelian Tiket
    Route::get('/pembelian-tiket', function () {
        return view('Pengunjung.pembelian-tiket');
    })->name('pembelian');

});


// =====================================================
// LOGIN (TIDAK DIUBAH)
// =====================================================
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');