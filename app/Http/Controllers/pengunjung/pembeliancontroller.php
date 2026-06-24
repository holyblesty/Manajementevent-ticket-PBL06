<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class pembeliancontroller extends Controller
{
    // Menampilkan halaman Pembelian Tiket berdasarkan id_event
    public function create(int $id)
    {
        // Mengambil data event beserta relasi tiket yang dimiliki event tersebut
        /** @var \App\Models\Event $event */
        $event = Event::with(['tiket'])->findOrFail($id);
        
        // Mengambil data pengunjung yang sedang login
        $user = Auth::user();

        // Mengarahkan ke file pembeliantiket.blade.php sesuai struktur VS Code Anda
        return view('pengunjung.pembeliantiket', compact('event', 'user'));
    }

    // Memproses data pendaftaran & transaksi pembelian tiket
    public function store(Request $request, int $id)
    {
        $request->validate([
            'id_tiket' => 'required|exists:tiket,id_tiket',
            'jumlah_tiket' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string',
        ]);

        /** @var \App\Models\Event $event */
        $event = Event::findOrFail($id);

        /** @var \App\Models\Tiket $tiket */
        $tiket = Tiket::findOrFail($request->id_tiket);

        // Validasi ketersediaan kuota tiket di database admin sebelum memproses
        if ($tiket->kuota_tersedia < $request->jumlah_tiket) {
            return back()->with('error', 'Maaf, kuota tiket yang Anda pilih tidak mencukupi.');
        }

        // Kalkulasi total harga: (Harga Tiket * Jumlah) + Biaya Layanan Rp 5.000
        $biaya_layanan = 5000;
        $total_harga = ($tiket->harga * $request->jumlah_tiket) + $biaya_layanan;

        // Membuat kode registrasi unik acak untuk tiket pengunjung
        $kode_registrasi = 'REG-' . strtoupper(bin2hex(random_bytes(4)));

        // Menggunakan Database Transaction demi keamanan data relasi tabel
        DB::beginTransaction();
        try {
            // 1. Menyimpan data transaksi ke dalam tabel 'pemesanan'
            $pemesanan = new Pemesanan();
            $pemesanan->id_event = $event->id_event;
            $pemesanan->id_pengunjung = Auth::id(); // Mengambil id_pengunjung dari users (akun login)
            $pemesanan->id_tiket = $tiket->id_tiket;
            $pemesanan->tgl_pesan = now();
            $pemesanan->tgl_bayar = now(); 
            $pemesanan->metode_pembayaran = $request->metode_pembayaran;
            $pemesanan->total_harga = $total_harga;
            $pemesanan->jumlah_tiket = $request->jumlah_tiket;
            $pemesanan->kode_registrasi = $kode_registrasi;
            $pemesanan->sts_transaksi = 'Lunas'; // Langsung otomatis lunas demi simulasi pendaftaran
            $pemesanan->save();

            // 2. Mengurangi kuota tiket yang dibeli pada tabel 'tiket' secara otomatis
            $tiket->kuota_tersedia = $tiket->kuota_tersedia - $request->jumlah_tiket;
            $tiket->save();

            // 3. Mengurangi kuota umum event pada tabel 'events'
            if ($event->kuota_tersedia >= $request->jumlah_tiket) {
                $event->kuota_tersedia = $event->kuota_tersedia - $request->jumlah_tiket;
                $event->save();
            }

            DB::commit();

            // Setelah sukses, diarahkan ke halaman riwayat pendaftaran
            return redirect()->route('pengunjung.riwayat')->with('success', 'Pembelian tiket berhasil! Kode Registrasi Anda: ' . $kode_registrasi);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}