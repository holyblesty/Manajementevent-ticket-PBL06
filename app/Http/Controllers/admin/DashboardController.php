<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('kategori');
        $search = $request->query('search');

        $query = Event::query();

        if ($selectedCategory) {
            $query->where('kategori', $selectedCategory);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', '%' . $search . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $search . '%');
            });
        }

        $eventObjects = $query->latest()->get();
        $admin = Auth::guard('admin')->user();

        return view('admin.dashboard', [
            'events' => $eventObjects,
            'selectedCategory' => $selectedCategory,
            'admin' => $admin
        ]);
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'username'      => 'required|string|max:255',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password_lama' => 'nullable',
            'password_baru' => 'nullable|min:6',
        ]);

        if ($request->filled('password_baru')) {
            if (empty($request->password_lama) || !Hash::check($request->password_lama, $admin->password)) {
                return back()->withErrors(['password_lama' => 'Password lama salah atau tidak diisi!']);
            }
            $admin->password = Hash::make($request->password_baru);
        }

        if ($request->filled('username')) {
            $admin->username = $request->username;
        }

        if ($request->hasFile('foto')) {
            if ($admin->foto && File::exists(public_path('images/' . $admin->foto))) {
                File::delete(public_path('images/' . $admin->foto));
            }

            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            $admin->foto = $imageName;
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
