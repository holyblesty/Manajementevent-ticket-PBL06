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

        // 1. CARI EVENT BERDASARKAN JUDUL/KATEGORI YANG SUDAH ADA DI DB KAMU
        $basketEvent  = Event::where('kategori', 'Olahraga')->where('judul', 'like', '%Basket%')->first();
        $futsalEvent  = Event::where('kategori', 'Olahraga')->where('judul', 'like', '%Futsal%')->first();
        $musikEvent   = Event::where('kategori', 'Hiburan')->first();
        $seminarEvent = Event::where('kategori', 'Seminar')->first();

        // --- SEEDING DATA BASKET (Tipe: Tim) ---
        if ($basketEvent) {
            $basketTeams = ['Slam Dunk', 'Haikyuu', 'Kuroko no Basket', 'Blue Lock', 'Ahiru no Sora'];
            foreach ($basketTeams as $index => $namaTim) {
                $reg = Registration::create([
                    'id_event' => $basketEvent->id_event,
                    'nama_tim' => $namaTim,
                    'kontak'   => '0812345' . rand(100, 999),
                ]);

                for ($i = 0; $i < 5; $i++) {
                    $firstName = $daftarNama[array_rand($daftarNama)];
                    Participant::create([
                        'id_registration' => $reg->id_registration,
                        'nama'     => $firstName . ' ' . chr(65 + $i),
                        'kode'     => 'BSKT-' . ($index + 1) . '-' . ($i + 1),
                        'email'    => ($i === 0) ? strtolower($firstName) . rand(10, 99) . '@gmail.com' : null,
                        'instansi' => ($i === 0) ? 'Politeknik Negeri Batam' : null,
                        'hadir'    => false
                    ]);
                }
            }
        }

        // --- SEEDING DATA FUTSAL (Tipe: Tim) ---
        if ($futsalEvent) {
            $futsalTeams = ['SHAOLIN SOCCER' => 'FTSL-01', 'TENDANGAN SI MADUN' => 'FTSL-02', 'CAPTAIN TSUBASA' => 'FTSL-03', 'REAL MADRID' => 'FTSL-04', 'DURIAN RUNTUH' => 'FTSL-05'];
            $idx = 1;
            foreach ($futsalTeams as $namaTim => $prefix) {
                $reg = Registration::create([
                    'id_event' => $futsalEvent->id_event,
                    'nama_tim' => $namaTim,
                    'kontak'   => '0812345678' . rand(10, 99),
                ]);

                for ($i = 0; $i < 11; $i++) {
                    $firstName = $daftarNama[array_rand($daftarNama)];
                    Participant::create([
                        'id_registration' => $reg->id_registration,
                        'nama'     => $firstName . ' ' . chr(65 + $i),
                        'kode'     => $prefix . '-' . ($i + 1),
                        'email'    => ($i === 0) ? strtolower($firstName) . rand(10, 99) . '@gmail.com' : null,
                        'instansi' => ($i === 0) ? 'Politeknik Negeri Batam' : null,
                        'hadir'    => false
                    ]);
                }
            }
        }

        // --- SEEDING DATA FESTIVAL MUSIK (Tipe: Individu) ---
        if ($musikEvent) {
            for ($i = 0; $i < 10; $i++) {
                $namaPeserta = $daftarNama[array_rand($daftarNama)];
                $reg = Registration::create([
                    'id_event' => $musikEvent->id_event,
                    'nama_tim' => null,
                    'kontak'   => '0812' . rand(111111, 999999),
                ]);

                Participant::create([
                    'id_registration' => $reg->id_registration,
                    'nama'     => $namaPeserta,
                    'kode'     => 'MSK-' . ($i + 1),
                    'email'    => strtolower($namaPeserta) . rand(10, 99) . '@gmail.com',
                    'instansi' => 'Politeknik Negeri Batam',
                    'hadir'    => false
                ]);
            }
        }

        // --- SEEDING DATA SEMINAR AI (Tipe: Individu) ---
        if ($seminarEvent) {
            for ($i = 0; $i < 20; $i++) {
                $namaPeserta = $daftarNama[array_rand($daftarNama)];
                $reg = Registration::create([
                    'id_event' => $seminarEvent->id_event,
                    'nama_tim' => null,
                    'kontak'   => '0812' . rand(111111, 999999),
                ]);

                Participant::create([
                    'id_registration' => $reg->id_registration,
                    'nama'     => $namaPeserta,
                    'kode'     => 'AI-' . ($i + 1),
                    'email'    => strtolower($namaPeserta) . rand(10, 99) . '@gmail.com',
                    'instansi' => 'Politeknik Negeri Batam',
                    'hadir'    => (bool)rand(0, 1)
                ]);
            }
        }
    }
}