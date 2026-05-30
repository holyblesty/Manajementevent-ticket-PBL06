<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

    // =====================================================
    // DASHBOARD
    // =====================================================
    Route::get('/dashboard', function () {
        return view('Pengunjung.dashboard');
    })->name('dashboard');


    // =====================================================
    // RIWAYAT PENDAFTARAN
    // =====================================================
    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat');

    Route::get('/riwayat/{id}', [RiwayatController::class, 'detail'])
        ->name('riwayat.detail');


    // =====================================================
    // DETAIL TIKET (DUMMY TANPA DATABASE)
    // =====================================================
    Route::get('/detail-tiket', function () {

        return view('Pengunjung.detail-tiket', [

            'ticket' => [

                'nama'              => 'Jesina Holy',
                'email'             => 'jesina@gmail.com',
                'telepon'           => '081234567890',
                'jenis_tiket'       => 'VIP',
                'jumlah_tiket'      => 1,
                'harga_tiket'       => 150000,
                'biaya_layanan'     => 5000,
                'total'             => 155000,

                'event' => [
                    'nama_event'       => 'AI & MASA DEPAN KITA TECH FORUM 2024',
                    'tanggal_event'    => 'Kamis, 29 Mei 2024',
                    'jam_event'        => '09.00 - 17.00 WIB',
                    'lokasi'           => 'Gedung Utama',
                    'alamat'           => 'Jl. Teknologi No.1, Bandung',
                    'tanggal_beli'     => '20 Mei 2024',
                    'status'           => 'Akan Datang',
                    'kode_tiket'       => 'EVT-290524-001',
                ]

            ]

        ]);

    })->name('detail-tiket');


    // =====================================================
    // E-TIKET
    // =====================================================
    Route::get('/riwayat/{id}/etiket', [RiwayatController::class, 'etiket'])
        ->name('etiket');


    // =====================================================
    // PROFIL
    // =====================================================
    Route::get('/profil', function () {
        return view('Pengunjung.profil');
    })->name('profil');


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


    // =====================================================
    // PEMBELIAN TIKET
    // =====================================================
    Route::get('/pembelian-tiket', function () {
        return view('Pengunjung.pembelian-tiket');
    })->name('pembelian');

});

