<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dummy aman
        $events = [
            [
                'id' => 1,
                'judul' => 'Turnamen Basket Antar Mahasiswa',
                'tanggal' => '2026-05-20',
                'lokasi' => 'Lapangan Basket Politeknik Batam',
                'kategori' => 'Olahraga',
                'poster' => 'poster1.png'
            ],
            [
                'id' => 2,
                'judul' => 'Turnamen Futsal Antar Mahasiswa',
                'tanggal' => '2026-05-28',
                'lokasi' => 'Gedung Utama',
                'kategori' => 'Olahraga',
                'poster' => 'poster2.png'
            ],
            [
                'id' => 3,
                'judul' => 'Peran AI dalam Transformasi Digital',
                'tanggal' => '2026-05-28',
                'lokasi' => 'Halaman Depan Techno',
                'kategori' => 'Seminar',
                'poster' => 'poster3.png'
            ],
            [
                'id' => 4,
                'judul' => 'Festival Musik Kampus 2026',
                'tanggal' => '2026-05-30',
                'lokasi' => 'Lapangan Bola Polibatam',
                'kategori' => 'Hiburan',
                'poster' => 'poster4.png'
            ],
        ];

        return view('admin.dashboard', compact('events'));
    }
}
