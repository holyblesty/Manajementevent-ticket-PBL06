<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Tiket;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $events = $query->orderBy('tgl_mulai', 'asc')->paginate(6);
        $jumlahTiket = Tiket::count();
        $riwayatPendaftaran = 0;

        $eventMendatang = Event::whereDate('tgl_mulai', '>=', now())->count();

        return view('pengunjung.dashboard', compact(
            'events',
            'jumlahTiket',
            'riwayatPendaftaran',
            'eventMendatang'
        ));
    }
} 