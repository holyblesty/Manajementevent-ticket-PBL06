<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class EventPengunjungController extends Controller
{
    public function dashboard()
    {
        $events = Event::with('tikets')
            ->latest()
            ->take(3)
            ->get();

        return view('beranda.index', compact('events'));
    }

    public function index()
    {
        $events = Event::with('tikets')->get();

        return view('events.index', compact('events'));
    }

    public function show(int $id)
    {
        $event = Event::with('tikets')->findOrFail($id);

        return view('events.show', compact('event'));
    }
}
