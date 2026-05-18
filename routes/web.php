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

// Rute Logout (Harus sudah login baru bisa logout)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// =====================================================
// ADMIN AREA (Hanya Bisa Diakses Jika Sudah Login)
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Utama (Ditumpuk langsung ke AcaraController agar data $events langsung tampil otomatis)
    Route::get('/dashboard', [AcaraController::class, 'index'])->name('dashboard');

    // 1b. Statistik
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    // 2. Resource Acara (Handle: index, create, store, edit, update, destroy)
    Route::resource('acara', AcaraController::class);

    // 3. Custom Route untuk Tiket
    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 4. Route Profile Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    // 5. Route Kelola Peserta & Check-In (VERSI MASTER-DETAIL)
    Route::prefix('peserta')->name('peserta.')->group(function () {
        
        // Halaman List Event
        Route::get('/', [PesertaController::class, 'index'])->name('index');

        // Detail Peserta
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        
        // Route Check-in
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });
});

// =====================================================
// PENGUNJUNG AREA (Akses Halaman Pengunjung)
// =====================================================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard');
    })->name('dashboard');

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