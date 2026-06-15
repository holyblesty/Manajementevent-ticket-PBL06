<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        // Mengambil semua data acara untuk list di bawah
        $events = Event::all();

        // Mengambil 3 acara terbaru untuk slider (carousel)
        $latestEvents = Event::latest()->take(3)->get();

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
