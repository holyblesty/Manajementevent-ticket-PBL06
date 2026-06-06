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

        // JIKA DATA KOSONG, KITA HENTIKAN PROSES DAN KIRIM VARIABEL KOSONG
        if (empty($dataRegistrasi)) {
            return view('admin.statistik', [
                'laporanEvent' => [],
                'totalPendapatan' => 0,
                'totalTiketTerjual' => 0,
                'terlaris' => ['judul' => '-'],
                'sort' => $request->query('sort', 'terbanyak'),
                'selectedMonth' => $request->query('bulan', 'Mei')
            ]);
        }

        // =========================
        // FILTER BULAN
        // =========================
        $selectedMonth = $request->query('bulan', 'Mei');
        $filteredData = array_filter(
            $dataRegistrasi,
            fn($item) => stripos($item['tanggal'], $selectedMonth) !== false
        );

        $laporanEvent = [];
        $totalPendapatan = 0;
        $totalTiketTerjual = 0;
        $hargaKategori = [
            'Olahraga' => 20000,
            'Hiburan'  => 100000,
            'Seminar'  => 25000
        ];

        // =========================
        // PROSES DATA
        // =========================
        foreach ($filteredData as $item) {
            $anggotaPerTim = 1;
            
            if (($item['tipe'] ?? '') == 'tim') {
                $timPertama = reset($item['pendaftar']);
                $anggotaPerTim = count($timPertama['anggota'] ?? 0);
                $total = count($item['pendaftar']) * $anggotaPerTim;
                $kuotaTiket = $item['kuota'] * $anggotaPerTim;
            } else {
                $total = count($item['pendaftar']);
                $kuotaTiket = $item['kuota'];
            }

            $harga = $hargaKategori[$item['kategori']] ?? 50000;
            $pendapatan = $total * $harga;

            $laporanEvent[] = [
                'tanggal' => date('d-m-y', strtotime(str_replace(['Mei', 'Juni'], ['May', 'June'], $item['tanggal']))),
                'judul' => $item['judul'],
                'kategori' => $item['kategori'],
                'kuota' => $kuotaTiket,
                'tipe' => $item['tipe'] ?? 'individu',
                'terjual' => $total,
                'pendapatan' => $pendapatan,
                'status' => ($total >= $kuotaTiket) ? 'Terjual Habis' : 'Tersedia'
            ];

            $totalPendapatan += $pendapatan;
            $totalTiketTerjual += $total;
        }

        // =========================
        // SORTING & TERLARIS
        // =========================
        $sort = $request->query('sort', 'terbanyak');
        usort($laporanEvent, $sort == 'terdikit' ? fn($a, $b) => $a['terjual'] <=> $b['terjual'] : fn($a, $b) => $b['terjual'] <=> $a['terjual']);

        $terlaris = count($laporanEvent) > 0 ? collect($laporanEvent)->sortByDesc('terjual')->first() : ['judul' => '-'];

        return view('admin.statistik', compact('totalPendapatan', 'totalTiketTerjual', 'laporanEvent', 'terlaris', 'sort', 'selectedMonth'));
    }
}