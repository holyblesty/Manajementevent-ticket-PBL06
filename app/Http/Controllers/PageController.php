<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        // 1. Mengambil data acara untuk list bawah (DIBATASI MAKSIMAL 4 DATA TERBARU & STATUS OPEN)
        $events = Event::where('status_event', 'open')
            ->latest()
            ->take(4)
            ->get();

        // 2. Mengambil 3 acara terbaru khusus untuk slider (carousel) top banner
        $latestEvents = Event::where('status_event', 'open')
            ->latest()
            ->take(3)
            ->get();

        // Mengembalikan data ke view 'welcome' (landing page utama kamu)
        return view('welcome', compact('events', 'latestEvents'));
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
