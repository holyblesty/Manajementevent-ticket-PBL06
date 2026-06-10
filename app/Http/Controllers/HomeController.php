<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::whereDate('tanggal', '>=', now())
                    ->orderBy('tanggal')
                    ->take(8)
                    ->get();

        $sliderEvents = Event::whereDate('tanggal', '>=', now())
                        ->orderBy('tanggal')
                        ->take(3)
                        ->get();

        return view('welcome', compact(
            'events',
            'sliderEvents'
        ));
    }
}