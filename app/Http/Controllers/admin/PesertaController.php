<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Menghadiri; 
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index() {
        $events = Event::with('kategori')->paginate(10);
        return view('admin.peserta', compact('events'));
    }

    public function detail(int $id) { 
        // Menggunakan with agar relasi dipanggil sekaligus (Eager Loading)
        $selectedEvent = Event::with(['pemesanan.participants'])->findOrFail($id);
        
        $total = 0; $hadir = 0; $belumHadir = 0;

        // Pengecekan null menggunakan null-coalescing operator ?? 
        // Jika pemesanan null, maka foreach akan mengulang array kosong (tidak error)
        foreach ($selectedEvent->pemesanan ?? [] as $pesanan) {
            // Sama halnya dengan participants
            foreach ($pesanan->participants ?? [] as $p) {
                $total++;
                ($p->sts_checkin == 'sudah') ? $hadir++ : $belumHadir++;
            }
        }
        
        return view('admin.peserta-detail', compact('selectedEvent', 'total', 'hadir', 'belumHadir'));
    }

    public function checkInIndividu(int $eventId, int $id_partisipan) {
        $participant = Menghadiri::findOrFail($id_partisipan); 
        
        // Toggle status
        $participant->sts_checkin = ($participant->sts_checkin === 'sudah') ? 'belum' : 'sudah';
        $participant->save();
        
        return redirect()->back()->with('success', 'Status check-in berhasil diubah!');
    }
}