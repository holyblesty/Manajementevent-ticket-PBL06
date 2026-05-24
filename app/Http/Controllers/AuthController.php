<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin; // PENTING: Panggil model admin kamu di sini!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Register (Di-redirect ke beranda karena pakai modal)
    public function showRegister()
    {
        return redirect('/');
    }

    // Memproses Registrasi Akun Pengunjung (Masuk ke tabel users/pengunjung)
    public function register(Request $request)
    {
        // Validasi input data dari pengunjung (sesuai ERD kamu)
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Menyimpan data pengunjung ke database MySQL tabel users
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'pengunjung', 
        ]);

        // 🚨 DIUBAH: Langsung lempar ke beranda dengan pesan sukses
        return redirect('/')->with('success', 'Akun berhasil dibuat! Silakan masuk melalui menu Login.');
    }

    // Menampilkan halaman Login (Di-redirect ke beranda karena pakai modal)
    public function showLogin()
    {
        return redirect('/');
    }

    // Memproses Login Multi-Table (Admin & Pengunjung)
    public function login(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Ambil data credentials untuk Auth check
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        // 3. STRATEGI UTAMA: Coba login sebagai ADMIN dulu (Menggunakan Guard Admin)
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); 
        }

        // 4. STRATEGI KEDUA: Coba login sebagai PENGUNJUNG (Menggunakan Guard Web bawaan)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('pengunjung.dashboard'); 
        }

        // 5. Jika di kedua tabel tidak ditemukan data yang cocok
        return back()->withErrors([
            'username' => 'Username atau password yang kamu masukkan salah.',
        ])->onlyInput('username');
    }

    // Memproses Logout Multi-Guard
    public function logout(Request $request)
    {
        // Ambil status login guard sebelum di-logout untuk keperluan log/kondisi jika dibutuhkan
        $isAdmin = Auth::guard('admin')->check();
        $isWeb = Auth::guard('web')->check();

        // Logout dari guard yang sedang aktif
        if ($isAdmin) {
            Auth::guard('admin')->logout();
        } 
        
        if ($isWeb) {
            Auth::guard('web')->logout();
        }

        // Hancurkan session secara total dan buat token baru (mencegah session fixation)
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // 🚨 DIUBAH: Pakai URL '/' langsung agar tidak bergantung pada nama rute
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}