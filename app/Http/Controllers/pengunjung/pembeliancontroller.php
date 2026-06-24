<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function index($id)
    {
        $event = Event::with('tiket')
            ->findOrFail($id);

        return view(
            'pengunjung.pembelian-tiket',
            compact('event')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_event' => 'required',
            'id_tiket' => 'required',
            'jumlah_tiket' => 'required|integer|min:1'
        ]);

        $tiket = Tiket::findOrFail(
            $request->id_tiket
        );

        if (
            $request->jumlah_tiket >
            $tiket->kuota_tersedia
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kuota tiket tidak mencukupi'
                );
        }

        $total =
            $tiket->harga *
            $request->jumlah_tiket;

        Pemesanan::create([
            'id_event' =>
                $request->id_event,

            'id_pengunjung' =>
                Auth::user()->id_pengunjung,

            'id_tiket' =>
                $request->id_tiket,

            'tgl_pesan' =>
                now(),

            'metode_pembayaran' =>
                'Cash',

            'jumlah_tiket' =>
                $request->jumlah_tiket,

            'total_harga' =>
                $total,

            'kode_registrasi' =>
                'EVT'.rand(100000,999999),

            'sts_transaksi' =>
                'Belum Bayar'
        ]);

        $tiket->decrement(
            'kuota_tersedia',
            $request->jumlah_tiket
        );

        return redirect()
            ->route('pengunjung.riwayat')
            ->with(
                'success',
                'Pemesanan berhasil dibuat. Silakan melakukan pembayaran tunai kepada admin.'
            );
    }
}