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
        $selectedMonth = $request->query('bulan', date('m'));
        $selectedYear = $request->query('tahun', date('Y'));

        // Menggunakan JOIN yang benar sesuai nama tabel dan kolom Anda
        $laporanEvent = Event::query()
            ->join('pemesanan', 'events.id_event', '=', 'pemesanan.id_event')
            ->join('kategori_events', 'events.id_kategori', '=', 'kategori_events.id_kategori') 
            ->select(
                'events.judul',
                'kategori_events.nama_kategori as kategori', 
                DB::raw('COUNT(pemesanan.id_pesanan) as terjual'),
                DB::raw('SUM(pemesanan.total_harga) as pendapatan'),
                DB::raw('MAX(events.kapasitas) as kuota') // Menggunakan 'kapasitas'
            )
            // Menggunakan 'tgl_pesan' sebagai pengganti 'created_at'
            ->whereMonth('pemesanan.tgl_pesan', $selectedMonth)
            ->whereYear('pemesanan.tgl_pesan', $selectedYear)
            ->groupBy('events.id_event', 'events.judul', 'kategori_events.nama_kategori')
            ->get()
            ->map(function ($item) {
                $item->status = ($item->terjual >= $item->kuota) ? 'Terjual Habis' : 'Tersedia';
                return $item;
            });

        $totalPendapatan = $laporanEvent->sum('pendapatan');
        $totalTiketTerjual = $laporanEvent->sum('terjual');

        $sort = $request->query('sort', 'terbanyak');
        $laporanEvent = ($sort == 'terdikit') 
            ? $laporanEvent->sortBy('terjual') 
            : $laporanEvent->sortByDesc('terjual');

        $terlaris = $laporanEvent->first() ?? ['judul' => '-'];

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