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
// 2. Data dummy mentah (Total 4 Event)
    $allEvents = [
        (object)[
            'id' => 1, 
            'poster' => 'basket.png', 
            'judul' => 'Turnamen Basket Antar Mahasiswa', 
            'tanggal' => '20 - 05 - 2026', 
            'lokasi' => 'Lapangan Basket Politeknik Batam', 
            'kategori' => 'Olahraga'
        ],
        (object)[
            'id' => 2, 
            'poster' => 'musik.png', 
            'judul' => 'Festival Musik Kampus 2026', 
            'tanggal' => '30 - 05 - 2026', 
            'lokasi' => 'Lapangan Bola Politeknik Batam', 
            'kategori' => 'Hiburan'
        ],
        (object)[
            'id' => 3, 
            'poster' => 'futsal.png', 
            'judul' => 'Futsal Kampus Championship', 
            'tanggal' => '09 - 06 - 2026', 
            'lokasi' => 'Sport Hall Politeknik Batam', 
            'kategori' => 'Olahraga'
        ],
        (object)[
            'id' => 4, 
            'poster' => 'seminar.png', 
            'judul' => 'Seminar Nasional: Masa Depan AI', 
            'tanggal' => '15 - 06 - 2026', 
            'lokasi' => 'Auditorium Gd. Utama', 
            'kategori' => 'Seminar'
        ],
    ];
    // 3. Logika "Auto Jadi Nomor 1"
    // Kita urutkan data: jika kategori cocok dengan yang dipilih, taruh paling atas
    usort($allEvents, function($a, $b) use ($selectedCategory) {
        if ($a->kategori == $selectedCategory && $b->kategori != $selectedCategory) return -1;
        if ($a->kategori != $selectedCategory && $b->kategori == $selectedCategory) return 1;
        return 0;
    });

    return view('admin.dashboard', [
        'events' => $allEvents,
        'selectedCategory' => $selectedCategory // Kita kirim balik ke view untuk tanda 'active'
    ]);
}
    /**
     * Menampilkan Form Tambah Acara
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Logika Menyimpan Data Acara Baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|min:5',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Sementara kita redirect dulu ke dashboard dengan pesan sukses
        // (Logika database akan ditambahkan saat kamu siap dengan Database/Migration)
        return redirect()->route('admin.dashboard')->with('success', 'Acara baru berhasil ditambahkan!');
    }
}