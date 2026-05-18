<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriEvent;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Data User (Admin & Pengunjung)
        $admin = User::create([
            'name' => 'Admin Utama',
            'username' => 'admin1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'alamat' => 'Kampus Politeknik Negeri Batam',
            'role' => 'admin',
        ]);

        $pengunjung = User::create([
            'name' => 'Vivian',
            'username' => 'vivian12',
            'email' => 'vivian@gmail.com',
            'password' => Hash::make('password123'),
            'no_hp' => '089876543210',
            'alamat' => 'Batam Center',
            'role' => 'pengunjung',
        ]);

        // 2. Membuat Data Kategori Event
        $futsal = KategoriEvent::create(['nama_kategori' => 'Futsal']);
        $basketball = KategoriEvent::create(['nama_kategori' => 'Basketball']);
        $music = KategoriEvent::create(['nama_kategori' => 'Music Festival']);

        // 3. Membuat Data Contoh Event (Gunakan Format Tanggal dd-mm-yy di Tampilan Nanti, tapi di DB Tetap YYYY-MM-DD)
        $eventBola = Event::create([
            'judul' => 'Polibatam Basketball Championship 2026',
            'deskripsi' => 'Turnamen bola basket antar mahasiswa terbesar di Batam. Saksikan keseruannya!',
            'tanggal' => '2026-06-09', // Sesuai jadwal 09-06-26
            'jam' => '09:00:00',
            'lokasi' => 'Sport Hall Polibatam',
            'poster' => 'basketball_poster.png',
            'status_event' => 'Aktif',
            'id_admin' => $admin->id,
            'id_kategori' => $basketball->id_kategori,
        ]);

        $eventMusik = Event::create([
            'judul' => 'Polibatam Music Fest 2026',
            'deskripsi' => 'Konser musik malam keakraban mahasiswa dengan bintang tamu nasional.',
            'tanggal' => '2026-08-15',
            'jam' => '19:00:00',
            'lokasi' => 'Lap. Utama Polibatam',
            'poster' => 'music_poster.png',
            'status_event' => 'Aktif',
            'id_admin' => $admin->id,
            'id_kategori' => $music->id_kategori,
        ]);

        // 4. Membuat Data Contoh Tiket untuk Masing-Masing Event
        Tiket::create([
            'nama_tiket' => 'Reguler - Basketball',
            'harga' => 15000,
            'kuota_total' => 200,
            'kuota_tersedia' => 200,
            'id_event' => $eventBola->id_event,
        ]);

        Tiket::create([
            'nama_tiket' => 'VIP - Basketball',
            'harga' => 35000,
            'kuota_total' => 50,
            'kuota_tersedia' => 50,
            'id_event' => $eventBola->id_event,
        ]);

        Tiket::create([
            'nama_tiket' => 'Presale - Music Fest',
            'harga' => 50000,
            'kuota_total' => 500,
            'kuota_tersedia' => 500,
            'id_event' => $eventMusik->id_event,
        ]);
    }
}