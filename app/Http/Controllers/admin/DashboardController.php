<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input kategori dari dropdown
        $selectedCategory = $request->query('kategori');

        // 2. Cek data dari Session
        $events = session('custom_events');

        /**
         * 3. LOGIKA RESET OTOMATIS (VERSI LENGKAP)
         * Gue udah masukin semua data tiket dummy biar pas lo buka isinya nggak 0.
         */
        if (!$events || (isset($events[1]) && !isset($events[1]['tiket']))) 
        {
            $events = [
                1 => [
                    'id' => 1, 
                    'poster' => 'basket.png', 
                    'judul' => 'Turnamen Basket Antar Mahasiswa', 
                    'deskripsi' => 'Pertandingan basket seru antar jurusan di Politeknik Batam.',
                    'tanggal' => '2026-05-20', 
                    'lokasi' => 'Lapangan Basket Politeknik Batam', 
                    'kategori' => 'Olahraga',
                    'kapasitas' => 50,
                    'jenis' => 'tim',
                    'desain_tiket' => null,
                    'tiket' => [
                        'early_bird' => (object)['nama' => 'Early Bird', 'harga' => 50000, 'kuota' => 10],
                        'vip'         => (object)['nama' => 'VIP', 'harga' => 150000, 'kuota' => 10],
                        'normal'      => (object)['nama' => 'Normal', 'harga' => 75000, 'kuota' => 30],
                    ]
                ],
                2 => [
                    'id' => 2, 
                    'poster' => 'musik.png', 
                    'judul' => 'Festival Musik Kampus 2026', 
                    'deskripsi' => 'Konser musik tahunan mahasiswa Politeknik Batam.',
                    'tanggal' => '2026-05-30', 
                    'lokasi' => 'Lapangan Bola Politeknik Batam', 
                    'kategori' => 'Hiburan',
                    'kapasitas' => 500,
                    'jenis' => 'individu',
                    'desain_tiket' => null,
                    'tiket' => [
                        'early_bird' => (object)['nama' => 'Presale 1', 'harga' => 80000, 'kuota' => 100],
                        'vip'         => (object)['nama' => 'VIP', 'harga' => 350000, 'kuota' => 50],
                        'normal'      => (object)['nama' => 'Festival', 'harga' => 120000, 'kuota' => 350],
                    ]
                ],
                3 => [
                    'id' => 3, 
                    'poster' => 'futsal.jpg', 
                    'judul' => 'Futsal Kampus Championship', 
                    'deskripsi' => 'Turnamen futsal bergengsi memperebutkan piala Direktur.',
                    'tanggal' => '2026-06-09', 
                    'lokasi' => 'Sport Hall Politeknik Batam', 
                    'kategori' => 'Olahraga',
                    'kapasitas' => 32,
                    'jenis' => 'tim',
                    'desain_tiket' => null,
                    'tiket' => [
                        'early_bird' => (object)['nama' => 'Promo', 'harga' => 25000, 'kuota' => 10],
                        'vip'         => (object)['nama' => 'VIP', 'harga' => 75000, 'kuota' => 2],
                        'normal'      => (object)['nama' => 'Reguler', 'harga' => 35000, 'kuota' => 20],
                    ]
                ],
                4 => [
                    'id' => 4, 
                    'poster' => 'seminar.jpg', 
                    'judul' => 'Seminar Nasional: Masa Depan AI', 
                    'deskripsi' => 'Membahas perkembangan teknologi AI di industri masa kini.',
                    'tanggal' => '2026-06-15', 
                    'lokasi' => 'Auditorium Gd. Utama', 
                    'kategori' => 'Seminar',
                    'kapasitas' => 200,
                    'jenis' => 'individu',
                    'desain_tiket' => null,
                    'tiket' => [
                        'early_bird' => (object)['nama' => 'Early Bird', 'harga' => 50000, 'kuota' => 50],
                        'vip'         => (object)['nama' => 'VIP', 'harga' => 200000, 'kuota' => 50],
                        'normal'      => (object)['nama' => 'Normal', 'harga' => 100000, 'kuota' => 100],
                    ]
                ],
            ];
            
            session(['custom_events' => $events]);
        }

        // 4. Ubah Array ke Collection Objek
        $eventObjects = collect($events)->map(function($item) {
            return (object) $item;
        })->toArray();

        // 5. Logika Sorting Kategori
        usort($eventObjects, function($a, $b) use ($selectedCategory) {
            if ($selectedCategory) {
                if ($a->kategori == $selectedCategory && $b->kategori != $selectedCategory) return -1;
                if ($a->kategori != $selectedCategory && $b->kategori == $selectedCategory) return 1;
            }
            return 0;
        });

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
        // Tetap pakai logic store yang sudah ada di AcaraController saja
        return redirect()->route('admin.dashboard');
    }
}