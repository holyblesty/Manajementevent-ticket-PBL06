<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var Pengunjung $pengunjung */
        $pengunjung = Auth::guard('web')->user();

        return view('pengunjung.profile', compact('pengunjung'));
    }

    public function update(Request $request)
    {
        /** @var Pengunjung $pengunjung */
        $pengunjung = Auth::guard('web')->user();

        // ============================
        // VALIDASI
        // ============================
        $request->validate([
            'name' => 'required|string|max:255',

            'username' => 'required|string|max:100|unique:pengunjung,username,' .
                $pengunjung->id_pengunjung . ',id_pengunjung',

            'email' => 'required|email|unique:pengunjung,email,' .
                $pengunjung->id_pengunjung . ',id_pengunjung',

            'no_hp' => 'required|max:20',

            'alamat' => 'required|string',

            'password_lama' => 'nullable',

            'password_baru' => 'nullable|min:6',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ============================
        // UPDATE DATA
        // ============================
        $pengunjung->name = $request->name;
        $pengunjung->username = $request->username;
        $pengunjung->email = $request->email;
        $pengunjung->no_hp = $request->no_hp;
        $pengunjung->alamat = $request->alamat;

        // ============================
        // PASSWORD
        // ============================
        if ($request->filled('password_baru')) {

            if (!$request->filled('password_lama')) {
                return back()->withErrors([
                    'password_lama' => 'Masukkan password lama.'
                ]);
            }

            if (!Hash::check($request->password_lama, $pengunjung->password)) {
                return back()->withErrors([
                    'password_lama' => 'Password lama salah.'
                ]);
            }

            $pengunjung->password = Hash::make($request->password_baru);
        }

        // ============================
        // FOTO
        // ============================
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $namaFile);

            if (
                $pengunjung->foto &&
                file_exists(public_path('images/' . $pengunjung->foto))
            ) {
                unlink(public_path('images/' . $pengunjung->foto));
            }

            $pengunjung->foto = $namaFile;
        }

        // ============================
        // SIMPAN
        // ============================
        $pengunjung->save();

        return redirect()
            ->route('pengunjung.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}