<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\EventController;
use App\Http\Controllers\Pengunjung\PendaftaranController;
use App\Http\Controllers\pengunjung\pembeliancontroller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Publik
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'tentang'])->name('pengunjung.tentang');
Route::get('/contact', [PageController::class, 'kontak'])->name('pengunjung.kontak');
Route::get('/search', [PageController::class, 'search'])->name('pengunjung.search');
// =====================================================
// AUTENTIKASI
// =====================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.view');
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

    // CRUD Utama untuk Acara
    Route::resource('acara', AcaraController::class)->except(['show']);

    // Manajemen Tiket Massal
    Route::prefix('acara/{id_event}')->group(function () {
        Route::get('/tiket', [AcaraController::class, 'tiket'])->name('acara.tiket');
        Route::put('/tiket/update', [AcaraController::class, 'updateTiket'])->name('acara.tiket.update');
    });

    // Profil Admin
    Route::get('/profile', [AdminDashboard::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminDashboard::class, 'updateProfile'])->name('profile.update');

    // Manajemen Peserta & Check-In
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [PesertaController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [PesertaController::class, 'detail'])->name('detail');
        Route::post('/checkin-individu/{eventId}/{regId}', [PesertaController::class, 'checkInIndividu'])->name('checkin_individu');
    });
});

// =====================================================
// PENGUNJUNG AREA
// =====================================================
Route::prefix('pengunjung')->name('pengunjung.')->middleware('auth:web')->group(function () {

    // Dashboard Pengunjung
    Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])->name('dashboard');

    // Halaman tiket saya
    Route::get('/tiket', [PengunjungDashboardController::class, 'tiket'])->name('tiket');

    // Halaman Event Pengunjung
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::post('/daftar-event', [EventController::class, 'daftarEvent'])->name('daftar-event');

    // Halaman pendaftaran Event
    Route::get('/event/{id_event}/daftar', [PendaftaranController::class])
        ->name('pendaftaran');

    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');

    // Riwayat & Profil
    Route::get('/riwayat', function () {
        return view('Pengunjung.riwayat');
    })->name('riwayat');

    Route::get('/profil', function () {
        return view('Pengunjung.profil');
    })->name('profil');

    // 2. Form Alihan Mengubah Informasi Profil
    Route::get('/profil/edit', function () {
        // Menggunakan \App\Models\User karena data login merujuk ke tabel users kelompok Anda
        $user = \App\Models\Pengunjung::findOrFail(\Illuminate\Support\Facades\Auth::id());

        // Logika Pengaman: Cek jika user pernah update data dalam kurun waktu 7 hari terakhir
        $bisaUpdate = true;
        $sisaHari = 0;
        if ($user->updated_at && $user->updated_at->diffInDays(now()) < 7) {
            $bisaUpdate = false;
            $sisaHari = 7 - $user->updated_at->diffInDays(now());
        }

        return view('pengunjung.profil-edit', compact('user', 'bisaUpdate', 'sisaHari'));
    })->name('profil.edit');

    // 3. Proses Validasi & Simpan Perubahan Informasi Profil (Sisi Server)
    Route::put('/profil/update', function (\Illuminate\Http\Request $request) {
        $user = \App\Models\Pengunjung::findOrFail(\Illuminate\Support\Facades\Auth::id());

        // Antisipasi lapis kedua jika user menembak route langsung tanpa lewat tombol form
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

        // Memaksa sistem memperbarui record timestamp updated_at ke waktu sekarang sebagai acuan hitungan hari
        $user->touch();
        $user->save();

        return redirect()->route('pengunjung.profil')->with('success', 'Informasi pribadi Anda berhasil diperbarui!');
    })->name('profil.update');

    // 4. Form Alihan Mengubah Kata Sandi / Password (Bebas Kapan Saja)
    Route::get('/profil/password', function () {
        return view('pengunjung.profil-password');
    })->name('profil.password');

    // 5. Proses Enkripsi Hash & Update Password Baru ke Database
    Route::put('/profil/password/update', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // 'confirmed' otomatis mencocokkan input password_confirmation
        ], [
            'password.confirmed' => 'Konfirmasi ulang kata sandi baru tidak cocok.',
            'password.min' => 'Keamanan kata sandi minimal harus berisi 8 karakter.'
        ]);

        $user = \App\Models\Pengunjung::findOrFail(\Illuminate\Support\Facades\Auth::id());
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return redirect()->route('pengunjung.profil')->with('success', '🔒 Kata sandi Anda berhasil diperbarui!');
    })->name('profil.password.update');

    // =========================================================================
});
