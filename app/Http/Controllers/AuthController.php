<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // =========================================================
    // REGISTER
    // =========================================================

    public function showRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('pengunjung.beranda');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'no_hp'    => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'no_hp.required'     => 'Nomor HP wajib diisi.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'     => 'pengunjung',
        ]);

// HEAD
        // Auto login setelah register
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('pengunjung.beranda')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
    }

    // =========================================================
    // LOGIN
    // =========================================================

    public function showLogin()
    {
        // Redirect kalau sudah login
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('web')->check()) {
            return redirect()->route('pengunjung.beranda');
        }

        return view('auth.login');
        return redirect('/')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // --------------------------------------------------
        // STRATEGI 1: Login sebagai Admin
        // --------------------------------------------------
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();

            // Simpan data profil admin ke session agar bisa diakses global
            session([
                'admin_name' => $admin->name,
                'admin_foto' => $admin->foto ?? null,
            ]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . $admin->name . '!');
        }

        // --------------------------------------------------
        // STRATEGI 2: Login sebagai Pengunjung (web guard)
        // --------------------------------------------------
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            return redirect()->route('pengunjung.beranda')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        // --------------------------------------------------
        // GAGAL: Kedua guard tidak cocok
        // --------------------------------------------------
        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    // =========================================================
    // LOGOUT
    // =========================================================

    public function logout(Request $request)
    {
        // Logout Admin
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();

            // Hapus session profil admin
            $request->session()->forget(['admin_name', 'admin_foto']);
        }

        // Logout Pengunjung
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    // =========================================================
    // PROFIL PENGUNJUNG
    // =========================================================

    public function showProfil()
    {
        $user = Auth::guard('web')->user();
        return view('pengunjung.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::guard('web')->user();

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'email', 'no_hp', 'alamat']);

        // Update password jika diisi
        if ($request->filled('password')) {
            $passValidator = Validator::make($request->all(), [
                'password' => 'min:6|confirmed',
            ], [
                'password.min'       => 'Password minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]);

            if ($passValidator->fails()) {
                return back()->withErrors($passValidator)->withInput();
            }

            $data['password'] = Hash::make($request->password);
        }

        // Upload foto profil jika ada
        if ($request->hasFile('foto')) {
            $request->validate(['foto' => 'image|mimes:jpg,jpeg,png|max:2048']);

            if ($user->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
    }