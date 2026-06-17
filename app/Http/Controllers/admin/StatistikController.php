<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input bulan dan tahun dengan default bulan/tahun saat ini
        $selectedMonth = $request->query('bulan', date('m'));
        $selectedYear = $request->query('tahun', date('Y'));

        // 2. Mapping angka ke nama bulan untuk kebutuhan filter/tampilan
        $listBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        // 3. Query Data Statistik dari Database
        $laporanEvent = Event::query()
            ->join('pemesanan', 'events.id_event', '=', 'pemesanan.id_event')
            ->join('kategori_events', 'events.id_kategori', '=', 'kategori_events.id_kategori') 
            ->select(
                'events.judul',
                'kategori_events.nama_kategori as kategori', 
                DB::raw('COUNT(pemesanan.id_pesanan) as terjual'),
                DB::raw('SUM(pemesanan.total_harga) as pendapatan'),
                DB::raw('MAX(events.kapasitas) as kuota')
            )
            ->whereMonth('pemesanan.tgl_pesan', $selectedMonth)
            ->whereYear('pemesanan.tgl_pesan', $selectedYear)
            ->groupBy('events.id_event', 'events.judul', 'kategori_events.nama_kategori')
            ->get()
            ->map(function ($item) {
                // Logika status otomatis
                $item->status = ($item->terjual >= $item->kuota) ? 'Terjual Habis' : 'Tersedia';
                return $item;
            });

        // 4. Perhitungan Ringkasan
        $totalPendapatan = $laporanEvent->sum('pendapatan');
        $totalTiketTerjual = $laporanEvent->sum('terjual');

        // 5. Logika Sorting
        $sort = $request->query('sort', 'terbanyak');
        $laporanEvent = ($sort == 'terdikit') 
            ? $laporanEvent->sortBy('terjual') 
            : $laporanEvent->sortByDesc('terjual');

        // 6. Data Event Terlaris
        $terlaris = $laporanEvent->first() ?? ['judul' => 'Belum Ada Data'];

        // 7. Kirim data ke view
        return view('admin.statistik', compact(
            'totalPendapatan', 
            'totalTiketTerjual', 
            'laporanEvent', 
            'terlaris', 
            'sort', 
            'selectedMonth', 
            'selectedYear'
        ));
    }
}