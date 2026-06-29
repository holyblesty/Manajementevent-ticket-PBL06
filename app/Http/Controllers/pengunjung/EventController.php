<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(int $id)
    {
        $event = Event::findOrFail($id);

        return view(
            'pengunjung.detail-event',
            compact('event')
        );
    }
}