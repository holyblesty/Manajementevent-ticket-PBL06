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
use App\Http\Controllers\Pengunjung\PendaftaranController;
use App\Http\Controllers\Pengunjung\ProfilController;
use App\Http\Controllers\pengunjung\pembeliancontroller;


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
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.view');
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
Route::prefix('pengunjung')->name('pengunjung.')->middleware('auth:web')->group(function () {

    // Dashboard Pengunjung
    Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])->name('dashboard');
    Route::get('/tiket', [PengunjungDashboardController::class, 'tiket'])->name('tiket');

    // Halaman Event
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::post('/daftar-event', [EventController::class, 'daftarEvent'])->name('daftar-event');

    Route::get('/event/{id_event}/daftar', [PendaftaranController::class, 'index'])->name('pendaftaran');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Riwayat
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');

    // Profil (Hanya satu kali pembungkusan)

    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfilController::class, 'update'])->name('update');
        Route::get('/password', [ProfilController::class, 'editPassword'])->name('password');
        Route::put('/password/update', [ProfilController::class, 'updatePassword'])->name('password.update');
    });
});
