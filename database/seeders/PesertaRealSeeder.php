<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Participant;

class PesertaRealSeeder extends Seeder
{
    public function run(): void
    {
        $daftarNama = [
            'Budi', 'Andi', 'Cahyo', 'Dedi', 'Eko', 'Fajar', 'Gani', 'Hadi', 'Indra', 'Joko', 'Kiki',
            'Lutfi', 'Mamat', 'Novan', 'Oki', 'Putra', 'Qori', 'Rian', 'Soni', 'Tono', 'Umar',
            'Viko', 'Wawan', 'Xavi', 'Yogi', 'Zaki', 'Aris', 'Bagas', 'Candra', 'Dika', 'Erik',
            'Faisal', 'Gerry', 'Hasan', 'Ilham', 'Joni', 'Kevin', 'Lian', 'Miko', 'Nanda', 'Opik',
            'Pandu', 'Qadafi', 'Reza', 'Samsul', 'Tegar', 'Ucup', 'Vino', 'Wendi', 'Xander', 'Yuda',
            'Ahmad', 'Bambang', 'Cepi', 'Dimas', 'Eris', 'Farhan', 'Gilang', 'Hilman', 'Iqbal',
            'Juna', 'Kurnia', 'Lukas', 'Maulana', 'Naufal', 'Obet', 'Panca', 'Qomar', 'Raka', 'Satria',
            'Taufik', 'Udin', 'Vian', 'Wahyu', 'Xena', 'Yanto', 'Zulfikar', 'Agus', 'Baron'
        ];

        // Ambil semua event yang tersedia
        $events = Event::all();

        foreach ($events as $event) {
            // Kita buat 20 peserta untuk setiap event sebagai contoh
            for ($i = 0; $i < 20; $i++) {
                $namaPeserta = $daftarNama[array_rand($daftarNama)];
                
                // 1. Buat Registration (Tanpa nama_tim)
                $reg = Registration::create([
                    'id_event' => $event->id_event,
                    'kontak'   => '0812' . rand(111111, 999999),
                ]);

                // 2. Buat Participant
                Participant::create([
                    'id_registration' => $reg->id_registration,
                    'nama'            => $namaPeserta,
                    'kode'            => strtoupper(substr($event->judul, 0, 3)) . '-' . ($i + 1),
                    'email'           => strtolower($namaPeserta) . rand(10, 99) . '@gmail.com',
                    'instansi'        => 'Politeknik Negeri Batam',
                    'hadir'           => (bool)rand(0, 1)
                ]);
            }
        }
    }
}