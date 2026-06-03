<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\ProfileController;
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

// Logout bisa diakses oleh siapa saja yang login (admin atau web)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:admin,web');

// =====================================================
// ADMIN AREA (HANYA UNTUK ADMIN)
// =====================================================
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    Route::resource('acara', AcaraController::class);

    Route::get('/acara/{id_event}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id_event}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });
});
     
// ================= PENGUNJUNG AREA (HANYA UNTUK PENGUNJUNG) =================
Route::middleware(['auth:web'])->prefix('pengunjung')->name('pengunjung.')->group(function () {
    Route::get('/dashboard', function () { return view('Pengunjung.dashboard'); })->name('dashboard');
    Route::get('/riwayat', function () { return view('Pengunjung.riwayat'); })->name('riwayat');
    Route::get('/profil', function () { return view('Pengunjung.profil'); })->name('profil');
    Route::get('/about', function () { return view('Pengunjung.about'); })->name('about');
    Route::get('/contact', function () { return view('Pengunjung.contact'); })->name('contact');
    Route::get('/pembelian-tiket', function () { return view('Pengunjung.pembelian-tiket'); })->name('pembelian');
});