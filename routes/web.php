<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\Pembeliancontroller;
use App\Http\Controllers\Pengunjung\ProfilController;
use App\Http\Controllers\Pengunjung\RiwayatController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Publik
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'tentang'])->name('pengunjung.tentang');
Route::get('/contact', [PageController::class, 'kontak'])->name('pengunjung.kontak');
Route::get('/search', [PageController::class, 'search'])->name('pengunjung.search');

// =====================================================
// AUTENTIKASI
// =====================================================
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ADMIN AREA
// =====================================================
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    Route::resource('acara', AcaraController::class);
    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // Profil Admin
    Route::get('/profile', [AdminDashboard::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminDashboard::class, 'updateProfile'])->name('profile.update');

    // Manajemen Peserta & Check-In
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
    });
});

// =====================================================
// PENGUNJUNG AREA 
// =====================================================
Route::middleware(['auth:web'])->prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Dashboard Pengunjung
    Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])->name('dashboard');

    // Detail Event
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');

    // PEMBELIAN TIKET
     Route::get('/pembelian-tiket/{id}', [PembelianController::class, 'index'])->name('pembelian.index');

    // Simpan transaksi pembelian
    Route::post('/pembelian-tiket', [PembelianController::class, 'store'])->name('pembelian.store');

    //RIWAYAT PENDAFTARAN
     Route::get('/riwayat-pendaftaran', [RiwayatController::class, 'index'])->name('riwayat');

    //PROFIL
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');

    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');

    Route::get('/profil/password', [ProfilController::class, 'passwordForm'])->name('profil.password');

    Route::put('/profil/password/update', [ProfilController::class, 'updatePassword'])->name('profil.password.update');
});