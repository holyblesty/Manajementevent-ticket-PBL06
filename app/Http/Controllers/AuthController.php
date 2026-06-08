<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Kita ambil inputan secara eksplisit agar lebih aman
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // 1. Coba login Admin
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Coba login User (asumsi user login menggunakan email, sesuaikan jika user login pakai username juga)
        // Jika user juga login pakai username, ganti 'email' menjadi 'username' di bawah:
        if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withInput()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout(Request $request)
    {
        // Logout dari guard yang aktif
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}