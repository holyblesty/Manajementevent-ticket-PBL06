<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\ListKelompokController;
use App\Http\Controllers\Pengunjung\RiwayatController;

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
    Route::get('/login', function () {
        return view('welcome');
        })->name('login');

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
    });

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


    
// ================= PENGUNJUNG AREA =================
Route::prefix('pengunjung')->name('pengunjung.')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard',[PengunjungDashboardController::class, 'index'])->name('dashboard');
    
    // Halaman Event
    Route::get('/event', function () {
        return view('Pengunjung.show');
    })->name('event');
   
    // Detail Event
    Route::get( '/event/{id}', [EventController::class, 'show'] )->name('event.show');

    // Detail Tiket
    Route::get('/detail-tiket', function () {
        return view('Pengunjung.detail-tiket');
    })->name('detail-tiket');

    // Kelompok
    Route::get('/pengunjung/kelompok',[ListKelompokController::class, 'show'])->name('kelompok');
    Route::post('/pengunjung/kelompok/simpan',[ListKelompokController::class, 'simpan'])->name('kelompok.simpan');

    // Riwayat
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');
});