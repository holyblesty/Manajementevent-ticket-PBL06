<?php

namespace App\Http\Controllers\pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pembeliancontroller extends Controller
{
    public function index(int $id_event)
    {
        $event = Event::findOrFail($id_event);

        $tiket = Tiket::where(
            'id_event',
            $id_event
        )->get();

        $user = Auth::user();

        return view(
            'pengunjung.pembeliantiket',
            compact('event', 'tiket', 'user')
        );
    }

    // Memproses data pendaftaran & transaksi pembelian tiket
    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
            'id_event' => 'required',
            'id_tiket' => 'required',
            'jumlah_tiket' => 'required|integer|min:1'
        ]);

        /** @var \App\Models\Pengunjung  */
        $pengunjung = Auth::user();

        $pengunjung->name = $request->name;
        $pengunjung->email = $request->email;
        $pengunjung->no_hp = $request->no_hp;
        $pengunjung->alamat = $request->alamat;
        $pengunjung->save();

        $tiket = Tiket::findOrFail(
            $request->id_tiket
        );

        if (
            $request->jumlah_tiket >
            $tiket->kuota_tersedia
        ) {
            return back()->with(
                'error',
                'Kuota tiket tidak mencukupi.'
            );
        }

        $pemesanan = Pemesanan::create([
            'id_event' => $request->id_event,
            'id_pengunjung' => $pengunjung->id_pengunjung,
            'id_tiket' => $request->id_tiket,
            'tgl_pesan' => now(),
            'tgl_bayar' => null,
            'metode_pembayaran' => 'Cash',
            'total_harga' =>
            $tiket->harga *
                $request->jumlah_tiket,
            'jumlah_tiket' =>
            $request->jumlah_tiket,
            'kode_registrasi' =>
            Pemesanan::generateKode(),
            'sts_transaksi' => 'Belum Bayar'
        ]);

        $tiket->kuota_tersedia =
            $tiket->kuota_tersedia -
            $request->jumlah_tiket;

        $tiket->save();

        return redirect()->route(
            'pengunjung.pembelian.sukses',
            $pemesanan->id_pesanan
        );
    }

    public function sukses(int $id)
    {
        $pemesanan = Pemesanan::with([
            'event',
            'tiket',
            'user'
        ])->findOrFail($id);

        return view(
            'pengunjung.pembelian-sukses',
            compact('pemesanan')
        );
    }

    public function tiketSaya()
    {
        $user = Auth::user();

        $pemesanan = Pemesanan::with([
            'event',
            'tiket'
        ])
            ->where(
                'id_pengunjung',
                $user->id_pengunjung
            )
            ->latest('id_pesanan')
            ->get();

        return view(
            'pengunjung.tiket-saya',
            compact('pemesanan')
        );
    }

    public function detailTiket(int $id)
    {
        $pemesanan = Pemesanan::with([
            'event',
            'tiket',
            'pengunjung'
        ])->findOrFail($id);

        return view(
            'pengunjung.detail-tiket',
            compact('pemesanan')
        );
    }
}
