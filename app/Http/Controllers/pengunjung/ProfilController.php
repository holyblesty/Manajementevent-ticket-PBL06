<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil.
     */
    public function index()
    {
        $pengunjung = Auth::user();

        return view('pengunjung.profil', compact('pengunjung'));
    }

    /**
     * Menampilkan halaman edit profil.
     */
    public function edit()
    {
        $pengunjung = Auth::user();

        $bisaUpdate = !$pengunjung->updated_at
            || $pengunjung->updated_at->diffInDays(now()) >= 7;

        $sisaHari = $bisaUpdate
            ? 0
            : 7 - $pengunjung->updated_at->diffInDays(now());

        return view('pengunjung.profil-edit', compact(
            'pengunjung',
            'bisaUpdate',
            'sisaHari'
        ));
    }

    /**
     * Update data profil.
     */
    public function update(Request $request)
    {
        $pengunjung = Auth::user();

        if (
            $pengunjung->updated_at &&
            $pengunjung->updated_at->diffInDays(now()) < 7
        ) {
            return back()->with(
                'error',
                'Anda hanya dapat mengubah profil sekali seminggu.'
            );
        }

        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        $pengunjung->update($validated);

        $pengunjung->touch();

        return redirect()
            ->route('pengunjung.profil.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update foto profil.
     */
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $pengunjung = Auth::user();

        if (
            $pengunjung->foto &&
            !filter_var($pengunjung->foto, FILTER_VALIDATE_URL)
        ) {
            Storage::disk('public')->delete($pengunjung->foto);
        }

        $path = $request->file('foto')->store('foto-profil', 'public');

        $pengunjung->update([
            'foto' => $path,
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:8|confirmed',
        ]);

        $pengunjung = Auth::user();

        if (!Hash::check($request->password_lama, $pengunjung->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama salah.',
            ]);
        }

        $pengunjung->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
