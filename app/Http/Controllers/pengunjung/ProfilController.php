<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\User; // Mengubah Pengunjung menjadi User sesuai tabel database Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil pengunjung yang sedang login.
     */
    public function index()
    {
        // ── SEMENTARA: dummy data untuk cek tampilan ──────────────────────
        // Foto diisi otomatis (tidak null), password diset null
        $pengunjung = (object)[
            'id'            => 1,
            'nama_lengkap'  => 'Jesina Holy',
            'username'      => 'jesinaholy',
            'email'         => 'jesina@mail.com',
            'no_telepon'    => '08124567890',
            'tanggal_lahir' => Carbon::parse('2000-01-15'),
            'jenis_kelamin' => 'Perempuan',
            'alamat'        => 'Jl. Malaka No. 12, Bandung, Jawa Barat',
            'foto'          => 'https://ui-avatars.com/api/?name=Jesina+Holy&color=ffffff&background=7a4988',
            'password'      => null, // Password cukup diset null untuk keperluan testing
            'metode_login'  => 'Email',
            'status_akun'   => 'Aktif',
            'created_at'    => Carbon::parse('2024-05-29'),
        ];

        // SINKRONISASI: Jika layout sudah oke, hapus dummy di atas dan aktifkan baris auth default di bawah ini:
        // $pengunjung = Auth::user();

        return view('pengunjung.profil.profil', compact('pengunjung'));
    }

    /**
     * Update informasi pribadi pengunjung (CRUD: Update).
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $pengunjung */
        $pengunjung = Auth::user();

        if (!$pengunjung) {
            return redirect()->back()->with('error', 'Sesi login tidak ditemukan.');
        }

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($pengunjung->id)],
            'no_telepon'    => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string|max:500',
        ]);

        $pengunjung->update([
            'name'          => $request->nama_lengkap, 
            'email'         => $request->email,
            'no_hp'         => $request->no_telepon, 
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('pengunjung.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update foto profil pengunjung (CRUD: Update).
     */
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /** @var \App\Models\User $pengunjung */
        $pengunjung = Auth::user();

        if (!$pengunjung) {
            return redirect()->back()->with('error', 'Sesi login tidak ditemukan.');
        }

        // Hapus file lama jika ada di storage dan jalurnya bukan tautan luar (URL)
        if (isset($pengunjung->foto) && $pengunjung->foto && !filter_var($pengunjung->foto, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($pengunjung->foto)) {
            Storage::disk('public')->delete($pengunjung->foto);
        }

        $path = $request->file('foto')->store('foto-profil', 'public');

        $pengunjung->update(['foto' => $path]);

        return redirect()->route('pengunjung.profil.index')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update password pengunjung (CRUD: Update).
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_baru'              => 'required|string|min:8|confirmed',
            'password_baru_confirmation' => 'required',
        ]);

        /** @var \App\Models\User $pengunjung */
        $pengunjung = Auth::user();

        if (!$pengunjung) {
            return redirect()->back()->with('error', 'Sesi login tidak ditemukan.');
        }

        $pengunjung->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->route('pengunjung.profil.index')
            ->with('success', 'Password berhasil diubah.');
    }

    /**
     * Hapus akun pengunjung (CRUD: Delete).
     */
    public function destroy()
    {
        /** @var \App\Models\User $pengunjung */
        $pengunjung = Auth::user();

        if (!$pengunjung) {
            return redirect()->back()->with('error', 'Sesi login tidak ditemukan.');
        }

        if (isset($pengunjung->foto) && $pengunjung->foto && !filter_var($pengunjung->foto, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($pengunjung->foto)) {
            Storage::disk('public')->delete($pengunjung->foto);
        }

        Auth::logout();
        $pengunjung->delete();

        return redirect()->route('home')
            ->with('success', 'Akun berhasil dihapus.');
    }
}