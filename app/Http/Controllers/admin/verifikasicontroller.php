<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Menghadiri;
use Illuminate\Support\Facades\DB;
class VerifikasiController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with([
            'pengunjung',
            'event',
            'tiket'
        ])
        ->where('sts_transaksi', 'Menunggu Verifikasi')
        ->latest('id_pesanan')
        ->get();

      return view(
    'admin.verifikasi',
    compact('pemesanan')
);
    }

    public function acc(int $id)
{
    DB::transaction(function () use ($id) {

        $pemesanan = Pemesanan::with('tiket')->findOrFail($id);

        $tiket = $pemesanan->tiket;

        if ($tiket->kuota_tersedia < $pemesanan->jumlah_tiket) {
            throw new \Exception('Kuota tiket sudah tidak mencukupi.');
        }

        $tiket->decrement(
            'kuota_tersedia',
            $pemesanan->jumlah_tiket
        );

        $pemesanan->update([
            'sts_transaksi' => 'Lunas',
            'tgl_bayar'     => now(),
        ]);
        Menghadiri::create([
    'id_pengunjung'  => $pemesanan->id_pengunjung,
    'id_event'       => $pemesanan->id_event,
    'id_tiket'       => $pemesanan->id_tiket,
    'kode_registrasi'=> $pemesanan->kode_registrasi,
    'sts_checkin'    => 'belum',
]);
    });

    return back()->with(
        'success',
        'Pembayaran berhasil diverifikasi.'
    );
}

    public function tolak(int $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
    
        $pemesanan->update([
            'sts_transaksi' => 'Ditolak'
        ]);

        return back()->with(
            'success',
            'Pembayaran ditolak.'
        );
    }
}