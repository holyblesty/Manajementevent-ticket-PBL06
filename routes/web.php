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

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:admin,web')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
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

    // 5. Route Kelola Peserta & Check-In (VERSI FIXED)
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        
        // Route untuk Check-in Individu
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
        
        // Route untuk Check-in Anggota Tim (Accordion)
        Route::post('/checkin-anggota/{eventId}/{regId}/{memberIndex}', [PesertaController::class, 'checkInAnggota'])->name('checkin_anggota');
    });
});


      
// ================= PENGUNJUNG AREA =================
Route::prefix('pengunjung')->name('pengunjung.')->group(function () {

    // Dashboard Pengunjung
    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard.index');
    })->name('dashboard');

    // Event
    Route::get('/event', function () {
        return view('pengunjung.event.index');
    })->name('home');

    // Detail Event
    Route::get('/event/detail', function () {
        return view('pengunjung.event.detail');
    })->name('event.detail');

    //REGISTRATION 
    // Registration Event Kelompok
    Route::get('/registration/kelompok', function () {
        return view('pengunjung.registration.kelompok');
    })->name('registration.kelompok');

    // Registration Event Individu
    Route::get('/registration/individu', function () {
        return view('pengunjung.registration.individu');
    })->name('registration.individu');

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

        Route::get('/pembelian-tiket', function () {
            return view('Pengunjung.pembelian-tiket');
        })->name('pembelian');
});

