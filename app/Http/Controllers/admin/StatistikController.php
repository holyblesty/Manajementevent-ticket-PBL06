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
        // Filter bulan & tahun
        $selectedMonth = $request->query('bulan', date('m'));
        $selectedYear  = $request->query('tahun', date('Y'));

        // Query laporan
        $laporanEvent = Event::query()
            ->join('pemesanan', 'events.id_event', '=', 'pemesanan.id_event')
            ->join('kategori_events', 'events.id_kategori', '=', 'kategori_events.id_kategori')
            ->select(
                'events.id_event',
                'events.judul',
                'events.tgl_mulai',
                'events.kapasitas',
                'kategori_events.nama_kategori as kategori',
                DB::raw('COUNT(pemesanan.id_pesanan) as terjual'),
                DB::raw('SUM(pemesanan.total_harga) as pendapatan')
            )
            ->whereMonth('pemesanan.tgl_pesan', $selectedMonth)
            ->whereYear('pemesanan.tgl_pesan', $selectedYear)
            ->groupBy(
                'events.id_event',
                'events.judul',
                'events.tgl_mulai',
                'events.kapasitas',
                'kategori_events.nama_kategori'
            );

        // Sorting
        $sort = $request->query('sort', 'terbanyak');

        if ($sort == 'terdikit') {
            $laporanEvent->orderByRaw('COUNT(pemesanan.id_pesanan) ASC');
        } else {
            $laporanEvent->orderByRaw('COUNT(pemesanan.id_pesanan) DESC');
        }

        // Pagination
        $laporanEvent = $laporanEvent
            ->paginate(10)
            ->withQueryString();

        // Tambah status
        $laporanEvent->getCollection()->transform(function ($item) {

            $item->status = ($item->terjual >= $item->kapasitas)
                ? 'Terjual Habis'
                : 'Tersedia';

            $item->tanggal = $item->tgl_mulai
                ? date('d-m-Y', strtotime($item->tgl_mulai))
                : '-';

            $item->kuota = $item->kapasitas;

            $item->tipe = 'individu';

            return $item;
        });

        // Ringkasan
        $totalPendapatan = $laporanEvent->sum('pendapatan');
        $totalTiketTerjual = $laporanEvent->sum('terjual');

        // Event terlaris
        $terlaris = $laporanEvent->first();

        return view('admin.statistik', compact(
            'laporanEvent',
            'totalPendapatan',
            'totalTiketTerjual',
            'terlaris',
            'sort',
            'selectedMonth',
            'selectedYear'
        ));
    }
}