<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;

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
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    // CRUD Acara
    Route::prefix('acara')->name('acara.')->group(function () {
        Route::get('/', [AcaraController::class, 'index'])->name('index');
        Route::get('/create', [AcaraController::class, 'create'])->name('create');
        Route::post('/', [AcaraController::class, 'store'])->name('store');
        Route::get('/{id_event}/edit', [AcaraController::class, 'edit'])->name('edit');
        Route::put('/{id_event}', [AcaraController::class, 'update'])->name('update');
        Route::delete('/{id_event}', [AcaraController::class, 'destroy'])->name('destroy');
        
        // Custom Tiket
        Route::get('/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('tiket');
        Route::put('/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('tiket.update');
    });

    // Profil Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    // Peserta & Check-In
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
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

