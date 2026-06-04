<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TiketController extends Controller
{
    // ============================================================
    // HALAMAN PEMBELIAN TIKET (sesuai mockup)
    // ============================================================
    public function pembelian(Event $event)
    {
        $event->load('tikets');
        $user = Auth::user();

        // Ambil tiket pertama yang tersedia sebagai default
        $defaultTiket = $event->tikets->where('jenis_tiket', 'VIP')->first()
            ?? $event->tikets->first();

        return view('pengunjung.pembelian-tiket', compact('event', 'user', 'defaultTiket'));
    }

    // ============================================================
    // PROSES BELI TIKET
    // ============================================================
    public function store(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'id_tiket'          => 'required|exists:tikets,id_tiket',
            'jumlah_tiket'      => 'required|integer|min:1|max:10',
            'metode_pembayaran' => 'required|in:Transfer Bank,Virtual Account,E-Wallet',
            'bank_pilihan'      => 'nullable|string|max:50',
        ], [
            'id_tiket.required'          => 'Pilih jenis tiket terlebih dahulu.',
            'jumlah_tiket.required'      => 'Jumlah tiket wajib diisi.',
            'jumlah_tiket.min'           => 'Minimal 1 tiket.',
            'jumlah_tiket.max'           => 'Maksimal 10 tiket per transaksi.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $tiket = Tiket::findOrFail($request->id_tiket);

        // Cek stok
        if ($tiket->sisa < $request->jumlah_tiket) {
            return back()
                ->withInput()
                ->with('error', 'Stok tiket tidak mencukupi! Sisa: ' . $tiket->sisa . ' tiket.');
        }

        DB::beginTransaction();
        try {
            $totalHarga   = $tiket->harga * $request->jumlah_tiket;
            $biayaLayanan = 5000;
            $grandTotal   = $totalHarga + $biayaLayanan;

            $pesanan = Pesanan::create([
                'kode_pesanan'      => Pesanan::generateKode(),
                'user_id'           => Auth::id(),
                'id_event'          => $event->id_event,
                'id_tiket'          => $tiket->id_tiket,
                'jumlah_tiket'      => $request->jumlah_tiket,
                'total_harga'       => $totalHarga,
                'biaya_layanan'     => $biayaLayanan,
                'grand_total'       => $grandTotal,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bank_pilihan'      => $request->bank_pilihan,
                'status'            => 'pending',
            ]);

            // Kurangi stok tiket
            $tiket->increment('terjual', $request->jumlah_tiket);

            DB::commit();

            return redirect()
                ->route('pengunjung.pesanan.sukses', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem, silakan coba lagi.');
        }
    }

    // ============================================================
    // HALAMAN SUKSES
    // ============================================================
    public function sukses(Pesanan $pesanan)
    {
        // Pastikan hanya pemilik pesanan yang bisa lihat
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $pesanan->load(['event', 'tiket']);
        return view('pengunjung.pesanan-sukses', compact('pesanan'));
    }

    // ============================================================
    // RIWAYAT PENDAFTARAN
    // ============================================================
    public function riwayat()
    {
        $pesanans = Pesanan::with(['event', 'tiket'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pengunjung.riwayat', compact('pesanans'));
    }

    // ============================================================
    // TIKET SAYA (yang sudah confirmed)
    // ============================================================
    public function tiketSaya()
    {
        $pesanans = Pesanan::with(['event', 'tiket'])
            ->where('user_id', Auth::id())
            ->where('status', 'confirmed')
            ->latest()
            ->paginate(10);

        return view('pengunjung.tiket-saya', compact('pesanans'));
    }

    // ============================================================
    // EDIT PESANAN (hanya jika masih pending)
    // ============================================================
    public function edit(Pesanan $pesanan)
    {
        // Hanya pemilik yang bisa edit
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Hanya bisa edit kalau masih pending
        if ($pesanan->status !== 'pending') {
            return redirect()
                ->route('pengunjung.riwayat')
                ->with('error', 'Pesanan yang sudah diproses tidak dapat diedit.');
        }

        $pesanan->load(['event.tikets', 'tiket']);
        $event = $pesanan->event;
        $user  = Auth::user();

        return view('pengunjung.edit-pesanan', compact('pesanan', 'event', 'user'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($pesanan->status !== 'pending') {
            return redirect()
                ->route('pengunjung.riwayat')
                ->with('error', 'Pesanan yang sudah diproses tidak dapat diedit.');
        }

        $validator = Validator::make($request->all(), [
            'id_tiket'          => 'required|exists:tikets,id_tiket',
            'jumlah_tiket'      => 'required|integer|min:1|max:10',
            'metode_pembayaran' => 'required|in:Transfer Bank,Virtual Account,E-Wallet',
            'bank_pilihan'      => 'nullable|string|max:50',
        ], [
            'id_tiket.required'          => 'Pilih jenis tiket.',
            'jumlah_tiket.required'      => 'Jumlah tiket wajib diisi.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $tiketBaru = Tiket::findOrFail($request->id_tiket);
        $tiketLama = $pesanan->tiket;

        DB::beginTransaction();
        try {
            // Kembalikan stok tiket lama
            $tiketLama->decrement('terjual', $pesanan->jumlah_tiket);

            // Cek stok tiket baru
            $tiketBaru->refresh();
            if ($tiketBaru->sisa < $request->jumlah_tiket) {
                DB::rollBack();
                return back()
                    ->withInput()
                    ->with('error', 'Stok tiket tidak mencukupi! Sisa: ' . $tiketBaru->sisa . ' tiket.');
            }

            $totalHarga   = $tiketBaru->harga * $request->jumlah_tiket;
            $biayaLayanan = 5000;
            $grandTotal   = $totalHarga + $biayaLayanan;

            $pesanan->update([
                'id_tiket'          => $tiketBaru->id_tiket,
                'jumlah_tiket'      => $request->jumlah_tiket,
                'total_harga'       => $totalHarga,
                'biaya_layanan'     => $biayaLayanan,
                'grand_total'       => $grandTotal,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bank_pilihan'      => $request->bank_pilihan,
            ]);

            // Kurangi stok tiket baru
            $tiketBaru->increment('terjual', $request->jumlah_tiket);

            DB::commit();

            return redirect()
                ->route('pengunjung.riwayat')
                ->with('success', 'Pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem, silakan coba lagi.');
        }
    }

    // ============================================================
    // HAPUS / BATALKAN PESANAN (hanya jika masih pending)
    // ============================================================
    public function cancel(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($pesanan->status !== 'pending') {
            return back()->with('error', 'Pesanan yang sudah diproses tidak dapat dibatalkan.');
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok tiket
            $pesanan->tiket->decrement('terjual', $pesanan->jumlah_tiket);

            $pesanan->update(['status' => 'cancelled']);

            DB::commit();

            return redirect()
                ->route('pengunjung.riwayat')
                ->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    // ============================================================
    // HAPUS PERMANEN (hanya pesanan cancelled)
    // ============================================================
    public function destroy(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($pesanan->status === 'confirmed') {
            return back()->with('error', 'Pesanan yang sudah dikonfirmasi tidak dapat dihapus.');
        }

        $pesanan->delete();

        return redirect()
            ->route('pengunjung.riwayat')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}