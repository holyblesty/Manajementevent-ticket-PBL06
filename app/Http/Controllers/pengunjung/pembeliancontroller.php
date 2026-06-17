<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
>>>>>>> 1f4122ef3935aa3335b294cf6c8a5a43b2316de8

class PembelianController extends Controller
{
<<<<<<< HEAD
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
=======
    // Menampilkan halaman Pembelian Tiket berdasarkan id_event
    public function create($id)
    {
        // Mengambil data event beserta relasi tiket yang dimiliki event tersebut
        $event = Event::with(['tiket'])->findOrFail($id);
        
        // Mengambil data pengunjung yang sedang login
        $user = Auth::user();

        // Mengarahkan ke file pembeliantiket.blade.php sesuai struktur VS Code Anda
        return view('pengunjung.pembeliantiket', compact('event', 'user'));
    }

    // Memproses data pendaftaran & transaksi pembelian tiket
    public function store(Request $request, $id)
    {
        $request->validate([
            'id_tiket' => 'required|exists:tiket,id_tiket',
            'jumlah_tiket' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string',
        ]);
        $event = Event::findOrFail($id);
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
>>>>>>> 1f4122ef3935aa3335b294cf6c8a5a43b2316de8
    }
}