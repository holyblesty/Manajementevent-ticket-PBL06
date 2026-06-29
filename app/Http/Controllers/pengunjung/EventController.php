<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function show(int $id)
    {
        $event = Event::with('tiket')->findOrFail($id);

        return view('pengunjung.detail-event', compact('event'));
    }
}
