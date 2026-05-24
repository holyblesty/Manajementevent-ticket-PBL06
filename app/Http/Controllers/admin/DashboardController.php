<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event; // Menghubungkan ke model Event database
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input filter kategori dan search dari request view
        $selectedCategory = $request->query('kategori');
        $search = $request->query('search');

        // 2. Query ke Database menggunakan Eloquent Model Event
        // Menggunakan "query()" agar pencarian dan filter bisa dirantai (chained)
        $query = Event::query();

        // Jika admin memilih kategori tertentu di dropdown
        if ($selectedCategory) {
            $query->where('kategori', $selectedCategory);
        }

        // Jika admin mengetik sesuatu di kolom pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', '%' . $search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $search . '%');
            });
        }

        // 3. Ambil hasil data dari database (diurutkan dari yang paling baru)
        $eventObjects = $query->latest()->get();

        // 4. Lempar data asli database ke file Blade View
        return view('admin.dashboard', [
            'events' => $eventObjects,
            'selectedCategory' => $selectedCategory
        ]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // Logika validasi dan simpan data baru ke database (lewat AcaraController atau di sini)
        return redirect()->route('admin.dashboard');
    }
}