<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    /**
     * Ambil data registrasi (4 Event Lengkap)
     * Dengan fitur Auto-Sync jika data di session tidak sesuai.
     */
    private function getDataRegistrasi()
    {
        if (session()->has('data_registrasi_lengkap')) {
            $currentData = session('data_registrasi_lengkap');
            // Jika data session ada, kita pakai data tersebut
            if (count($currentData) >= 4) {
                return $currentData;
            }
        }

        // Data 4 Event Master (Pastikan semua key 'kategori' tersedia)
        $data = [
            1 => [
                'judul' => 'Turnamen Basket Antar Mahasiswa',
                'tipe' => 'tim',
                'kategori' => 'Olahraga',
                'tanggal' => '20 Mei 2026',
                'pendaftar' => [
                    'TKT-BSKT-001' => [
                        'nama_tim' => 'SLAM DUNK TEAM',
                        'kontak' => '0812-9988-7766',
                        'status_bayar' => 'Lunas',
                        'hadir' => false,
                        'anggota' => [
                            ['nama' => 'Hanamichi Sakuragi', 'kode' => 'BSKT-001', 'hadir' => false],
                            ['nama' => 'Kaede Rukawa', 'kode' => 'BSKT-002', 'hadir' => false],
                        ]
                    ],
                ]
            ],
            2 => [
                'judul' => 'Festival Musik Kampus 2026',
                'tipe' => 'individu',
                'kategori' => 'Hiburan',
                'tanggal' => '25 Mei 2026',
                'pendaftar' => [
                    'TKT-MSK-001' => ['nama' => 'Ariana Grande', 'kode' => 'MSK-001', 'kontak' => '0811-2233-4455', 'status_bayar' => 'Lunas', 'hadir' => false],
                ]
            ],
            3 => [
                'judul' => 'Turnamen Futsal Antar Mahasiswa',
                'tipe' => 'tim',
                'kategori' => 'Olahraga',
                'tanggal' => '01 Juni 2026',
                'pendaftar' => [
                    'TKT-FTSL-001' => [
                        'nama_tim' => 'SHAOLIN SOCCER',
                        'kontak' => '0812-3344-5566',
                        'status_bayar' => 'Lunas',
                        'hadir' => false,
                        'anggota' => [
                            ['nama' => 'James Arthur', 'kode' => 'FTSL-001', 'hadir' => true],
                            ['nama' => 'Benson Boone', 'kode' => 'FTSL-002', 'hadir' => false],
                        ]
                    ],
                ]
            ],
            4 => [
                'judul' => 'Seminar Nasional AI: Transformasi Digital',
                'tipe' => 'individu',
                'kategori' => 'Seminar',
                'tanggal' => '10 Juni 2026',
                'pendaftar' => [
                    'TKT-AI-001' => ['nama' => 'Charlie Puth', 'kode' => 'AI-001', 'kontak' => '0877-1122-3344', 'status_bayar' => 'Lunas', 'hadir' => true],
                    'TKT-AI-002' => ['nama' => 'Sam Smith', 'kode' => 'AI-002', 'kontak' => '0877-5566-7788', 'status_bayar' => 'Lunas', 'hadir' => false],
                ]
            ],
        ];

        session(['data_registrasi_lengkap' => $data]);
        return $data;
    }

    public function index(Request $request)
    {
        $dataRegistrasi = $this->getDataRegistrasi();
        
        // Perbaikan mapping: Tambahkan null coalescing (??) untuk jaga-jaga
        $events = collect($dataRegistrasi)->map(function($item, $key) {
            return (object) [
                'id'       => $key,
                'judul'    => $item['judul'] ?? 'Untitled Event',
                'kategori' => $item['kategori'] ?? 'Umum',
                'tanggal'  => $item['tanggal'] ?? 'TBA',
                'poster'   => ($key == 1) ? 'basket.png' : (($key == 2) ? 'musik.png' : (($key == 3) ? 'futsal.jpg' : 'seminar.jpg')),
                'kapasitas' => 100,
                'desain_tiket' => null
            ];
        });

        $eventId = $request->query('event_id');
        $selectedEvent = null;
        if ($eventId && isset($dataRegistrasi[$eventId])) {
            $selectedEvent = $dataRegistrasi[$eventId];
        }

        return view('admin.peserta', compact('dataRegistrasi', 'selectedEvent', 'events'));
    }

    public function checkInIndividu($eventId, $regId)
    {
        $data = $this->getDataRegistrasi();
        if (isset($data[$eventId]['pendaftar'][$regId])) {
            $statusSekarang = $data[$eventId]['pendaftar'][$regId]['hadir'];
            $data[$eventId]['pendaftar'][$regId]['hadir'] = !$statusSekarang;
            session(['data_registrasi_lengkap' => $data]);
            return redirect()->back()->with('success', 'Status kehadiran diperbarui!');
        }
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    public function checkInAnggota($eventId, $regId, $memberIndex)
    {
        $data = $this->getDataRegistrasi();
        if (isset($data[$eventId]['pendaftar'][$regId]['anggota'][$memberIndex])) {
            $statusSekarang = $data[$eventId]['pendaftar'][$regId]['anggota'][$memberIndex]['hadir'];
            $data[$eventId]['pendaftar'][$regId]['anggota'][$memberIndex]['hadir'] = !$statusSekarang;
            session(['data_registrasi_lengkap' => $data]);
            return redirect()->back()->with('success', 'Status anggota diperbarui!');
        }
        return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
    }
}