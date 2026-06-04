<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// =====================================================
// CONTROLLER ADMIN
// =====================================================

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PesananController;

// =====================================================
// CONTROLLER PENGUNJUNG
// =====================================================

use App\Http\Controllers\Pengunjung\ProfilController;
use App\Http\Controllers\Pengunjung\PembelianController;
use App\Http\Controllers\Pengunjung\RiwayatController;
use App\Http\Controllers\Pengunjung\DetailTiketController;
use App\Http\Controllers\Pengunjung\HomeController;
use App\Http\Controllers\Pengunjung\TiketController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // =====================================================
    // REGISTER
    // =====================================================

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    // =====================================================
    // LOGIN
    // =====================================================

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin,web')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});

/*
|--------------------------------------------------------------------------
| PUBLIK - Acara bisa diakses tanpa login
|--------------------------------------------------------------------------
*/

Route::get('/acara', [HomeController::class, 'acara'])
    ->name('pengunjung.acara');

Route::get('/acara/{event}', [HomeController::class, 'detailAcara'])
    ->name('pengunjung.acara.detail');

Route::get('/tentang-kami', [HomeController::class, 'tentangKami'])
    ->name('pengunjung.tentang-kami');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // =====================================================
    // DASHBOARD ADMIN
    // =====================================================

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =====================================================
    // STATISTIK
    // =====================================================

    Route::get('/statistik', [StatistikController::class, 'index'])
        ->name('statistik');

    // =====================================================
    // CRUD ACARA / EVENT
    // =====================================================

    Route::resource('acara', AcaraController::class);

    // =====================================================
    // KELOLA TIKET PER ACARA
    // =====================================================

    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])
        ->name('acara.tiket');

    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])
        ->name('acara.tiket.update');

    // =====================================================
    // PROFILE ADMIN
    // =====================================================

    Route::get('/profile', [AcaraController::class, 'profile'])
        ->name('profile');

    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])
        ->name('profile.update');

    // =====================================================
    // KELOLA PESERTA
    // =====================================================

    Route::prefix('peserta')->name('peserta.')->group(function () {

        Route::get('/', [PesertaController::class, 'index'])
            ->name('index');

        Route::get('/detail/{id}', [PesertaController::class, 'detail'])
            ->name('detail');

        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])
            ->name('checkin_individu');

        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])
            ->name('checkin_anggota');

    });

    // =====================================================
    // KELOLA PENGGUNA (dari TiketController sebelumnya)
    // =====================================================

    Route::resource('users', UserController::class);

    // =====================================================
    // KELOLA PESANAN (dari PesananController sebelumnya)
    // =====================================================

    Route::resource('pesanans', PesananController::class)
        ->except(['create', 'store', 'edit', 'update']);

    Route::patch('/pesanans/{pesanan}/confirm', [PesananController::class, 'confirm'])
        ->name('pesanans.confirm');

    Route::patch('/pesanans/{pesanan}/cancel', [PesananController::class, 'cancel'])
        ->name('pesanans.cancel');

});

/*
|--------------------------------------------------------------------------
| PENGUNJUNG AREA
|--------------------------------------------------------------------------
*/

Route::prefix('pengunjung')
    ->name('pengunjung.')
    ->group(function () {

    // =====================================================
    // DASHBOARD PENGUNJUNG
    // =====================================================

    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard');
    })->name('dashboard');

    // =====================================================
    // BERANDA / HOME PENGUNJUNG
    // =====================================================

    Route::get('/beranda', [HomeController::class, 'beranda'])
        ->name('beranda');

    // =====================================================
    // PROFIL PENGUNJUNG
    // =====================================================

    Route::prefix('profil')
        ->name('profil.')
        ->group(function () {

        // HALAMAN PROFIL
        Route::get('/', [ProfilController::class, 'index'])
            ->name('index');

        // UPDATE PROFIL
        Route::put('/', [ProfilController::class, 'update'])
            ->name('update');

        // UPDATE FOTO PROFIL
        Route::post('/foto', [ProfilController::class, 'updateFoto'])
            ->name('foto');

        // UPDATE PASSWORD
        Route::put('/password', [ProfilController::class, 'updatePassword'])
            ->name('password');

        // HAPUS AKUN
        Route::delete('/', [ProfilController::class, 'destroy'])
            ->name('destroy');

    });

    // =====================================================
    // RIWAYAT PENDAFTARAN
    // =====================================================

    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat');

    // =====================================================
    // DETAIL TIKET
    // =====================================================

    Route::get('/detail-tiket/{id}', [DetailTiketController::class, 'index'])
        ->name('detail-tiket');

    // =====================================================
    // TIKET SAYA (confirmed)
    // =====================================================

    Route::get('/tiket-saya', [TiketController::class, 'tiketSaya'])
        ->name('tiket-saya');

    // =====================================================
    // HALAMAN PEMBELIAN TIKET
    // =====================================================

    Route::get('/pembelian-tiket/{id}', [PembelianController::class, 'index'])
        ->name('pembelian');

    // =====================================================
    // SIMPAN PEMBELIAN
    // =====================================================

    Route::post('/pembelian/store', [PembelianController::class, 'store'])
        ->name('pembelian.store');

    // =====================================================
    // UPDATE / EDIT PEMBELIAN (hanya jika masih pending)
    // =====================================================

    Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit'])
        ->name('pembelian.edit');

    Route::put('/pembelian/update/{id}', [PembelianController::class, 'update'])
        ->name('pembelian.update');

    // =====================================================
    // BATALKAN PEMBELIAN (patch, ubah status jadi cancelled)
    // =====================================================

    Route::patch('/pembelian/cancel/{id}', [PembelianController::class, 'cancel'])
        ->name('pembelian.cancel');

    // =====================================================
    // HAPUS PEMBELIAN (hanya jika sudah cancelled)
    // =====================================================

    Route::delete('/pembelian/delete/{id}', [PembelianController::class, 'destroy'])
        ->name('pembelian.delete');

    // =====================================================
    // HALAMAN SUKSES SETELAH BELI TIKET
    // =====================================================

    Route::get('/pembelian/sukses/{id}', [PembelianController::class, 'sukses'])
        ->name('pembelian.sukses');

    // =====================================================
    // ABOUT
    // =====================================================

    Route::get('/about', function () {
        return view('Pengunjung.about');
    })->name('about');

    // =====================================================
    // CONTACT
    // =====================================================

    Route::get('/contact', function () {
        return view('Pengunjung.contact');
    })->name('contact');

});
