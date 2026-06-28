<?php

namespace App\Http\Controllers\pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use App\Models\Tiket;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pembeliancontroller extends Controller
{
    public function index(int $id_event)
    {
        $event = Event::findOrFail($id_event);
        $tiket = Tiket::where('id_event', $id_event)->get();
        $pengunjung = auth()->guard('web')->user();

        return view('pengunjung.pembeliantiket', compact('event', 'tiket', 'pengunjung'));
    }

    public function store(Request $request)
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

        try {
            $pemesanan = DB::transaction(function () use ($request) {
                // Mengambil user yang sedang login
                $user = auth()->guard('web')->user();
                // Mengambil objek pengunjung agar method 'update' dikenali
                $pengunjung = Pengunjung::find($user->id_pengunjung);

                $tiket = Tiket::where('id_tiket', $request->id_tiket)
                    ->lockForUpdate()
                    ->findOrFail($request->id_tiket);

                if ($tiket->kuota_tersedia < $request->jumlah_tiket) {
                    throw new \Exception('Kuota tiket tidak mencukupi.');
                }

                // Update data pengunjung
                $pengunjung->update($request->only(['name', 'email', 'no_hp', 'alamat']));

                // Buat pemesanan
                $pesanan = Pemesanan::create([
                    'id_event' => $request->id_event,
                    'id_pengunjung' => $pengunjung->id_pengunjung,
                    'id_tiket' => $request->id_tiket,
                    'total_harga' => $tiket->harga * $request->jumlah_tiket,
                    'jumlah_tiket' => $request->jumlah_tiket,
                    'kode_registrasi' => Pemesanan::generateKode(),
                    'sts_transaksi' => 'Belum Bayar'
                ]);

                $tiket->decrement('kuota_tersedia', $request->jumlah_tiket);

                return $pesanan;
            });
            /** @var \App\Models\Pemesanan $pemesanan */
            return redirect()->route('pengunjung.pembelian.sukses', $pemesanan->id_pesanan);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function sukses(int $id)
    {
        $pemesanan = Pemesanan::with(['event', 'tiket', 'pengunjung'])->findOrFail($id);
        return view('pengunjung.pembelian-sukses', compact('pemesanan'));
    }

    public function tiketSaya()
    {
        $user = auth()->guard('web')->user();
        $pemesanan = Pemesanan::with(['event', 'tiket'])
            ->where('id_pengunjung', $user->id_pengunjung)
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
