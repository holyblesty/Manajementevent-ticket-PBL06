<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\KategoriEvent; // Import model yang benar
use App\Models\Tiket;

class AcaraController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $selectedCategory = request('kategori', '');
        return view('admin.dashboard', compact('events', 'selectedCategory'));
    }

    public function create()
    {
        $kategoris = KategoriEvent::all(); // Ambil data kategori untuk dropdown
        return view('admin.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_events,id_kategori',
            'poster'      => 'required|image|mimes:jpeg,png,jpg|max:5120|dimensions:min_width=1200,min_height=400'

        ]);

        $imageName = time() . '.' . $request->poster->extension();
        $request->poster->move(public_path('images'), $imageName);

        Event::create([
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'tanggal'       => $request->tanggal,
            'waktu_acara'   => $request->waktu_acara ?? '00:00:00',
            'lokasi'        => $request->lokasi,
            'id_kategori'   => $request->id_kategori,
            'kapasitas'     => 0,
            'kuota_tersedia' => 0,
            'status_event'  => $request->status_event,
            'poster'        => $imageName,
            'id_admin'      => Auth::id()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil ditambah!');
    }

    public function edit(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $kategoris = KategoriEvent::all(); // Kirim data kategori ke view
        return view('admin.edit', compact('event', 'kategoris'));
    }

    public function update(Request $request, int $id_event)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'required|string',
            'id_kategori'  => 'required|exists:kategori_events,id_kategori',
            'status_event' => 'required|in:draft,open', // Sesuaikan dengan opsi di form Anda
            'poster'       => 'nullable|image|mimes:jpeg,png,jpg|max:5120|dimensions:min_width=1200,min_height=400',
            'lokasi'       => 'required|string|max:255',
            'tanggal'      => 'nullable|date',
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();

        // Update field dasar
        $event->judul        = $request->judul;
        $event->deskripsi    = $request->deskripsi;
        $event->id_kategori  = $request->id_kategori;
        $event->status_event = $request->status_event;
        $event->lokasi       = $request->lokasi;

        // UPDATE TANGGAL HANYA JIKA DIISI (Mencegah tanggal jadi kosong/terhapus)
        if ($request->filled('tanggal')) {
            $event->tanggal = $request->tanggal;
        }

        // Handle poster
        if ($request->hasFile('poster')) {
            if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
                File::delete(public_path('images/' . $event->poster));
            }
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
            $event->poster = $imageName;
        }

        $event->save();

        return redirect()->route('admin.dashboard')->with('success', 'Data acara berhasil diupdate!');
    }
    public function tiket(int $id_event)
    {
        $event = Event::with('tiket')->where('id_event', $id_event)->firstOrFail();
        $tiketData = $event->tiket->keyBy('jenis_tiket');
        return view('admin.tiket', compact('event', 'tiketData'));
    }

    public function updateTiket(Request $request, int $id_event)
    {
        if (!$request->has('tiket')) {
            return back()->withErrors(['msg' => 'Data tiket tidak lengkap!']);
        }

        try {
            $totalKuotaBaru = 0;

            foreach ($request->tiket as $data) {
                Tiket::updateOrCreate(
                    ['jenis_tiket' => $data['nama'], 'id_event' => $id_event],
                    [
                        'harga'          => $data['harga'] ?? 0,
                        'kuota_total'    => $data['kuota'] ?? 0,
                        'kuota_tersedia' => $data['kuota'] ?? 0
                    ]
                );

                $totalKuotaBaru += (int)($data['kuota'] ?? 0);
            }

            Event::where('id_event', $id_event)->update(['kapasitas' => $totalKuotaBaru]);

            return redirect()->route('admin.dashboard')->with('success', 'Tiket dan kapasitas berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengupdate tiket: ' . $e->getMessage()]);
        }
    }
    public function destroy(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $event->tiket()->delete();

        if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
            File::delete(public_path('images/' . $event->poster));
        }

        $event->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil dihapus!');
    }
}
