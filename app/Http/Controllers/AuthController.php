<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User sudah ada

class AuthController extends Controller
{
    // 1. Menampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = ['username' => $request->username, 'password' => $request->password];

        // Coba Login Admin
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Coba Login User
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('pengunjung.dashboard'));
        }

        return back()->withInput()->withErrors(['username' => 'Username atau password salah.']);
    }

    // 3. Menampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 4. Proses Register
 public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'username' => 'required|string|unique:users,username|max:255',
        'email'    => 'required|string|email|max:255|unique:users,email', // Tambahkan validasi email
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'username' => $request->username,
        'email'    => $request->email, // Tambahkan ini
        'password' => Hash::make($request->password),
    ]);

    Auth::guard('web')->login($user);
    return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
}

    // 5. Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}