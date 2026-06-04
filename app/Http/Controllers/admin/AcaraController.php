<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Event;

class AcaraController extends Controller
{
    /**
     * Menampilkan daftar semua event.
     */
    public function index()
    {
        $events = Event::all();
        $selectedCategory = request('kategori', ''); 
        return view('admin.dashboard', compact('events', 'selectedCategory'));
    }

    /**
     * Menampilkan form untuk membuat event baru.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Menyimpan event baru ke database.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'judul' => 'required', 
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $imageName = time() . '.' . $request->poster->extension();
        $request->poster->move(public_path('images'), $imageName);

        Event::create([
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'tanggal'       => $request->tanggal,
            'waktu_acara'   => $request->waktu_acara ?? '00:00:00',
            'lokasi'        => $request->lokasi,
            'kategori'      => $request->kategori,
            'kapasitas'     => 0, 
            'kuota_tersedia'=> 0, 
            'status_event'  => 'draft',
            'poster'        => $imageName,
            'id_admin'      => Auth::id()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil ditambah!');
    }

    /**
     * Menampilkan form edit event.
     */
    public function edit($id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        return view('admin.edit', compact('event'));
    }

    /**
     * Mengupdate data event.
     */
    public function update(Request $request, $id_event) 
    {
        $request->validate([
            'judul' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();
        $data = $request->except(['poster']);

        if ($request->hasFile('poster')) {
            if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
                File::delete(public_path('images/' . $event->poster));
            }
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
            $data['poster'] = $imageName;
        }

        $event->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Data acara berhasil diupdate!');
    }

    /**
     * Menampilkan halaman pengaturan tiket untuk event.
     */
    public function tiket($id_event) 
    {
        $event = Event::with('tiket')->where('id_event', $id_event)->firstOrFail();
        
        // Memproses koleksi tiket menjadi array asosiatif berdasarkan nama_tiket 
        // agar mudah diakses di view sebagai $tiketData['Early Bird']->harga
        $tiketData = $event->tiket->keyBy('nama_tiket'); 
        
        return view('admin.tiket', compact('event', 'tiketData'));
    }

    /**
 * Menghapus event.
 */
public function destroy($id_event)
{
    $event = Event::where('id_event', $id_event)->firstOrFail();

    // Hapus semua tiket yang terkait dengan event
    $event->tiket()->delete();

    // Hapus file poster jika ada
    if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
        File::delete(public_path('images/' . $event->poster));
    }

    // Hapus event
    $event->delete();

    return redirect()->route('admin.dashboard')
        ->with('success', 'Event berhasil dihapus!');
}

public function updateTiket(Request $request, $id_event)
{
    try {

        $event = Event::where('id_event', $id_event)->firstOrFail();

        if ($request->has('tiket')) {

            foreach ($request->tiket as $data) {

                $event->tiket()->updateOrCreate(
                    [
                        'nama_tiket' => $data['nama']
                    ],
                    [
                        'harga' => $data['harga'],
                        'kuota_total' => $data['kuota'],
                        'kuota_tersedia' => $data['kuota']
                    ]
                );
            }
        }

        $event->update([
            'kapasitas' => $request->kapasitas
        ]);

       return redirect()->route('admin.dashboard')
    ->with('success', 'Tiket berhasil diupdate!');
    } catch (\Exception $e) {

        return redirect()->back()->with(
            'error',
            $e->getMessage()
        );
    }
}
}