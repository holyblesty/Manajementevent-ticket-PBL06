<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\VerifikasiController;

use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\PembelianController;
use App\Http\Controllers\Pengunjung\ProfilController;
use App\Http\Controllers\Pengunjung\RiwayatController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'tentang'])
    ->name('pengunjung.tentang');

Route::get('/contact', [PageController::class, 'kontak'])
    ->name('pengunjung.kontak');

Route::get('/search', [PageController::class, 'search'])
    ->name('pengunjung.search');

Route::get('/event/{id}', [EventController::class, 'show'])
    ->name('event.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login.view');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])
            ->name('dashboard');

        // Statistik
        Route::get('/statistik', [StatistikController::class, 'index'])
            ->name('statistik');

        // Acara
        Route::resource('acara', AcaraController::class);

        Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])
            ->name('acara.tiket');

        Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])
            ->name('acara.tiket.update');

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::put('/profile/update', [ProfileController::class, 'update'])
            ->name('profile.update');

        // =========================
        // VERIFIKASI
        // =========================

        Route::get('/verifikasi', [VerifikasiController::class, 'index'])
            ->name('verifikasi');

        Route::put('/verifikasi/{id}/acc', [VerifikasiController::class, 'acc'])
            ->name('verifikasi.acc');

        Route::put('/verifikasi/{id}/tolak', [VerifikasiController::class, 'tolak'])
            ->name('verifikasi.tolak');

        // =========================
        // PESERTA
        // =========================

        Route::prefix('peserta')
            ->name('peserta.')
            ->group(function () {

                Route::get('/', [PesertaController::class, 'index'])
                    ->name('index');

                Route::get('/detail/{id}', [PesertaController::class, 'detail'])
                    ->name('detail');

                Route::put('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])
                    ->name('checkin_individu');
            });

    });

/*
|--------------------------------------------------------------------------
| PENGUNJUNG
|--------------------------------------------------------------------------
*/

Route::middleware('auth:web')
    ->prefix('pengunjung')
    ->name('pengunjung.')
    ->group(function () {

        Route::post('/pembelian-tiket', [PembelianController::class, 'store'])
            ->name('pembelian.store');

        Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/pembelian/{id_event}', [PembelianController::class, 'index'])
            ->name('pembelian');

        Route::post('/pembelian', [PembelianController::class, 'store'])
            ->name('pembelian.store');

        Route::get('/pembelian/sukses/{id}', [PembelianController::class, 'sukses'])
            ->name('pembelian.sukses');

        Route::get('/tiket', [PembelianController::class, 'tiketSaya'])
            ->name('tiket');

        Route::get('/tiket/{id}', [PembelianController::class, 'detailTiket'])
            ->name('tiket.detail');

        Route::get('/riwayat', [RiwayatController::class, 'index'])
            ->name('riwayat');

        Route::get('/profil', [ProfilController::class, 'index'])
            ->name('profil');

        Route::get('/profil/edit', [ProfilController::class, 'edit'])
            ->name('profil.edit');

        Route::put('/profil/update', [ProfilController::class, 'update'])
            ->name('profil.update');

        Route::get('/profil/password', [ProfilController::class, 'editPassword'])
            ->name('profil.password');

        Route::put('/profil/password/update', [ProfilController::class, 'updatePassword'])
            ->name('profil.password.update');
    });