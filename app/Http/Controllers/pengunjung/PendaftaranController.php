<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_event'     => 'required',
            'id_tiket'     => 'required',
            'jumlah_tiket' => 'required|integer|min:1'
        ]);

        return DB::transaction(function () use ($request) {
            $tiket = Tiket::where('id_tiket', $request->id_tiket)
                ->lockForUpdate()
                ->firstOrFail();

            if ($tiket->kuota_tersedia < $request->jumlah_tiket) {
                return back()->with('error', 'Kuota tidak mencukupi!');
            }

            // Gunakan Auth::id() jika auth()->id() memicu error Intelephense
            Pemesanan::create([
                'id_event'          => $request->id_event,
                'id_pengunjung'     => Auth::id(),
                'id_tiket'          => $request->id_tiket,
                'tgl_pesan'         => now(),
                'jumlah_tiket'      => $request->jumlah_tiket,
                'total_harga'       => $tiket->harga * $request->jumlah_tiket,
                'kode_registrasi'   => Pemesanan::generateKode(),
                'sts_transaksi'     => 'Menunggu Pembayaran'
            ]);

            $tiket->decrement('kuota_tersedia', $request->jumlah_tiket);

            return redirect()->route('pengunjung.riwayat')
                ->with('success', 'Pesanan berhasil dibuat!');
        });
    }
}
