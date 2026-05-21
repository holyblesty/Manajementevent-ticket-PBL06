<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin; // PENTING: Panggil model admin kamu di sini!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Register
    public function showRegister()
    {
        return view('auth.register');
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

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // Menampilkan halaman Login
    public function showLogin()
    {
        return view('auth.login');
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
        // Logout dari guard admin jika yang login adalah admin
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            // Logout dari guard web/pengunjung jika yang login pengunjung
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}