<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index()
    {
        // 1. Mengambil data acara untuk list bawah
        $events = Event::where('status_event', 'open')
            ->latest()
            ->take(4)
            ->get();

        // 2. Mengambil 3 acara terbaru khusus untuk slider
        $latestEvents = Event::where('status_event', 'open')
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('events', 'latestEvents'));
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

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
