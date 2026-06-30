<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Pemesanan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();

        // Query event
        $query = Event::with('kategori')
            ->where('status_event', 'open');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Ambil event
        $events = $query->orderBy('tgl_mulai', 'asc')
            ->paginate(6)
            ->appends($request->query());

        // Statistik
        $jumlahTiket = $user
            ? Pemesanan::where('id_pengunjung', $user->id_pengunjung)
                ->where('sts_transaksi', 'Lunas')
                ->count()
            : 0;

        $riwayatPendaftaran = $user
            ? Pemesanan::where('id_pengunjung', $user->id_pengunjung)
                ->count()
            : 0;

        $eventMendatang = Event::whereDate('tgl_mulai', '>=', now())
            ->where('status_event', 'open')
            ->count();

        return view('pengunjung.dashboard', compact(
            'events',
            'jumlahTiket',
            'riwayatPendaftaran',
            'eventMendatang'
        ));
    }
}