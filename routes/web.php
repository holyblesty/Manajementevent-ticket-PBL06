<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// =====================================================
// CONTROLLER ADMIN & PENGUNJUNG
// =====================================================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\pengunjung\RiwayatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


// =====================================================
// AUTENTIKASI (JANGAN DIUBAH)
// =====================================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:admin,web')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// =====================================================
// ADMIN AREA (UTUH / TIDAK DIUBAH)
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Statistik Area
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    // 3. Resource Acara
    Route::resource('acara', AcaraController::class);

    // 4. Custom Route untuk Tiket
    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 5. Route Profile Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    // 6. Route Kelola Peserta & Check-In
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });
});


// =====================================================
// PENGUNJUNG AREA (FOKUS MOCKUP RIWAYAT PENDAFTARAN)
// =====================================================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Route ini langsung mengarah ke Controller Riwayat dummy yang dibuat sebelumnya
    Route::get('/riwayat-pendaftaran', [RiwayatController::class, 'index'])->name('riwayat');

});
// =====================================================
// PENGUNJUNG AREA (FOKUS MOCKUP RIWAYAT & PEMBELIAN)
// =====================================================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Route Riwayat Pendaftaran
    Route::get('/riwayat-pendaftaran', [RiwayatController::class, 'index'])->name('riwayat');

    // BARU: Route Pembelian Tiket menggunakan Controller
    Route::get('/pembelian-tiket', [\App\Http\Controllers\pengunjung\pembeliancontroller::class, 'index'])->name('pembelian');

});