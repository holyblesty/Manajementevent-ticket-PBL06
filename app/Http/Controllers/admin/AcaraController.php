<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Models\KategoriEvent;
use App\Models\Tiket;
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
     * Menampilkan daftar event.
     */
    public function index(Request $request)
    {
        $query = Event::with('kategori');

        if ($request->filled('status')) {

            if ($request->status == 'draft') {

                $query->where('status_event', 'draft');
            } elseif ($request->status == 'open') {

                $query->where('status_event', 'open')
                    ->whereDate('tgl_selesai', '>=', now());
            } elseif ($request->status == 'closed') {

                $query->where('status_event', 'open')
                    ->whereDate('tgl_selesai', '<', now());
            }
        }

        $events = $query
            ->paginate(5)
            ->withQueryString();

        return view('admin.dashboard', compact('events'));
    }

    /**
     * Form tambah event.
     */
    public function create()
    {
        $kategoris = KategoriEvent::all();

        return view('admin.tambah', compact('kategoris'));
    }

    /**
     * Simpan event baru.
     */
    public function store(StoreEventRequest $request)
    {
        try {

            if (!$request->hasFile('poster')) {
                throw new \Exception('File poster tidak ditemukan.');
            }

            $image = $request->file('poster');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);

            $data = $request->validated();

            $data['poster'] = $imageName;
            $data['id_admin'] = Auth::id();
            $data['kapasitas'] = 0;
            $data['kuota_tersedia'] = 0;
            $data['status_event'] = 'open';

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
     * Form edit event.
     */
    public function edit(int $id_event)
    {
        $event = Event::findOrFail($id_event);
        $kategoris = KategoriEvent::all();

        return view('admin.edit', compact('event', 'kategoris'));
    }

    /**
     * Update event.
     */
    public function update(Request $request, int $id_event)
    {
        $event = Event::findOrFail($id_event);

        $request->validate([
            'judul'  => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        DB::transaction(function () use ($request, $event) {

            $data = $request->only([
                'judul',
                'deskripsi',
                'tgl_mulai',
                'tgl_selesai',
                'jam_mulai',
                'jam_selesai',
                'lokasi',
                'id_kategori',
                'status_event',
            ]);

            if ($request->hasFile('poster')) {

                if (
                    $event->poster &&
                    File::exists(public_path('images/' . $event->poster))
                ) {
                    File::delete(public_path('images/' . $event->poster));
                }

                $imageName = time() . '_' . $request->poster->hashName();

                $request->poster->move(
                    public_path('images'),
                    $imageName
                );

                $data['poster'] = $imageName;
            }

            $event->update($data);
        });

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Hapus event.
     */
    public function destroy(int $id_event)
    {
        $event = Event::findOrFail($id_event);

        if (
            $event->poster &&
            File::exists(public_path('images/' . $event->poster))
        ) {
            File::delete(public_path('images/' . $event->poster));
        }

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
     * Halaman tiket.
     */
    public function tiket(int $id_event)
    {
        $event = Event::with('tiket')->findOrFail($id_event);

        return view('admin.tiket', compact('event'));
    }

    /**
     * Update tiket.
     */
    public function updateTiket(Request $request, int $id_event)
    {
        $request->validate([
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:0',
        ]);

        foreach ($request->tiket as $data) {

            Tiket::updateOrCreate(
                [
                    'id_event'     => $id_event,
                    'jenis_tiket'  => $data['nama'],
                ],
                [
                    'harga'         => $data['harga'],
                    'kuota_total'   => $data['kuota'],
                ]
            );
        }

        Event::where('id_event', $id_event)->update([
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data tiket berhasil diperbarui.');
    }
}
