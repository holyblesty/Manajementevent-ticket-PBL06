<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;

use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\PembelianController;
use App\Http\Controllers\Pengunjung\ProfilController;
use App\Http\Controllers\Pengunjung\RiwayatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================================================
// HALAMAN PUBLIK
// =====================================================

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'tentang'])->name('pengunjung.tentang');
Route::get('/contact', [PageController::class, 'kontak'])->name('pengunjung.kontak');
Route::get('/search', [PageController::class, 'search'])->name('pengunjung.search');


// =====================================================
// AUTH
// =====================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================================================
// ADMIN
// =====================================================

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

        Route::resource('acara', AcaraController::class);

        Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])
            ->name('acara.tiket');

        Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])
            ->name('acara.tiket.update');

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::put('/profile/update', [ProfileController::class, 'update'])
            ->name('profile.update');

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


// =====================================================
// PENGUNJUNG
// =====================================================

Route::middleware('auth:web')
    ->prefix('pengunjung')
    ->name('pengunjung.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/tiket', [PengunjungDashboardController::class, 'tiket'])
            ->name('tiket');

        // Detail Event
        Route::get('/event/{id}', [EventController::class, 'show'])
            ->name('event.show');

        // ==========================
        // PEMBELIAN TIKET
        // ==========================

        Route::get('/pembelian/{id_event}', [PembelianController::class, 'index'])
            ->name('pembelian');

        Route::post('/pembelian', [PembelianController::class, 'store'])
            ->name('pembelian.store');

        Route::get('/pembelian/sukses/{id}', [PembelianController::class, 'sukses'])
            ->name('pembelian.sukses');

        Route::get('/tiket-saya', [PembelianController::class, 'tiketSaya'])
            ->name('tiket.saya');

        Route::get('/tiket/{id}', [PembelianController::class, 'detailTiket'])
            ->name('tiket.detail');

        // Riwayat
        Route::get('/riwayat', [RiwayatController::class, 'index'])
            ->name('riwayat');

        // Profil
        Route::prefix('profil')
            ->name('profil.')
            ->group(function () {

                Route::get('/', [ProfilController::class, 'index'])
                    ->name('index');

                Route::get('/edit', [ProfilController::class, 'edit'])
                    ->name('edit');

                Route::put('/update', [ProfilController::class, 'update'])
                    ->name('update');

                Route::get('/password', [ProfilController::class, 'editPassword'])
                    ->name('password');

                Route::put('/password/update', [ProfilController::class, 'updatePassword'])
                    ->name('password.update');
            });
    });
