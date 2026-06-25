<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranEventController extends Controller
{
    public function create(int $id)
    {
        $event = Event::with('tiket')
                    ->findOrFail($id);

        return view(
            'pengunjung.daftar-event',
            compact('event')
        );
    }

    public function store(Request $request,int $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'id_tiket'=>'required',
            'nama_peserta'=>'required',
            'email'=>'required|email',
            'no_hp'=>'required',
            'jumlah_tiket'=>'required|min:1'
        ]);

        if($event->kuota_tersedia <= 0)
        {
            return back()
                ->with('error',
                'Kuota event sudah habis');
        }

        Pemesanan::create([

            'id_user'=>Auth::id(),

            'id_event'=>$event->id_event,

            'id_tiket'=>$request->id_tiket,

            'nama_peserta'=>$request->nama_peserta,

            'email'=>$request->email,

            'no_hp'=>$request->no_hp,

            'jumlah_tiket'=>$request->jumlah_tiket,

            'status'=>'menunggu'
        ]);

        $event->decrement(
            'kuota_tersedia',
            $request->jumlah_tiket
        );

        return redirect()
            ->route('riwayat.pendaftaran')
            ->with(
                'success',
                'Pendaftaran berhasil'
            );
    }
}