<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Menghadiri;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        // Mengambil event dengan relasi kategori
        $events = Event::with('kategori')->paginate(5);

        foreach ($events as $event) {
            // Asumsi total pendaftar dihitung dari relasi, sesuaikan dengan logic aplikasi Anda
            // Jika Anda punya relasi, bisa gunakan $event->pemesanan_count
            $total = $event->total_pendaftar ?? 0;
            $kapasitas = $event->kapasitas ?? 0;

            // --- LOGIKA STATUS KUOTA ---
            if ($kapasitas == 0) {
                // Kuning: Kapasitas belum disetting / 0
                $event->status_kuota = 'KOSONG';
                $event->warna_badge = 'bg-yellow-50 text-yellow-700 border-yellow-200';
            } elseif ($total >= $kapasitas) {
                // Merah: Sudah penuh
                $event->status_kuota = 'PENUH';
                $event->warna_badge = 'bg-red-50 text-red-700 border-red-200';
            } else {
                // Biru: Tersedia (termasuk 0/20 karena kapasitas > 0)
                $event->status_kuota = 'TERSEDIA';
                $event->warna_badge = 'bg-blue-50 text-blue-700 border-blue-200';
            }
        }

        return view('admin.peserta', compact('events'));
    }

    public function detail(int $id)
    {
        $selectedEvent = Event::with(['pemesanan.participants'])->findOrFail($id);

        $total = 0;
        $hadir = 0;
        $belumHadir = 0;

        foreach ($selectedEvent->pemesanan ?? [] as $pesanan) {
            foreach ($pesanan->participants ?? [] as $p) {
                $total++;
                ($p->sts_checkin == 'sudah') ? $hadir++ : $belumHadir++;
            }
        }

        // --- LOGIKA STATUS KUOTA (DETAIL) ---
        $kapasitas = $selectedEvent->kapasitas ?? 0;

        if ($kapasitas == 0) {
            $statusKuota = 'Kosong';       // Kuning
        } elseif ($total >= $kapasitas) {
            $statusKuota = 'Penuh';        // Merah
        } else {
            $statusKuota = 'Tersedia';     // Biru
        }

        return view('admin.peserta-detail', compact(
            'selectedEvent',
            'total',
            'hadir',
            'belumHadir',
            'statusKuota'
        ));
    }

    public function checkInIndividu(int $eventId, int $id_partisipan)
    {
        $participant = Menghadiri::findOrFail($id_partisipan);

        $participant->sts_checkin = ($participant->sts_checkin === 'sudah') ? 'belum' : 'sudah';
        $participant->save();

        return redirect()->back()->with('success', 'Status check-in berhasil diubah!');
    }
}
