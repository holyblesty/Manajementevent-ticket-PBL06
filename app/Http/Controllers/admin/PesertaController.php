<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    private function getDataRegistrasi()
    {
        // Session key v15 agar data ter-refresh
        if (!session()->has('data_peserta_final_v15')) {
            
            $daftarNama = [
                'Budi', 'Andi', 'Cahyo', 'Dedi', 'Eko', 'Fajar', 'Gani', 'Hadi', 'Indra', 'Joko', 'Kiki',
                'Lutfi', 'Mamat', 'Novan', 'Oki', 'Putra', 'Qori', 'Rian', 'Soni', 'Tono', 'Umar',
                'Viko', 'Wawan', 'Xavi', 'Yogi', 'Zaki', 'Aris', 'Bagas', 'Candra', 'Dika', 'Erik',
                'Faisal', 'Gerry', 'Hasan', 'Ilham', 'Joni', 'Kevin', 'Lian', 'Miko', 'Nanda', 'Opik',
                'Pandu', 'Qadafi', 'Reza', 'Samsul', 'Tegar', 'Ucup', 'Vino', 'Wendi', 'Xander', 'Yuda',
                'Zaid', 'Ahmad', 'Bambang', 'Cepi', 'Dimas', 'Eris', 'Farhan', 'Gilang', 'Hilman', 'Iqbal',
                'Juna', 'Kurnia', 'Lukas', 'Maulana', 'Naufal', 'Obet', 'Panca', 'Qomar', 'Raka', 'Satria',
                'Taufik', 'Udin', 'Vian', 'Wahyu', 'Xena', 'Yanto', 'Zulfikar', 'Agus', 'Baron'
            ];

            $generateAnggota = function($prefix, $count) use ($daftarNama) {
                $anggota = [];
                for ($i = 0; $i < $count; $i++) {
                    $anggota[] = [
                        'nama' => $daftarNama[array_rand($daftarNama)] . ' ' . chr(65 + $i), 
                        'kode' => $prefix . '-' . ($i + 1), 
                        'hadir' => false
                    ];
                }
                return $anggota;
            };

            // Data Futsal
            $futsalTeams = ['SHAOLIN SOCCER' => 'FTSL-01', 'TENDANGAN SI MADUN' => 'FTSL-02', 'CAPTAIN TSUBASA' => 'FTSL-03', 'REAL MADRID' => 'FTSL-04', 'DURIAN RUNTUH' => 'FTSL-05'];
            $futsalPendaftar = [];
            $id = 301;
            foreach ($futsalTeams as $nama => $prefix) {
                $futsalPendaftar[$id++] = ['nama_tim' => $nama, 'kontak' => '0812345678', 'hadir' => false, 'anggota' => $generateAnggota($prefix, 11)];
            }

            // Data Basket
            $basketPendaftar = [];
            $basketTeams = ['Slam Dunk', 'Haikyuu', 'Kuroko no Basket', 'Blue Lock', 'Ahiru no Sora'];
            foreach ($basketTeams as $nama) {
                $basketPendaftar[$id++] = ['nama_tim' => $nama, 'kontak' => '0812345', 'hadir' => false, 'anggota' => $generateAnggota('BSKT', 5)];
            }

            // Data Festival Musik
            $musikPendaftar = [];
            for ($i = 0; $i < 10; $i++) {
                $musikPendaftar[201 + $i] = [
                    'nama' => $daftarNama[array_rand($daftarNama)],
                    'kode' => 'MSK-' . ($i + 1),
                    'kontak' => '0812' . rand(111111, 999999),
                    'hadir' => false
                ];
            }

            // Data Seminar AI
            $seminarPendaftar = [];
            for ($i = 0; $i < 20; $i++) {
                $seminarPendaftar[401 + $i] = [
                    'nama' => $daftarNama[array_rand($daftarNama)],
                    'kode' => 'AI-' . ($i + 1),
                    'kontak' => '0812' . rand(111111, 999999),
                    'hadir' => (bool)rand(0, 1)
                ];
            }

            $data = [
                1 => ['judul' => 'Turnamen Basket Antar Mahasiswa', 'tipe' => 'tim', 'kategori' => 'Olahraga', 'tanggal' => '20 Mei 2026', 'kuota' => 5, 'poster' => 'basket.png', 'pendaftar' => $basketPendaftar],
                2 => ['judul' => 'Festival Musik Kampus 2026', 'tipe' => 'individu', 'kategori' => 'Hiburan', 'tanggal' => '25 Mei 2026', 'kuota' => 500, 'poster' => 'musik.png', 'pendaftar' => $musikPendaftar],
                3 => ['judul' => 'Turnamen Futsal Antar Mahasiswa', 'tipe' => 'tim', 'kategori' => 'Olahraga', 'tanggal' => '01 Juni 2026', 'kuota' => 32, 'poster' => 'futsal.jpg', 'pendaftar' => $futsalPendaftar],
                4 => ['judul' => 'Seminar Nasional AI: Transformasi Digital', 'tipe' => 'individu', 'kategori' => 'Seminar', 'tanggal' => '10 Juni 2026', 'kuota' => 200, 'poster' => 'seminar.jpg', 'pendaftar' => $seminarPendaftar],
            ];
            session(['data_peserta_final_v15' => $data]);
        }
        return session('data_peserta_final_v15');
    }

    private function getCalculatedStats($item)
    {
        $totalTeams = count($item['pendaftar']); 
        $totalMembers = 0;
        $hadir = 0;

        foreach ($item['pendaftar'] as $p) {
            if ($item['tipe'] == 'tim') {
                $totalMembers += count($p['anggota']);
                foreach ($p['anggota'] as $a) if ($a['hadir']) $hadir++;
            } else {
                $totalMembers++;
                if ($p['hadir']) $hadir++;
            }
        }
        
        return [
            'total_pendaftar' => ($item['tipe'] == 'tim') ? $totalTeams : $totalMembers,
            'total_teams'     => $totalTeams,
            'total_members'   => $totalMembers,
            'kuota'           => $item['kuota'],
            'is_full'         => $totalTeams >= $item['kuota'],
            'total_hadir'     => $hadir,
            'label'           => ($item['tipe'] == 'tim') ? 'Tim' : 'Peserta',
        ];
    }

    public function index(Request $request) {
        $dataRegistrasi = $this->getDataRegistrasi();
        $events = collect($dataRegistrasi)->map(function($item, $key) {
            $stats = $this->getCalculatedStats($item);
            return (object) array_merge(['id' => $key, 'judul' => $item['judul'], 'tipe' => $item['tipe'], 'kategori' => $item['kategori'], 'tanggal' => $item['tanggal'], 'poster' => $item['poster']], $stats);
        });
        return view('admin.peserta', compact('events'));
    }

    public function detail($id) {
        $dataRegistrasi = $this->getDataRegistrasi();
        if (!isset($dataRegistrasi[$id])) abort(404);
        $selectedEvent = $dataRegistrasi[$id];
        $stats = $this->getCalculatedStats($selectedEvent);
        return view('admin.peserta-detail', [
            'selectedEvent' => $selectedEvent, 
            'id' => $id, 
            'total' => $stats['total_members'], 
            'hadir' => $stats['total_hadir'], 
            'belumHadir' => ($stats['total_members'] - $stats['total_hadir'])
        ]);
    }

    public function checkInIndividu($eventId, $regId) {
        $data = $this->getDataRegistrasi();
        if (isset($data[$eventId]['pendaftar'][$regId])) {
            $data[$eventId]['pendaftar'][$regId]['hadir'] = !$data[$eventId]['pendaftar'][$regId]['hadir'];
            session(['data_peserta_final_v15' => $data]);
        }
        return redirect()->back();
    }

    public function checkInAnggota($eventId, $regId, $memberIndex) {
        $data = $this->getDataRegistrasi();
        if (isset($data[$eventId]['pendaftar'][$regId]['anggota'][$memberIndex])) {
            $data[$eventId]['pendaftar'][$regId]['anggota'][$memberIndex]['hadir'] = !$data[$eventId]['pendaftar'][$regId]['anggota'][$memberIndex]['hadir'];
            session(['data_peserta_final_v15' => $data]);
        }
        return redirect()->back();
    }
}