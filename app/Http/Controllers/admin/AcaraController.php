<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\KategoriEvent;

class AcaraController extends Controller
{
    public function create()
    {
        $kategoris = KategoriEvent::all();

        return view('admin.tambah', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'id_kategori' => 'required|exists:kategori_events,id_kategori',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'lokasi' => 'required|string',
            'status_event' => 'required|in:draft,open',
        ]);

        $imageName = time() . '.' . $request->poster->extension();
        $request->poster->move(public_path('images'), $imageName);

        Event::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kapasitas' => 0,
            'kuota_tersedia' => 0,
            'lokasi' => $request->lokasi,
            'id_kategori' => $request->id_kategori,
            'status_event' => $request->status_event,
            'poster' => $imageName,
            'id_admin' => Auth::id(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Event berhasil ditambah!');
    }

    public function edit(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $kategoris = KategoriEvent::all();

        return view('admin.edit', compact('event', 'kategoris'));
    }

    public function update(Request $request, int $id_event)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'lokasi' => 'required|string',
            'id_kategori' => 'required|exists:kategori_events,id_kategori',
            'status_event' => 'required|in:draft,open',
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();

        $event->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi' => $request->lokasi,
            'id_kategori' => $request->id_kategori,
            'status_event' => $request->status_event,
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
                File::delete(public_path('images/' . $event->poster));
            }

            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);

            $event->update([
                'poster' => $imageName
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Event berhasil diupdate!');
    }

    /**
     * Menampilkan halaman kelola tiket berdasarkan id_event.
     */
    public function tiket(int $id_event)
    {
        $event = Event::with('tiket')->where('id_event', $id_event)->firstOrFail();
        return view('admin.tiket', compact('event'));
    }

    /**
     * Proses simpan TIKET BARU.
     */
    public function storeTiket(Request $request, int $id_event)
    {
        $request->validate([
            'jenis_tiket' => 'required|string|max:255',
            'kuota_tiket' => 'required|integer|min:0',
            'harga_tiket' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->kuota_tiket == 0 && $value > 0) {
                        $fail('Masa tidak ada kuota tapi diberi harga? Kuota tiket harus diisi lebih dari 0 jika tiket berbayar!');
                    }
                },
            ],
        ]);

        \App\Models\Tiket::create([
            'id_event'    => $id_event,
            'jenis_tiket' => $request->jenis_tiket,
            'harga_tiket' => $request->harga_tiket,
            'kuota_tiket' => $request->kuota_tiket,
        ]);

        // Sinkronisasi total kapasitas ke tabel events
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $totalKapasitas = \App\Models\Tiket::where('id_event', $id_event)->sum('kuota_tiket');
        $event->update([
            'kapasitas' => $totalKapasitas,
            'kuota_tersedia' => $totalKapasitas
        ]);

        return redirect()->route('admin.acara.tiket', $id_event)
            ->with('success', 'Tiket baru berhasil ditambahkan dengan aman!');
    }

    /**
     * Proses UPDATE TIKET SECARA MASSAL (Early Bird, Normal, VIP).
     */
    public function updateTiket(Request $request, int $id_event)
    {
        // 1. Validasi struktur array dasar (jenis_tiket tidak di-required karena readonly)
        $request->validate([
            'tiket' => 'required|array',
            'tiket.*.nama' => 'nullable|string',
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:0',
        ]);

        // 2. Logika Dosen: Kuota 0 Wajib Harga 0. Kuota > 0 Boleh Harga 0 (Free)
        foreach ($request->tiket as $key => $data) {
            $kuota = intval($data['kuota']);
            $harga = floatval($data['harga']);

            if ($kuota === 0 && $harga > 0) {
                return redirect()->back()
                    ->withErrors(["tiket.{$key}.harga" => "Gagal! Tier {$data['nama']} tidak memiliki kuota (0), maka harga wajib Rp 0."])
                    ->withInput();
            }
        }

        // 3. Jika lolos validasi, update ke database menggunakan updateOrCreate
        $totalKapasitas = 0;
        foreach ($request->tiket as $key => $data) {
            \App\Models\Tiket::updateOrCreate(
                [
                    'id_event' => $id_event,
                    'jenis_tiket' => $data['nama']
                ],
                [
                    'harga_tiket' => $data['harga'],
                    'kuota_tiket' => $data['kuota'],
                ]
            );
            $totalKapasitas += $data['kuota'];
        }

        // 4. Sinkronisasi total kapasitas ke tabel 'events'
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $event->update([
            'kapasitas' => $totalKapasitas,
            'kuota_tersedia' => $totalKapasitas
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Pengaturan kapasitas tiket berhasil diperbarui!');
    }

    /**
     * Proses HAPUS TIKET (Menjaga sinkronisasi total kapasitas event).
     */
    public function destroyTiket(int $id_tiket)
    {
        $tiket = \App\Models\Tiket::where('id_tiket', $id_tiket)->firstOrFail();
        $id_event = $tiket->id_event;

        // Hapus data tiket
        $tiket->delete();

        // Hitung ulang total kapasitas event setelah tiket ini dihapus
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $totalKapasitas = \App\Models\Tiket::where('id_event', $id_event)->sum('kuota_tiket') ?? 0;

        $event->update([
            'kapasitas' => $totalKapasitas,
            'kuota_tersedia' => $totalKapasitas
        ]);

        return redirect()->route('admin.acara.tiket', $id_event)
            ->with('success', 'Tiket berhasil dihapus, kapasitas event diperbarui!');
    }
}
