<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return redirect('/');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengunjung', 
        ]);

        return redirect('/')->with('success', 'Akun berhasil dibuat!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        // 1. STRATEGI LOGIN ADMIN
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Perbaikan: Simpan data profil ke session agar bisa diakses global
            $admin = Auth::guard('admin')->user();
            session([
                'admin_name' => $admin->name,
                'admin_foto' => $admin->foto 
            ]);

            return redirect()->route('admin.dashboard'); 
        }

        // 2. STRATEGI LOGIN PENGUNJUNG
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('pengunjung.dashboard'); 
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        // Perbaikan: Hapus session profil saat logout
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->forget(['admin_name', 'admin_foto']);
        } 
        
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}