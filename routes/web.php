<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================================================
// HALAMAN AWAL (Membuka welcome.blade.php Pertama Kali)
// =====================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =====================================================
// FITUR AUTENTIKASI NYATA (LOGIN, REGISTER, LOGOUT)
// =====================================================
// Rute untuk Pengguna yang BELUM Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute Logout (Bisa menangani logout dari session mana pun)
Route::middleware('auth:admin,web')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// =====================================================
// ADMIN AREA (Sudah Login via Guard Admin)
// =====================================================
Route::middleware(['auth:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // 1. Dashboard Utama
        Route::get('/dashboard', [AcaraController::class, 'index'])->name('dashboard');

        // 1b. Statistik
        Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

        // 2. Resource Acara
        Route::resource('acara', AcaraController::class);

        // 3. Custom Route untuk Tiket
        Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
        Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

        // 4. Route Profile Admin
        Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

        // 5. Route Kelola Peserta & Check-In (VERSI MASTER-DETAIL)
        Route::prefix('peserta')->name('peserta.')->group(function () {
            Route::get('/', [PesertaController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
            Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
            Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
        });
});

// =====================================================
// PENGUNJUNG AREA (Sudah Login via Guard Web/Default)
// =====================================================
Route::middleware(['auth:web'])
    ->prefix('pengunjung')
    ->name('pengunjung.')
    ->group(function () {

        Route::get('/', function () {
            return view('dashboard.index');
        });

        Route::get('/riwayat', function () {
            return view('Pengunjung.riwayat');
        })->name('riwayat');

        Route::get('/profil', function () {
            return view('Pengunjung.profil');
        })->name('profil');

        Route::get('/about', function () {
            return view('Pengunjung.about');
        })->name('about');

        Route::get('/contact', function () {
            return view('Pengunjung.contact');
        })->name('contact');

        Route::get('/pembelian-tiket', function () {
            return view('Pengunjung.pembelian-tiket');
        })->name('pembelian');
});

//PENGUNJUNG menuju dashboard

Route::get('/pengunjung/dashboard', function () {
    return view('pengunjung.dashboard.index');
})->name('pengunjung.dashboard');