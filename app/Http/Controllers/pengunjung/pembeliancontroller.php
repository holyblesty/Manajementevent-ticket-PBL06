<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use App\Models\Pengunjung;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(int $id_event)
    {
        $event = Event::findOrFail($id_event);
        $tiket = Tiket::where('id_event', $id_event)->get();
        $pengunjung = Auth::guard('web')->user();

        return view('pengunjung.pembeliantiket', compact('event', 'tiket', 'pengunjung'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'no_hp'        => 'required',
            'alamat'       => 'required',
            'id_event'     => 'required|exists:events,id_event',
            'id_tiket'     => 'required|exists:tiket,id_tiket',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        try {
            $pemesanan = DB::transaction(function () use ($request) {
                $pengunjung = Pengunjung::findOrFail(Auth::guard('web')->id());
                $tiket = Tiket::lockForUpdate()->findOrFail($request->id_tiket);

                if ($tiket->kuota_tersedia < $request->jumlah_tiket) {
                    throw new \Exception('Kuota tiket tidak mencukupi.');
                }

                // Update profil
                $pengunjung->update([
                    'name'   => $request->name,
                    'email'  => $request->email,
                    'no_hp'  => $request->no_hp,
                    'alamat' => $request->alamat,
                ]);

                // Simpan pemesanan
                $pesanan = Pemesanan::create([
                    'id_event'          => $request->id_event,
                    'id_pengunjung'     => $pengunjung->id_pengunjung,
                    'id_tiket'          => $request->id_tiket,
                    'jumlah_tiket'      => $request->jumlah_tiket,
                    'total_harga'       => $tiket->harga * $request->jumlah_tiket,
                    'kode_registrasi'   => 'EVT' . strtoupper(substr(uniqid(), -8)),
                    'sts_transaksi'     => 'Belum Bayar',
                    'metode_pembayaran' => 'Cash',
                    'tgl_pesan'         => now(),
                ]);

                // Kurangi kuota
                $tiket->decrement('kuota_tersedia', $request->jumlah_tiket);

                return $pesanan;
            });

            return redirect()->route('pengunjung.pembelian.sukses', $pemesanan->id_pesanan);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
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

    // Memproses data pendaftaran & transaksi pembelian tiket

    public function sukses(int $id)
    {
        $pemesanan = Pemesanan::with(['event', 'tiket', 'pengunjung'])->findOrFail($id);
        return view('pengunjung.pembelian-sukses', compact('pemesanan'));
    }

    public function tiketSaya()
    {
        $pengunjung = Auth::guard('web')->user();
        $pemesanan = Pemesanan::with(['event', 'tiket'])
            ->where('id_pengunjung', $pengunjung->id_pengunjung)
            ->latest('id_pesanan')
            ->get();

        return view('pengunjung.tiket-saya', compact('pemesanan'));
    }

    public function detailTiket(int $id)
    {
        $pemesanan = Pemesanan::with(['event', 'tiket', 'pengunjung'])->findOrFail($id);
        return view('pengunjung.detail-tiket', compact('pemesanan'));
    }
}