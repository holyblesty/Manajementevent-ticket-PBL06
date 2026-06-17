<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{


    // Menampilkan halaman form pendaftaran
    public function create($id_event)
    {
        $event = Event::findOrFail($id_event);

        return view(
            'pengunjung.pendaftaran.create',
            compact('event')
        );
    }



    // Menyimpan pendaftaran
    public function store(Request $request)
    {

        $request->validate([
            'id_event' => 'required',
            'nama_pendaftar' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'jenis_tiket' => 'required',
            'jumlah_tiket' => 'required|integer|min:1'
        ]);


        Pendaftaran::create([

            'id_event' => $request->id_event,

            'nama_pendaftar' => $request->nama_pendaftar,

            'email' => $request->email,

            'no_hp' => $request->no_hp,

            'jenis_tiket' => $request->jenis_tiket,

            'jumlah_tiket' => $request->jumlah_tiket,

            'tanggal_daftar' => now(),

            'status' => 'Menunggu Pembayaran'
        ]);


        return redirect()
            ->route('beranda')
            ->with(
                'success',
                'Pendaftaran berhasil, silahkan melakukan pembayaran ke kasir.'
            );
    }
}