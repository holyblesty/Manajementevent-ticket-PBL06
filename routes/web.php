<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\pengunjung\RiwayatController;
use App\Http\Controllers\pengunjung\PembelianController; // Pastikan menggunakan PascalCase

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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ADMIN AREA (Tidak Ada Perubahan)
// =====================================================
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
    
    Route::resource('acara', AcaraController::class);
    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    $adminDashboardClass = AdminDashboard::class;
    Route::get('/profile', [$adminDashboardClass, 'profile'])->name('profile');
    Route::put('/profile/update', [$adminDashboardClass, 'updateProfile'])->name('profile.update');

    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
    });
});

// =====================================================
// PENGUNJUNG AREA (Sudah Dirapikan & Digabungkan)
// =====================================================
Route::middleware(['auth:web'])->prefix('pengunjung')->name('pengunjung.')->group(function () {
    
    // Dashboard Pengunjung
    Route::get('/dashboard', function () {
        return view('pengunjung.dashboard'); 
    })->name('dashboard');
    
    // Riwayat Pendaftaran / Transaksi
    Route::get('/riwayat-pendaftaran', [RiwayatController::class, 'index'])->name('riwayat');
    
    // Transaksi Pembelian Tiket (Berdasarkan ID Event)
    // URL: /pengunjung/pembelian-tiket/{id} | Nama Route: pengunjung.pembelian.index
    Route::get('/pembelian-tiket/{id}', [PembelianController::class, 'index'])->name('pembelian.index');
    
    // Proses Simpan Transaksi ke Database
    // URL: /pengunjung/pembelian-tiket | Nama Route: pengunjung.pembelian.store
    Route::post('/pembelian-tiket', [PembelianController::class, 'store'])->name('pembelian.store');
});