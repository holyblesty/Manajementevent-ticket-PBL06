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

        // CHECK IN INDIVIDU (Disamakan dengan Blade: checkin_individu)
        Route::match(['get', 'post'], '/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])
            ->name('checkin_individu');

        // CHECK IN ANGGOTA TIM (Disamakan dengan Blade: checkin_anggota)
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