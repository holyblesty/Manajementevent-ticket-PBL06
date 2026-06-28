<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Pastikan Model Admin di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        /** @var Admin $admin */ // <-- Type hinting agar Intelephense mengenali method 'save'
        $admin = Auth::guard('admin')->user();

        // ==================================================
        // VALIDASI
        // ==================================================
        $request->validate([
            'username' => 'required|string|max:50',
            'password_lama' => 'nullable',
            'password_baru' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        // ==================================================
        // UPDATE USERNAME
        // ==================================================
        $admin->username = $request->username;

        // ==================================================
        // 1. PASSWORD (OPSIONAL)
        // ==================================================
        if ($request->filled('password_baru')) {
            if (!$request->filled('password_lama')) {
                return back()->withErrors(['password_lama' => 'Masukkan password lama dulu']);
            }

            if (!Hash::check($request->password_lama, $admin->password)) {
                return back()->withErrors(['password_lama' => 'Password lama salah']);
            }

            $admin->password = Hash::make($request->password_baru);
        }

        // ==================================================
        // 2. FOTO (OPSIONAL)
        // ==================================================
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $namaFile);

            // Hapus foto lama
            if ($admin->foto && file_exists(public_path('images/' . $admin->foto))) {
                unlink(public_path('images/' . $admin->foto));
            }

            $admin->foto = $namaFile;
        }

        // ==================================================
        // SAVE
        // ==================================================
        $admin->save(); // Sekarang tidak akan ada error "Undefined method"

        // ==================================================
        // SYNC SIDEBAR SESSION
        // ==================================================
        session([
            'admin_name' => $admin->username,
            'admin_foto' => $admin->foto,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile berhasil diperbarui');
    }
}
