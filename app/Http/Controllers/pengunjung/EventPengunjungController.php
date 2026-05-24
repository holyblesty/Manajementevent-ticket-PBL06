<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class EventPengunjungController extends Controller
{

    public function dashboard()
    {
        $events = Event::with('tikets')->latest()->take(3)->get(); //mengambil seluruh data event
        return view('beranda.index', compact('events'));
    }

    public function index()
    {
        $events = Event::with('tikets')->get();
        return view('events.index', compact('events'));
    }
    public function show($id)
    {
        $event = Event::with('tikets')->findOrFail($id); //menampilkan detail event berdasarkan Id
        return view('events.show', compact('event'));
    }
}