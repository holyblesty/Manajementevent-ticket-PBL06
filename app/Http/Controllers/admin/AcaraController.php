<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\KategoriEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AcaraController extends Controller
{
    /* ==========================================================
     * EVENT CRUD
     * ==========================================================
     */

    /**
     * Menampilkan daftar event di dashboard admin
     * Bisa difilter berdasarkan status: draft, open, closed
     */
    public function index(Request $request)
    {
        $query = Event::with('kategori');

        // Filter status event jika ada request
        if ($request->filled('status')) {

            // Draft event (belum dipublikasi / masih konsep)
            if ($request->status == 'draft') {
                $query->where('status_event', 'draft');
            }

            // Event yang masih berjalan (belum melewati tanggal selesai)
            elseif ($request->status == 'open') {
                $query->where('status_event', 'open')
                    ->whereDate('tgl_selesai', '>=', now());
            }

            // Event yang sudah berakhir
            elseif ($request->status == 'closed') {
                $query->where('status_event', 'open')
                    ->whereDate('tgl_selesai', '<', now());
            }
        }

        // Pagination untuk daftar event
        $events = $query->paginate(5)->withQueryString();

        return view('admin.dashboard', compact('events'));
    }

    /**
     * Menampilkan form tambah event
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $kategoris = KategoriEvent::all();

        return view('admin.tambah', compact('kategoris'));
    }

    /**
     * Menyimpan event baru ke database
     */
    public function store(StoreEventRequest $request)
    {
        try {
            // Validasi file poster wajib ada
            if (!$request->hasFile('poster')) {
                throw new \Exception('File poster tidak ditemukan.');
            }

            // Upload gambar poster
            $image = $request->file('poster');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);

            // Ambil data hasil validasi form request
            $data = $request->validated();

            // Tambahkan data tambahan sistem
            $data['poster'] = $imageName;
            $data['id_admin'] = Auth::id();
            $data['kapasitas'] = 0;
            $data['kuota_tersedia'] = 0;
            $data['status_event'] = 'open';

            // Simpan event
            Event::create($data);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Event berhasil dibuat.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit event berdasarkan ID
     */
    public function edit(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $kategoris = KategoriEvent::all();

        return view('admin.edit', compact('event', 'kategoris'));
    }

    /**
     * Update data event (termasuk poster jika diganti)
     */
    public function update(Request $request, int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();

        // Validasi input dasar
        $request->validate([
            'judul'  => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        DB::transaction(function () use ($request, $event) {

            // Ambil semua data kecuali poster
            $data = $request->except('poster');

            // Jika ada poster baru diupload
            if ($request->hasFile('poster')) {

                // Hapus poster lama jika ada
                if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
                    File::delete(public_path('images/' . $event->poster));
                }

                // Upload poster baru
                $imageName = time() . '_' . $request->poster->hashName();
                $request->poster->move(public_path('images'), $imageName);

                $data['poster'] = $imageName;
            }

            // Update data event
            $event->update($data);
        });

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Menghapus event beserta file poster
     */
    public function destroy(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();

        // Hapus file poster jika ada
        if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
            File::delete(public_path('images/' . $event->poster));
        }

        // Hapus data event
        $event->delete();

        return redirect()
            ->route('admin.acara.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    /* ==========================================================
     * MANAJEMEN TIKET
     * ==========================================================
     */

    /**
     * Menampilkan halaman pengaturan tiket per event
     */
    public function tiket(int $id_event)
    {
        $event = Event::with('tiket')->findOrFail($id_event);

        return view('admin.tiket', compact('event'));
    }

    /**
     * Menambah atau update tiket untuk event
     */
    public function updateTiket(Request $request, int $id_event)
    {
        // Validasi data tiket
        $request->validate([
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:0',
        ]);

        // Simpan/update tiap jenis tiket
        foreach ($request->tiket as $data) {

            Tiket::updateOrCreate(
                [
                    'id_event' => $id_event,
                    'jenis_tiket' => $data['nama'],
                ],
                [
                    'harga' => $data['harga'],
                    'kuota_total' => $data['kuota'],
                ]
            );
        }

        // Update kapasitas event
        Event::where('id_event', $id_event)->update([
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data tiket berhasil diperbarui.');
    }
}
