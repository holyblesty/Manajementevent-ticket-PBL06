<?php

namespace App\Http\Controllers\pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function namaFunction(int $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user(); 

        return view('pengunjung.pembelian-tiket', compact('event', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_event' => 'required',
            'id_tiket' => 'required', // Menerima ID tiket (1, 2, atau 3)
            'jumlah_tiket' => 'required|integer|min:1',
            'metode_pembayaran' => 'required',
        ]);

        // Cari tahu harga berdasarkan ID tiket yang dipilih untuk menghitung total
        $harga_satuan = 50000;
        if ($request->id_tiket == '1') $harga_satuan = 30000;  // Early Bird
        if ($request->id_tiket == '3') $harga_satuan = 150000; // VIP

        $biaya_layanan = 5000;
        $total_harga = ($harga_satuan * $request->jumlah_tiket) + $biaya_layanan;

        // Membuat Kode Registrasi Unik Otomatis, misal: REG-84920
        $kode_registrasi = 'REG-' . rand(10000, 99999);

        // Masukkan data ke tabel pemesanan milik admin
        Pemesanan::create([
            'id_event'          => $request->id_event,
            'id_pengunjung'     => Auth::user()->id_pengunjung, // Menggunakan id_pengunjung dari tabel users Anda
            'id_tiket'          => $request->id_tiket,
            'tgl_pesan'         => now()->toDateString(), // Mengisi tanggal hari ini (YYYY-MM-DD)
            'tgl_bayar'         => now()->toDateString(), 
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_harga'       => $total_harga,
            'jumlah_tiket'      => $request->jumlah_tiket,
            'kode_registrasi'   => $kode_registrasi,
            'sts_transaksi'     => 'Sudah Bayar' // Mengisi status transaksi pembeli
        ]);

        // Setelah sukses, lempar ke halaman riwayat pendaftaran
        return redirect()->route('pengunjung.riwayat')->with('success', 'Pembelian tiket berhasil disimpan ke database!');
    }
}