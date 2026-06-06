<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Menghadiri; // Ganti ini
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index() {
        $events = Event::paginate(10);
        return view('admin.peserta', compact('events'));
    }

    // Tambahkan type hint (int) untuk $id
    public function detail(int $id) { 
        // Sesuaikan relasi jika di Event.php sudah menggunakan participants() yang mengarah ke Menghadiri
        $selectedEvent = Event::with(['registrations.participants'])->findOrFail($id);
        
        $total = 0; 
        $hadir = 0; 
        $belumHadir = 0;

        foreach ($selectedEvent->registrations as $reg) {
            foreach ($reg->participants as $p) {
                $total++;
                $p->sts_checkin == 'sudah' ? $hadir++ : $belumHadir++; // Sesuaikan dengan kolom status
            }
        }
        
        return view('admin.peserta-detail', compact('selectedEvent', 'total', 'hadir', 'belumHadir'));
    }

    // Tambahkan type hint (int)
    public function checkInIndividu(int $eventId, int $regId) {
        // Gunakan model Menghadiri
        $participant = Menghadiri::where('id_event', $eventId)->firstOrFail(); 
        
        // Logika toggle status
        $participant->sts_checkin = ($participant->sts_checkin == 'sudah') ? 'belum' : 'sudah';
        $participant->save();
        
        return redirect()->back()->with('success', 'Status berhasil diubah!');
    }
}