<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController; // 1. Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================================================
// HALAMAN AWAL
// =====================================================
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// =====================================================
// ADMIN AREA
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ================= STATISTIK =================
    // 2. Tambahkan route statistik di sini
    Route::get('/statistik', [StatistikController::class, 'index'])
        ->name('statistik');

    // ================= RESOURCE ACARA =================
    Route::resource('acara', AcaraController::class);

    // ================= TIKET =================
    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])
        ->name('acara.tiket');

    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])
        ->name('acara.tiket.update');

    // ================= PROFILE =================
    Route::get('/profile', [AcaraController::class, 'profile'])
        ->name('profile');

    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])
        ->name('profile.update');

    // =====================================================
    // KELOLA PESERTA
    // =====================================================
    Route::prefix('peserta')->name('peserta.')->group(function () {

        // HALAMAN LIST EVENT
        Route::get('/', [PesertaController::class, 'index'])
            ->name('index');

        // HALAMAN DETAIL EVENT
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])
            ->name('detail');

        // CHECK IN INDIVIDU
        Route::match(['get', 'post'], '/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])
            ->name('checkin_individu');

        // CHECK IN ANGGOTA TIM
        Route::match(['get', 'post'], '/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])
            ->name('checkin_anggota');
    });
});

// =====================================================
// LOGIN PLACEHOLDER
// =====================================================
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');