<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    private function getDataRegistrasi()
    {
        return session('data_peserta_final_v15', []);
    }

    public function index(Request $request)
    {
        $dataRegistrasi = $this->getDataRegistrasi();

        // =========================
        // DUMMY DATA JIKA KOSONG
        // =========================
        if (empty($dataRegistrasi)) {

            $dataRegistrasi = [

                // Basket
                1 => [
                    'judul' => 'Turnamen Basket Antar Mahasiswa',
                    'kategori' => 'Olahraga',
                    'tanggal' => '20 Mei 2026',
                    'kuota' => 5, // jumlah tim
                    'tipe' => 'tim',
                    'pendaftar' => [
                        301 => [
                            'nama_tim' => 'Slam Dunk',
                            'anggota' => [1,2,3,4,5]
                        ],
                        302 => [
                            'nama_tim' => 'Haikyuu',
                            'anggota' => [1,2,3,4,5]
                        ],
                        303 => [
                            'nama_tim' => 'Blue Lock',
                            'anggota' => [1,2,3,4,5]
                        ],
                        304 => [
                            'nama_tim' => 'Kuroko',
                            'anggota' => [1,2,3,4,5]
                        ],
                        305 => [
                            'nama_tim' => 'Ahiru',
                            'anggota' => [1,2,3,4,5]
                        ],
                    ]
                ],

                // Musik
                2 => [
                    'judul' => 'Festival Musik Kampus 2026',
                    'kategori' => 'Hiburan',
                    'tanggal' => '30 Mei 2026',
                    'kuota' => 150,
                    'tipe' => 'individu',
                    'pendaftar' => array_fill(
                        0,
                        125,
                        ['hadir' => true]
                    )
                ],

                // Seminar
                3 => [
                    'judul' => 'Peran AI dalam Transformasi Digital',
                    'kategori' => 'Seminar',
                    'tanggal' => '28 Mei 2026',
                    'kuota' => 50,
                    'tipe' => 'individu',
                    'pendaftar' => array_fill(
                        0,
                        48,
                        ['hadir' => true]
                    )
                ],

                // Futsal
                4 => [
                    'judul' => 'Turnamen Futsal Antar Mahasiswa',
                    'kategori' => 'Olahraga',
                    'tanggal' => '01 Juni 2026',
                    'kuota' => 32, // jumlah tim
                    'tipe' => 'tim',
                    'pendaftar' => [
                        401 => [
                            'nama_tim' => 'Real Madrid',
                            'anggota' => [1,2,3,4,5,6,7,8,9,10,11]
                        ],
                        402 => [
                            'nama_tim' => 'Barcelona',
                            'anggota' => [1,2,3,4,5,6,7,8,9,10,11]
                        ],
                        403 => [
                            'nama_tim' => 'MU',
                            'anggota' => [1,2,3,4,5,6,7,8,9,10,11]
                        ],
                        404 => [
                            'nama_tim' => 'Chelsea',
                            'anggota' => [1,2,3,4,5,6,7,8,9,10,11]
                        ],
                        405 => [
                            'nama_tim' => 'Inter',
                            'anggota' => [1,2,3,4,5,6,7,8,9,10,11]
                        ],
                    ]
                ],
            ];
        }

        // =========================
        // FILTER BULAN
        // =========================

        $selectedMonth = $request->query('bulan', 'Mei');

        $filteredData = array_filter(
            $dataRegistrasi,
            function ($item) use ($selectedMonth) {

                return stripos(
                    $item['tanggal'],
                    $selectedMonth
                ) !== false;
            }
        );

        // =========================
        // VARIABLE
        // =========================

        $laporanEvent = [];

        $totalPendapatan = 0;

        $totalTiketTerjual = 0;

        // =========================
        // HARGA TIKET
        // =========================

        $hargaKategori = [
            'Olahraga' => 20000,
            'Hiburan'  => 100000,
            'Seminar'  => 25000
        ];

        // =========================
        // LOOP DATA EVENT
        // =========================

        foreach ($filteredData as $id => $item) {

            // =========================
            // EVENT TIM
            // =========================

            if (($item['tipe'] ?? '') == 'tim') {

                // jumlah tim
                $jumlahTim = count($item['pendaftar']);

                // default anggota
                $anggotaPerTim = 0;

                // ambil tim pertama
                $timPertama = reset($item['pendaftar']);

                if (
                    isset($timPertama['anggota']) &&
                    is_array($timPertama['anggota'])
                ) {

                    $anggotaPerTim = count(
                        $timPertama['anggota']
                    );
                }

                // tiket terjual
                $total = $jumlahTim * $anggotaPerTim;

                // total kapasitas tiket
                $kuotaTiket = $item['kuota'] * $anggotaPerTim;

            } else {

                // EVENT INDIVIDU
                $total = count($item['pendaftar']);

                $kuotaTiket = $item['kuota'];
            }

            // =========================
            // PENDAPATAN
            // =========================

            $harga = $hargaKategori[$item['kategori']] ?? 50000;

            $pendapatan = $total * $harga;

            // =========================
            // FORMAT TANGGAL
            // =========================

            $englishDate = str_replace(
                ['Mei', 'Juni'],
                ['May', 'June'],
                $item['tanggal']
            );

            $tanggalFormatted = date(
                'd-m-y',
                strtotime($englishDate)
            );

            // =========================
            // DATA LAPORAN
            // =========================

            $laporanEvent[] = [

                'tanggal' => $tanggalFormatted,

                'judul' => $item['judul'],

                'kategori' => $item['kategori'],

                // kapasitas tiket
                'kuota' => $kuotaTiket,

                'tipe' => $item['tipe'] ?? 'individu',

                // tiket terjual
                'terjual' => $total,

                'pendapatan' => $pendapatan,

                'status' => ($total >= $kuotaTiket)
                    ? 'Terjual Habis'
                    : 'Tersedia'
            ];

            // TOTAL GLOBAL
            $totalPendapatan += $pendapatan;

            $totalTiketTerjual += $total;
        }

        // =========================
        // SORTING
        // =========================

        $sort = $request->query('sort', 'terbanyak');

        usort(
            $laporanEvent,
            $sort == 'terdikit'
                ? fn($a, $b) => $a['terjual'] <=> $b['terjual']
                : fn($a, $b) => $b['terjual'] <=> $a['terjual']
        );

        // =========================
        // EVENT TERLARIS
        // =========================

        $terlaris = count($laporanEvent) > 0
            ? collect($laporanEvent)
                ->sortByDesc('terjual')
                ->first()
            : ['judul' => '-'];

        // =========================
        // RETURN VIEW
        // =========================

        return view(
            'admin.statistik',
            compact(
                'totalPendapatan',
                'totalTiketTerjual',
                'laporanEvent',
                'terlaris',
                'sort',
                'selectedMonth'
            )
        );
    }
}