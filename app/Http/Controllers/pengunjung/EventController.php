<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view(
            'pengunjung.detail-event',
            compact('event')
        );
    }
}