<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\pengunjung\RiwayatController;
use App\Http\Controllers\pengunjung\pembeliancontroller;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =====================================================
// AUTENTIKASI
// =====================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => redirect()->route('home'));
    Route::get('/register', fn() => redirect()->route('home'));
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Logout diizinkan untuk siapa saja yang login (baik admin maupun user)
// Kita hapus middleware('auth') agar tidak memblokir akses logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ADMIN AREA
// =====================================================
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
    
    // Resource Acara
    Route::resource('acara', AcaraController::class);
    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // PERBAIKAN: Arahkan ke controller yang tepat (Misal DashboardController jika ingin digabung)
    // Atau buat controller khusus AdminProfileController nanti.
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

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
    Route::get('/riwayat-pendaftaran', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/pembelian-tiket', [pembeliancontroller::class, 'index'])->name('pembelian');
});