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
<<<<<<< HEAD
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
=======
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
>>>>>>> 6d738c7514dad7274b3aaf49b3390360e03c3b6f
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
