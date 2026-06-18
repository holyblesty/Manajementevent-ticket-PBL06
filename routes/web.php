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
use App\Http\Controllers\Pengunjung\PendaftaranEventController;
use App\Http\Controllers\Pengunjung\pembeliancontroller; // Import pembeliancontroller untuk tiket
use App\Http\Controllers\Pengunjung\ProfilController;    // Import ProfilController untuk profil pengunjung
use App\Http\Controllers\Pengunjung\RiwayatController;   // Import RiwayatController untuk riwayat pengunjung
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

    // CRUD Utama untuk Acara
    Route::resource('acara', AcaraController::class)->except(['show']);

    // Manajemen Tiket Massal
    Route::prefix('acara/{id_event}')->group(function () {
        Route::get('/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
        Route::put('/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');
    });

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
Route::middleware('auth:web')->prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Dashboard Pengunjung
    Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])->name('dashboard');

    // Halaman Detail Event & Daftar Event Default
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::post('/daftar-event', [EventController::class, 'daftarEvent'])->name('daftar-event');

    // PERBAIKAN: Menyamakan class pendaftaran menjadi PendaftaranEventController
    Route::get('/pendaftaran/{id_event}', [PendaftaranEventController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran/{id_event}', [PendaftaranEventController::class, 'store'])->name('pendaftaran.store');
    
    // PERBAIKAN: Mengarahkan Route Pembelian Tiket ke pembeliancontroller (bukan sekadar view kosong)
    Route::get('/pembelian-tiket/{id}', [pembeliancontroller::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian-tiket/{id}', [pembeliancontroller::class, 'store'])->name('pembelian.store');

    // PERBAIKAN: Mengarahkan profil ke ProfilController asli (bukan view statis) agar data dinamis berfungsi
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/foto', [ProfilController::class, 'updateFoto'])->name('profil.foto');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
    Route::delete('/profil/hapus', [ProfilController::class, 'destroy'])->name('profil.destroy');

    // PERBAIKAN: Mengarahkan riwayat ke RiwayatController asli
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
});