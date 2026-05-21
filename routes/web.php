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

// Halaman awal langsung ke dashboard / welcome
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =====================================================
// FITUR AUTENTIKASI NYATA (LOGIN, REGISTER, LOGOUT)
// =====================================================

// Rute untuk Pengguna yang BELUM Login (Guest)
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

// Rute Logout (Bisa menangani logout dari session mana pun)
Route::middleware('auth:admin,web')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


// =====================================================
// ADMIN AREA
// =====================================================

Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Resource Acara (Handle: index, create, store, edit, update, destroy)
    Route::resource('acara', AcaraController::class);

    // 3. Custom Route untuk Tiket
    Route::get('/acara/{id}/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
    Route::put('/acara/{id}/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');

    // 4. Route Profile Admin
    Route::get('/profile', [AcaraController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AcaraController::class, 'updateProfile'])->name('profile.update');

    // 5. Route Kelola Peserta & Check-In (VERSI FIXED)
    Route::prefix('peserta')->name('peserta.')->group(function () {

        Route::get('/', [PesertaController::class, 'index'])
            ->name('index');

        // Check-in Individu
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])
            ->name('checkin_individu');

        // Check-in Anggota Tim
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])
            ->name('checkin_anggota');
    });
});

// Placeholder Login
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');


// ================= PENGUNJUNG AREA =================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard');
    })->name('dashboard');

    // Riwayat
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');

        Route::get('/profil', function () {
            return view('Pengunjung.profil');
        })->name('profil');

    // Halaman lain
    Route::get('/about', function () {
        return view('Pengunjung.about');
    })->name('about');


    // ================= CONTACT =================
    Route::get('/contact', function () {
        return view('Pengunjung.contact');
    })->name('contact');

    Route::get('/pembelian-tiket', function () {
        return view('Pengunjung.pembelian-tiket');
    })->name('pembelian');

});


// =====================================================
// LOGIN (TIDAK DIUBAH)
// =====================================================
Route::get('/login', function () {
    return "Halaman Login (Belum dibuat)";
})->name('login');