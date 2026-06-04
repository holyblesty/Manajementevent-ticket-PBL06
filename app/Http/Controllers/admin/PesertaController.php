<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index() {
        $events = Event::paginate(10);
        return view('admin.peserta', compact('events'));
    }

    public function detail($id) {
        // Mengambil event beserta pesertanya
        $selectedEvent = Event::with(['registrations.participants'])->findOrFail($id);
        
        $total = 0; 
        $hadir = 0; 
        $belumHadir = 0;

        // Menghitung statistik kehadiran
        foreach ($selectedEvent->registrations as $reg) {
            foreach ($reg->participants as $p) {
                $total++;
                $p->hadir ? $hadir++ : $belumHadir++;
            }
        }
        
        return view('admin.peserta-detail', compact('selectedEvent', 'total', 'hadir', 'belumHadir'));
    }

    // Fungsi checkInIndividu tetap dipertahankan
    public function checkInIndividu($eventId, $regId) {
        $participant = Participant::where('id_registration', $regId)->firstOrFail();
        $participant->hadir = !$participant->hadir;
        $participant->save();
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
}