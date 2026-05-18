<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Register
    public function showRegister()
    {
        return view('auth.register'); // Mengarah ke folder resources/views/auth/register.blade.php
    }

    // Memproses Registrasi Akun Asli dari Form
    public function register(Request $request)
    {
        // Validasi input data dari pengunjung
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Menyimpan data asli ke database MySQL tabel users
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-enkripsi demi keamanan
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'pengunjung', // Otomatis mendaftar sebagai pengunjung
        ]);

        // Setelah sukses daftar, langsung lempar ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // Menampilkan halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek ke database apakah username dan password cocok
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role user yang login untuk pengalihan halaman
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Jika admin, ke dashboard admin
            }

            return redirect()->route('home'); // Jika pengunjung biasa, ke beranda utama
        }

        // Jika salah username/password, balikkan ke login dengan error
        return back()->withErrors([
            'username' => 'Username atau password yang kamu masukkan salah.',
        ])->onlyInput('username');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}