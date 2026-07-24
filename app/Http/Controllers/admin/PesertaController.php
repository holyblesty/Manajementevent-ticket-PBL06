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
        $events = Event::with('kategori')->paginate(5);

        foreach ($events as $event) {

            $total = $event->pemesanan()
                ->where('sts_transaksi', 'Lunas')
                ->sum('jumlah_tiket');

            $event->total_pendaftar = $total;

            $kapasitas = $event->kapasitas;

            if ($kapasitas == 0) {

                $event->status_kuota = 'KOSONG';
                $event->warna_badge = 'bg-yellow-50 text-yellow-700 border-yellow-200';

            } elseif ($total >= $kapasitas) {

                $event->status_kuota = 'PENUH';
                $event->warna_badge = 'bg-red-50 text-red-700 border-red-200';

            } else {

                $event->status_kuota = 'TERSEDIA';
                $event->warna_badge = 'bg-blue-50 text-blue-700 border-blue-200';
            }
        }

        return view('admin.peserta', compact('events'));
    }

    public function detail(Request $request, int $id)
{
        $selectedEvent = Event::with([
    'menghadiri' => function ($query) use ($request) {

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('kode_registrasi', 'like', '%' . $request->search . '%')

                  ->orWhereHas('pengunjung', function ($pengunjung) use ($request) {

                      $pengunjung->where('name', 'like', '%' . $request->search . '%')
                                 ->orWhere('email', 'like', '%' . $request->search . '%');

                  });

            });

        }

    },

    'menghadiri.pengunjung'

])->findOrFail($id);

        $total = $selectedEvent->menghadiri->count();

        $hadir = $selectedEvent->menghadiri
            ->where('sts_checkin', 'sudah')
            ->count();

        $belumHadir = $selectedEvent->menghadiri
            ->where('sts_checkin', 'belum')
            ->count();

        $kapasitas = $selectedEvent->kapasitas;

        if ($kapasitas == 0) {

            $statusKuota = 'Kosong';

        } elseif ($total >= $kapasitas) {

            $statusKuota = 'Penuh';

        } else {

            $statusKuota = 'Tersedia';
        }

        return view(
            'admin.peserta-detail',
            compact(
                'selectedEvent',
                'total',
                'hadir',
                'belumHadir',
                'statusKuota'
            )
        );
    }

    public function checkInIndividu(int $eventId, int $id_partisipan)
    {
        $participant = Menghadiri::findOrFail($id_partisipan);

        $participant->sts_checkin =
            $participant->sts_checkin === 'sudah'
                ? 'belum'
                : 'sudah';

        $participant->save();

        return redirect()->back()->with(
            'success',
            'Status check-in berhasil diubah!'
        );
    }
}