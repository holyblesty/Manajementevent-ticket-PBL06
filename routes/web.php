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
// AUTENTIKASI
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
// ADMIN AREA
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Utama (Mengaktifkan DashboardController sesuai konsep MVC)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Statistik Area
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    // 3. Resource Acara (Handle: index, create, store, edit, update, destroy)
    Route::resource('acara', AcaraController::class);

    // 4. Custom Route untuk Tiket (FIXED: Menggunakan {id_event} sesuai Database)
    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 5. Route Profile Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

// 6. Route Kelola Peserta & Check-In (SUDAH DIPERBAIKI)
Route::prefix('peserta')->name('peserta.')->group(function () {
    // Memanggil method 'index', bukan 'peserta'
    Route::get('/', [PesertaController::class, 'index'])->name('index');
    
    // Route Detail
    Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
    
    // Route Check-In
    Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
    Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });

});

      
// ================= PENGUNJUNG AREA =================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Dashboard Pengunjung
    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard');
    })->name('dashboard');

    // Riwayat Pemesanan
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');

    // Profil Pengunjung
    Route::get('/profil', function () {
        return view('Pengunjung.profil');
    })->name('profil');

    // Halaman Informasi Umum
    Route::get('/about', function () {
        return view('Pengunjung.about');
    })->name('about');

        Route::get('/contact', function () {
            return view('Pengunjung.contact');
        })->name('contact');

    // Halaman Pembelian Tiket
    Route::get('/pembelian-tiket', function () {
        return view('Pengunjung.pembelian-tiket');
    })->name('pembelian');
});