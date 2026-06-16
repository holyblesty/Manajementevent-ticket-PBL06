<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

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

    // FUNGSI PENCARIAN (Baru ditambahkan)
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        // Mencari acara berdasarkan judul atau lokasi yang statusnya 'open'
        $events = Event::where('status_event', 'open')
            ->where(function ($query) use ($keyword) {
                $query->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('lokasi', 'LIKE', "%{$keyword}%");
            })
            ->get();

        // Mengambil data untuk slider agar tidak error saat di view
        $latestEvents = Event::where('status_event', 'open')
            ->latest()
            ->take(3)
            ->get();

        // Tetap kembalikan ke view 'welcome' agar hasilnya tampil di halaman utama
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
