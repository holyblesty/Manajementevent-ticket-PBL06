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
        $selectedEvent = Event::with(['registrations.participants'])->findOrFail($id);
        
        $total = 0; $hadir = 0; $belumHadir = 0;
        foreach ($selectedEvent->registrations as $reg) {
            foreach ($reg->participants as $p) {
                $total++;
                $p->hadir ? $hadir++ : $belumHadir++;
            }
        }
        
        // PERBAIKAN: Menggunakan dot notation untuk mengarah ke file
        // Pastikan file Anda berada di: resources/views/admin/peserta/detail.blade.php
        return view('admin.peserta-detail', compact('selectedEvent', 'total', 'hadir', 'belumHadir'));
    }

    public function checkInIndividu($eventId, $regId) {
        $participant = Participant::where('id_registration', $regId)->firstOrFail();
        $participant->hadir = !$participant->hadir;
        $participant->save();
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }

    public function checkInAnggota($eventId, $regId, $memberIndex) {
        $participants = Participant::where('id_registration', $regId)->get();
        if (isset($participants[$memberIndex])) {
            $participants[$memberIndex]->hadir = !$participants[$memberIndex]->hadir;
            $participants[$memberIndex]->save();
            return redirect()->back()->with('success', 'Status berhasil diubah!');
        }
        return redirect()->back()->with('error', 'Peserta tidak ditemukan!');
    }
}