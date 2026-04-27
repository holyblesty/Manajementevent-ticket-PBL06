<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input kategori dari dropdown (jika ada)
        $selectedCategory = $request->query('kategori');

        // 2. Data dummy (Ditambahkan properti kapasitas agar tidak error)
        $allEvents = [
            (object)[
                'id' => 1, 
                'poster' => 'basket.png', 
                'judul' => 'Turnamen Basket Antar Mahasiswa', 
                'tanggal' => '20 - 05 - 2026', 
                'lokasi' => 'Lapangan Basket Politeknik Batam', 
                'kategori' => 'Olahraga',
                'kapasitas' => 50 // Tambahkan kapasitas
            ],
            (object)[
                'id' => 2, 
                'poster' => 'musik.png', 
                'judul' => 'Festival Musik Kampus 2026', 
                'tanggal' => '30 - 05 - 2026', 
                'lokasi' => 'Lapangan Bola Politeknik Batam', 
                'kategori' => 'Hiburan',
                'kapasitas' => 500
            ],
            (object)[
                'id' => 3, 
                'poster' => 'futsal.jpg', 
                'judul' => 'Futsal Kampus Championship', 
                'tanggal' => '09 - 06 - 2026', 
                'lokasi' => 'Sport Hall Politeknik Batam', 
                'kategori' => 'Olahraga',
                'kapasitas' => 32
            ],
            (object)[
                'id' => 4, 
                'poster' => 'seminar.jpg', 
                'judul' => 'Seminar Nasional: Masa Depan AI', 
                'tanggal' => '15 - 06 - 2026', 
                'lokasi' => 'Auditorium Gd. Utama', 
                'kategori' => 'Seminar',
                'kapasitas' => 200
            ],
        ];

        // 3. Logika "Auto Jadi Nomor 1"
        usort($allEvents, function($a, $b) use ($selectedCategory) {
            if ($a->kategori == $selectedCategory && $b->kategori != $selectedCategory) return -1;
            if ($a->kategori != $selectedCategory && $b->kategori == $selectedCategory) return 1;
            return 0;
        });

        return view('admin.dashboard', [
            'events' => $allEvents,
            'selectedCategory' => $selectedCategory 
        ]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // Validasi diperbarui untuk menyertakan kapasitas
        $request->validate([
            'judul' => 'required|min:5',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'kapasitas' => 'required|numeric', // Tambahkan validasi kapasitas
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Acara baru berhasil ditambahkan!');
    }
}