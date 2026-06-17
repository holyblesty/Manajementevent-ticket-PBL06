<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\pembeliancontroller as PendaftaranEventController;
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
    Route::get('/event/{id}/daftar',[PendaftaranEventController::class,'create'])->name('event.daftar');
    Route::post('/event/{id}/daftar',[PendaftaranEventController::class,'store'])->name('event.daftar.store');
   
    // Riwayat
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');

    // =====================================================
    // FITUR PROFIL BARU Sesuai Alur Desain Pembatasan Waktu
    // =====================================================
    
    // Halaman Profil Utama (Tampilan Read-only)
    Route::get('/profil', function () {
        return view('Pengunjung.profil');
    })->name('profil');

    // Halaman Form Edit Informasi Profil
    Route::get('/profil/edit', function () {
        $user = \App\Models\User::findOrFail(\Illuminate\Support\Facades\Auth::id());
        
        // Logika hitung mundur: Cek apakah user pernah update dalam 7 hari terakhir
        $bisaUpdate = true;
        $sisaHari = 0;
        if ($user->updated_at && $user->updated_at->diffInDays(now()) < 7) {
            $bisaUpdate = false;
            $sisaHari = 7 - $user->updated_at->diffInDays(now());
        }

        return view('Pengunjung.profil-edit', compact('user', 'bisaUpdate', 'sisaHari'));
    })->name('profil.edit');

    // Proses Simpan Update Informasi Profil (Validasi Seminggu Sekali)
    Route::put('/profil/update', function (\Illuminate\Http\Request $request) {
        $user = \App\Models\User::findOrFail(\Illuminate\Support\Facades\Auth::id());

        // Proteksi sisi server jika user mencoba bypass form html
        if ($user->updated_at && $user->updated_at->diffInDays(now()) < 7) {
            return redirect()->route('pengunjung.profil')->with('error', 'Anda hanya dapat mengubah informasi profil sekali seminggu.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        // Paksa updated_at ter-refresh ke waktu sekarang
        $user->touch(); 
        $user->save();

        return redirect()->route('pengunjung.profil')->with('success', 'Informasi profil berhasil diperbarui!');
    })->name('profil.update');

    // Halaman Form Ubah Password (Bebas Akses Kapan Saja)
    Route::get('/profil/password', function () {
        return view('Pengunjung.profil-password');
    })->name('profil.password');

    // Proses Simpan Ubah Password Baru
    Route::put('/profil/password/update', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // 'confirmed' otomatis mencocokkan input password_confirmation
        ], [
            'password.confirmed' => 'Konfirmasi ulang password tidak cocok.',
            'password.min' => 'Password minimal berukuran 8 karakter.'
        ]);

        $user = \App\Models\User::findOrFail(\Illuminate\Support\Facades\Auth::id());
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return redirect()->route('pengunjung.profil')->with('success', '🔒 Password Anda berhasil diubah!');
    })->name('profil.password.update');

    // =====================================================

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