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
       // JIKA DATA KOSONG, KITA ISI DUMMY AGAR GRAFIK MUNCUL
        if (empty($dataRegistrasi)) {
            $dataRegistrasi = [
                // Kuota 100, terjual 25 (5 tim x 5 orang)
                1 => ['judul' => 'Turnamen Basket Antar Mahasiswa', 'kategori' => 'Olahraga', 'tanggal' => '20 Mei 2026', 'kuota' => 100, 'tipe' => 'tim', 'pendaftar' => array_fill(0, 5, ['anggota' => [1,2,3,4,5]])],
                
                // Kuota 150, terjual 125
                2 => ['judul' => 'Festival Musik Kampus 2026', 'kategori' => 'Hiburan', 'tanggal' => '30 Mei 2026', 'kuota' => 150, 'tipe' => 'individu', 'pendaftar' => array_fill(0, 125, ['hadir' => true])],
                
                // Kuota 50, terjual 48 (Hampir Penuh)
                3 => ['judul' => 'Peran AI dalam Transformasi Digital', 'kategori' => 'Seminar', 'tanggal' => '28 Mei 2026', 'kuota' => 50, 'tipe' => 'individu', 'pendaftar' => array_fill(0, 48, ['hadir' => true])],
                
                // Kuota 120, terjual 80 (8 tim x 10 orang)
                4 => ['judul' => 'Turnamen Futsal Antar Mahasiswa', 'kategori' => 'Olahraga', 'tanggal' => '01 Juni 2026', 'kuota' => 120, 'tipe' => 'tim', 'pendaftar' => array_fill(0, 8, ['anggota' => [1,2,3,4,5,6,7,8,9,10]])],
            ];
        }

        // 1. Ambil pilihan bulan dari request (Default: Mei)
        $selectedMonth = $request->query('bulan', 'Mei');

        // 2. Filter data array berdasarkan bulan yang dipilih (TETAP PAKAI BAHASA INDONESIA)
        $filteredData = array_filter($dataRegistrasi, function($item) use ($selectedMonth) {
            return stripos($item['tanggal'], $selectedMonth) !== false;
        });

        $laporanEvent = [];
        $totalPendapatan = 0;
        $totalTiketTerjual = 0;
        
        // Harga tiket per kategori
        $hargaKategori = ['Olahraga' => 20000, 'Hiburan' => 100000, 'Seminar' => 25000];

        // 3. Lakukan looping HANYA pada data yang sudah difilter
        foreach ($filteredData as $id => $item) {
            $total = ($item['tipe'] == 'tim') ? array_sum(array_map('count', array_column($item['pendaftar'], 'anggota'))) : count($item['pendaftar']);
            $harga = $hargaKategori[$item['kategori']] ?? 50000;
            $pendapatan = $total * $harga;
            
            // --- LOGIKA FORMAT TANGGAL (dd-mm-yy) ---
            // Translate bulan ke bahasa Inggris sementara supaya bisa dibaca oleh fungsi PHP
            $englishDate = str_replace(['Mei', 'Juni'], ['May', 'June'], $item['tanggal']);
            // Ubah format string tanggal menjadi dd-mm-yy (contoh: 20-05-26)
            $tanggalFormatted = date('d-m-y', strtotime($englishDate));
            // ----------------------------------------
            
            $laporanEvent[] = [
                'tanggal' => $tanggalFormatted,
                'judul' => $item['judul'],
                'kategori' => $item['kategori'],
                'kuota' => $item['kuota'],
                'tipe' => $item['tipe'] ?? 'individu', // <--- TAMBAHKAN BARIS INI
                'terjual' => $total,
                'pendapatan' => $pendapatan,
                'status' => ($total >= $item['kuota']) ? 'Terjual Habis' : 'Tersedia'
            ];

            $totalPendapatan += $pendapatan;
            $totalTiketTerjual += $total;
        }

        // 4. Sortir data berdasarkan penjualan
        $sort = $request->query('sort', 'terbanyak');
        usort($laporanEvent, $sort == 'terdikit' ? fn($a, $b) => $a['terjual'] <=> $b['terjual'] : fn($a, $b) => $b['terjual'] <=> $a['terjual']);
        
        $terlaris = count($laporanEvent) > 0 ? collect($laporanEvent)->sortByDesc('terjual')->first() : ['judul' => '-'];

        // 5. Kirim semua data termasuk 'selectedMonth' agar tidak error di Blade
        return view('admin.statistik', compact('totalPendapatan', 'totalTiketTerjual', 'laporanEvent', 'terlaris', 'sort', 'selectedMonth'));
    }
}