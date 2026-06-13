<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\PendaftaranEventController;
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
    Route::get('/login', fn() => redirect()->route('home'));
    Route::get('/register', fn() => redirect()->route('home'));
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ADMIN AREA
// =====================================================
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
    
    Route::resource('acara', AcaraController::class);
    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    Route::get('/profile', [AdminDashboard::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminDashboard::class, 'updateProfile'])->name('profile.update');

    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
    });
});


    
// ================= PENGUNJUNG AREA =================
Route::prefix('pengunjung')->name('pengunjung.')->middleware('auth:web')->group(function () {

    // Dashboard
    Route::get('/dashboard',[PengunjungDashboardController::class, 'index'])->name('dashboard');
    
    // Halaman Event
     Route::get('/event/{id}',[EventController::class,'show'])->name('pengunjung.event.show');
   
    // Detail Event
    Route::get('/pengunjung/event/{id}',[EventController::class,'show'])->name('event.show');

    // Daftar Event
    Route::post('/pengunjung/daftar-event',[EventController::class,'daftarEvent'])->name('pengunjung.daftar-event');

    // Pendaftaran Event
    Route::get(
        '/event/{id}/daftar',
        [PendaftaranEventController::class, 'create']
    )->name('pengunjung.event.daftar');
   

    // Riwayat
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