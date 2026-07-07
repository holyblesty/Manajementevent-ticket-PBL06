<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;

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
        $pemesanan = Pemesanan::findOrFail($id);

        $pemesanan->update([
            'sts_transaksi' => 'Lunas',
            'tgl_bayar' => now()
        ]);

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