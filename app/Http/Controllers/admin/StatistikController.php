<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    private function getDataRegistrasi() {
        return session('data_peserta_final_v15', []);
    }

    public function index(Request $request)
    {
        $dataRegistrasi = $this->getDataRegistrasi();
        
        // JIKA DATA KOSONG, KITA ISI DUMMY AGAR GRAFIK MUNCUL
        if (empty($dataRegistrasi)) {
            $dataRegistrasi = [
                1 => ['judul' => 'Turnamen Basket', 'kategori' => 'Olahraga', 'tanggal' => '20 Mei 2026', 'kuota' => 100, 'tipe' => 'perorangan', 'pendaftar' => [['hadir' => true]]],
                2 => ['judul' => 'Festival Musik', 'kategori' => 'Hiburan', 'tanggal' => '25 Mei 2026', 'kuota' => 100, 'tipe' => 'perorangan', 'pendaftar' => [['hadir' => true], ['hadir' => true]]],
                3 => ['judul' => 'Turnamen Futsal', 'kategori' => 'Olahraga', 'tanggal' => '01 Juni 2026', 'kuota' => 100, 'tipe' => 'perorangan', 'pendaftar' => [['hadir' => true], ['hadir' => true], ['hadir' => true]]],
            ];
        }

        $laporanEvent = [];
        $totalPendapatan = 0;
        $totalTiketTerjual = 0;
        $hargaKategori = ['Olahraga' => 20000, 'Hiburan' => 100000, 'Seminar' => 25000];

        foreach ($dataRegistrasi as $id => $item) {
            $total = ($item['tipe'] == 'tim') ? array_sum(array_map('count', array_column($item['pendaftar'], 'anggota'))) : count($item['pendaftar']);
            $harga = $hargaKategori[$item['kategori']] ?? 50000;
            $pendapatan = $total * $harga;
            
            $laporanEvent[] = [
                'tanggal' => $item['tanggal'],
                'judul' => $item['judul'],
                'kategori' => $item['kategori'],
                'kuota' => $item['kuota'],
                'terjual' => $total,
                'pendapatan' => $pendapatan,
                'status' => ($total >= $item['kuota']) ? 'Terjual Habis' : 'Tersedia'
            ];

            $totalPendapatan += $pendapatan;
            $totalTiketTerjual += $total;
        }

        $sort = $request->query('sort', 'terbanyak');
        usort($laporanEvent, $sort == 'terdikit' ? fn($a, $b) => $a['terjual'] <=> $b['terjual'] : fn($a, $b) => $b['terjual'] <=> $a['terjual']);
        
        $terlaris = count($laporanEvent) > 0 ? collect($laporanEvent)->sortByDesc('terjual')->first() : ['judul' => '-'];

        return view('admin.statistik', compact('totalPendapatan', 'totalTiketTerjual', 'laporanEvent', 'terlaris', 'sort'));
    }
}