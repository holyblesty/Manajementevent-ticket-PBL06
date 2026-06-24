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
     * Proses UPDATE TIKET MASSAL.
     */
    public function updateTiket(Request $request, int $id_event)
    {
        $request->validate([
            'tiket' => 'required|array',
            'tiket.*.nama' => 'nullable|string',
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:0',
            'tiket.*.deskripsi' => 'nullable|string',
        ]);

        foreach ($request->tiket as $key => $data) {
            $kuota = intval($data['kuota']);
            $harga = floatval($data['harga']);

            if ($kuota === 0 && $harga > 0) {
                return redirect()->back()
                    ->withErrors(["tiket.{$key}.harga" => "Gagal! Tier {$data['nama']} tidak memiliki kuota (0), maka harga wajib Rp 0."])
                    ->withInput();
            }
        }

        $totalKapasitas = 0;
        foreach ($request->tiket as $key => $data) {
            \App\Models\Tiket::updateOrCreate(
                [
                    'id_event' => $id_event,
                    'jenis_tiket' => $data['nama']
                ],
                [
                    'harga' => $data['harga'],
                    'kuota_total' => $data['kuota'],
                    'kuota_tersedia' => $data['kuota'],
                    'deskripsi_tiket' => $data['deskripsi'] ?? null,
                ]
            );
            $totalKapasitas += $data['kuota'];
        }

        $event = Event::where('id_event', $id_event)->firstOrFail();
        $event->update([
            'kapasitas' => $totalKapasitas,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Pengaturan tiket dan kapasitas berhasil diperbarui!');
    }

    /**
     * Menghapus data Event beserta file posternya (Mengatasi Error Call to undefined method destroy).
     */
    public function destroy(int $id_event)
    {
        // 1. Cari data event berdasarkan id_event
        $event = Event::where('id_event', $id_event)->firstOrFail();

        // 2. Hapus file gambar poster dari folder public/images (biar tidak memenuhi storage)
        if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
            File::delete(public_path('images/' . $event->poster));
        }

        // 3. Hapus terlebih dahulu data tiket yang terikat dengan event ini (menghindari error foreign key constraint)
        \App\Models\Tiket::where('id_event', $id_event)->delete();

        // 4. Hapus data event utama
        $event->delete();

        // 5. Kembalikan ke dashboard dengan pesan sukses
        return redirect()->route('admin.dashboard')
            ->with('success', 'Event beserta data tiketnya berhasil dihapus permanen!');
    }
}
