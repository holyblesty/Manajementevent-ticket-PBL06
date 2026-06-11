<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run()
    {
        DB::table('events')->insert([
            'id_event' => 1,
            'nama_event' => 'AI & MASA DEPAN KITA TECH FORUM 2024',
            'tanggal' => '2024-05-29',
            'waktu' => '09.00 - 17.00 WIB',
            'lokasi' => 'Gedung Utama, Jl. Teknologi No. 1, Bandung',
            'deskripsi' => 'Tech Forum yang membahas perkembangan kecerdasan buatan dan masa depan teknologi.',
            'foto' => 'ai-forum.jpg', // taruh file gambar di storage/app/public/ai-forum.jpg
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}