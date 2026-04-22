<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AcaraController extends Controller
{
    /**
     * Menampilkan halaman Tambah Event (Create)
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Memproses penyimpanan data baru (Store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input sesuai mockup
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'required',
            'jenis' => 'required',
            'lokasi' => 'required',
            'kapasitas' => 'required|integer',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // 2. Logika Upload Poster
        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
        }

        // 3. Simpan ke Database (Nanti buka comment ini jika Model sudah siap)
        // Event::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Event baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman Edit Event
     */
    public function edit($id)
    {
        // LOGIKA: Ambil data spesifik berdasarkan ID.
        // Sementara pakai dummy agar tampilan slicing kamu tidak kosong.
        $event = (object)[
            'id' => $id,
            'judul' => 'Festival Musik Kampus 2026',
            'deskripsi' => 'Konser musik tahunan mahasiswa Politeknik Batam dengan bintang tamu rahasia!',
            'tanggal' => '2026-05-30',
            'kategori' => 'Hiburan',
            'jenis' => 'individu',
            'lokasi' => 'Lapangan Bola Politeknik Batam',
            'kapasitas' => 500,
            'poster' => 'musik.png' 
        ];

        return view('admin.edit', compact('event'));
    }

    /**
     * Memproses pembaruan data (Update)
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'required',
            'jenis' => 'required',
            'lokasi' => 'required',
            'kapasitas' => 'required|integer',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // 2. Logika Update Poster (Jika ada file baru)
        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
            // Tambahkan logika hapus file lama di sini jika sudah pakai DB
        }

        // 3. Simpan Perubahan ke Database
        // $event = Event::findOrFail($id);
        // $event->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil diperbarui!');
    }
}