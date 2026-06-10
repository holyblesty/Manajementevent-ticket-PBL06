<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

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
        return view('admin.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'judul'      => 'required',
            'id_kategori' => 'required',
            'poster'      => 'required|image|mimes:jpeg,png,jpg|max:5120'
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
            'kuota_tersedia'=> 0, 
            'status_event'  => 'draft',
            'poster'        => $imageName,
            'id_admin'      => Auth::id()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil ditambah!');
    }

    public function edit(int $id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        return view('admin.edit', compact('event'));
    }

    public function update(Request $request, int $id_event) 
    {
// Kita samakan aturan validasinya dengan method store (create)
    $request->validate([
        'judul'       => 'required',
        'poster'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120' // nullable karena poster boleh tidak diganti
    ], [
        'judul.required'       => 'Judul event wajib diisi.',
        'poster.image'         => 'File harus berupa gambar.',
        'poster.mimes'         => 'Format poster harus jpeg, png, atau jpg.',
        'poster.max'           => 'Ukuran poster tidak boleh lebih dari 5MB.',
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

    public function tiket(int $id_event) 
    {
        $event = Event::with('tiket')->where('id_event', $id_event)->firstOrFail();
        $tiketData = $event->tiket->keyBy('jenis_tiket'); 
        
        return view('admin.tiket', compact('event', 'tiketData'));
    }
public function updateTiket(Request $request, int $id_event)
{
    
    // 1. Cek apakah ada data yang diterima
    if (!$request->has('tiket')) {
        dd("Data tidak terkirim dari form!");
    }

    try {
        $event = Event::where('id_event', $id_event)->firstOrFail();

        foreach ($request->tiket as $data) {
            // Kita gunakan create manual untuk testing apakah query-nya bermasalah
            \App\Models\Tiket::updateOrCreate(
                ['jenis_tiket' => $data['nama'], 'id_event' => $id_event],
                [
                    'harga'          => $data['harga'] ?? 0,
                    'kuota_total'    => $data['kuota'] ?? 0,
                    'kuota_tersedia' => $data['kuota'] ?? 0
                ]
            );
        }

        $event->update(['kapasitas' => $request->kapasitas]);

        return redirect()->route('admin.dashboard')->with('success', 'Tiket berhasil diupdate!');
    } catch (\Exception $e) {
        // Tampilkan error database apa pun yang terjadi
        dd($e->getMessage()); 
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