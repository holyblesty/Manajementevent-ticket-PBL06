<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event; // Pastikan model Event sudah dibuat

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'poster' => 'basket.png', 
                'judul' => 'Turnamen Basket Antar Mahasiswa', 
                'deskripsi' => 'Pertandingan basket seru antar jurusan di Politeknik Batam.',
                'tanggal' => '2026-05-20', 
                'lokasi' => 'Lapangan Basket Politeknik Batam', 
                'kategori' => 'Olahraga',
                'kapasitas' => 50,
                'jenis' => 'tim',
            ],
            [
                'poster' => 'musik.png', 
                'judul' => 'Festival Musik Kampus 2026', 
                'deskripsi' => 'Konser musik tahunan mahasiswa Politeknik Batam.',
                'tanggal' => '2026-05-30', 
                'lokasi' => 'Lapangan Bola Politeknik Batam', 
                'kategori' => 'Hiburan',
                'kapasitas' => 500,
                'jenis' => 'individu',
            ],
            [
                'poster' => 'futsal.jpg', 
                'judul' => 'Futsal Kampus Championship', 
                'deskripsi' => 'Turnamen futsal bergengsi memperebutkan piala Direktur.',
                'tanggal' => '2026-06-09', 
                'lokasi' => 'Sport Hall Politeknik Batam', 
                'kategori' => 'Olahraga',
                'kapasitas' => 32,
                'jenis' => 'tim',
            ],
            [
                'poster' => 'seminar.jpg', 
                'judul' => 'Seminar Nasional: Masa Depan AI', 
                'deskripsi' => 'Membahas perkembangan teknologi AI di industri masa kini.',
                'tanggal' => '2026-06-15', 
                'lokasi' => 'Auditorium Gd. Utama', 
                'kategori' => 'Seminar',
                'kapasitas' => 200,
                'jenis' => 'individu',
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}