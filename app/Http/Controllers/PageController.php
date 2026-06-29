<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mengambil data acara untuk list bawah
        $events = Event::where('status_event', 'open')
            ->latest()
            ->take(4)
            ->get();

        // 1. Mengambil 3 acara terbaru untuk Slider (Carousel)
        $latestEvents = Event::where('status_event', 'open')
            ->latest()
            ->take(3)
            ->get();

        // 2. Logika yang lebih ketat:
        // Jika tombol ditekan, tampilkan semua. JIKA TIDAK, ambil 8 saja.
        if ($request->has('view_all') && $request->view_all == 'true') {
            $events = Event::where('status_event', 'open')->latest()->get();
        } else {
            $events = Event::where('status_event', 'open')->latest()->take(4)->get();
        }

        return view('welcome', compact('latestEvents', 'events'));
    }

    // FUNGSI PENCARIAN (Sudah diperbarui dengan JOIN)
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        // Melakukan JOIN agar bisa mencari berdasarkan nama_kategori
        $events = Event::join('kategori_events', 'events.id_kategori', '=', 'kategori_events.id_kategori')
            ->where('events.status_event', 'open')
            ->where(function ($query) use ($keyword) {
                $query->where('events.judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('events.lokasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('kategori_events.nama_kategori', 'LIKE', "%{$keyword}%");
            })
            ->select('events.*') // Hanya ambil kolom dari tabel events agar tidak bentrok
            ->get();

        // Mengambil data untuk slider agar carousel tetap tampil
        $latestEvents = Event::where('status_event', 'open')
            ->latest()
            ->take(3)
            ->get();

        // Kirim hasil pencarian ke view 'welcome'
        return view('welcome', compact('events', 'latestEvents', 'keyword'));
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak()
    {
        return view('kontak');
    }
}
