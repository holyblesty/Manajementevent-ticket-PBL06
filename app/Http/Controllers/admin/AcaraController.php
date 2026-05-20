<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Event; // PASTIKAN MODEL EVENT SUDAH DI-IMPORT DI SINI

class AcaraController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Admin beserta Daftar Event dari Database
     */
    public function index()
    {
        // Ambil data asli dari tabel database lewat Model Event
        $events = Event::all();

        // Lempar data ke view dashboard admin
        return view('admin.dashboard', [
            'events' => $events, 
            'selectedCategory' => ''
        ]);
    }

    // --- PROFILE ---
    public function profile() {
        $user = (object) [
            'name'  => session('admin_name', 'Vivian Sarah Diva Alisianoi'),
            'email' => 'vivian_018@student.polibatam.ac.id',
            'foto'  => session('admin_foto', 'profile_default.jpg')
        ];
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        session(['admin_name' => $request->name]);

        if ($request->hasFile('foto')) {
            $oldFoto = session('admin_foto');
            if ($oldFoto && $oldFoto !== 'profile_default.jpg') {
                $oldPath = public_path('images/' . $oldFoto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $imageName = 'profile_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            
            session(['admin_foto' => $imageName]);
        }

        session()->save();

        return redirect()->back()->with('success', 'Profil kamu berhasil diperbarui!');
    }

    // --- EVENT ---
    public function create() {
        return view('admin.create');
    }

    public function store(Request $request) {
        $request->validate([
            'judul' => 'required', 
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $imageName = time() . '.' . $request->poster->extension();
        $request->poster->move(public_path('images'), $imageName);

        // Simpan langsung ke database menggunakan Eloquent
        Event::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'lokasi' => $request->lokasi,
            'kapasitas' => 0, 
            'poster' => $imageName,
            'desain_tiket' => null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Event baru berhasil ditambah!');
    }

    public function edit($id_event) {
        // Cari data di database berdasarkan id_event, jika tidak ada langsung munculkan 404
        $event = Event::where('id_event', $id_event)->firstOrFail();
        return view('admin.edit', compact('event'));
    }

    public function tiket($id_event) {
        // Cari data acara di database untuk halaman manajemen tiket
        $event = Event::where('id_event', $id_event)->firstOrFail();
        return view('admin.tiket', compact('event'));
    }

    public function update(Request $request, $id_event) {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        
        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
        ];
        
        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
            $data['poster'] = $imageName;
        }

        $event->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Perubahan event disimpan!');
    }

    public function updateTiket(Request $request, $id_event) {
        $request->validate([
            'kapasitas' => 'required|integer|min:0',
            'desain_tiket' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();
        
        $data = [
            'kapasitas' => $request->kapasitas
        ];

        if ($request->hasFile('desain_tiket')) {
            $imageName = 'ticket_' . time() . '.' . $request->desain_tiket->extension();
            $request->desain_tiket->move(public_path('images'), $imageName);
            $data['desain_tiket'] = $imageName;
        }

        $event->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Kapasitas dan Tiket berhasil disimpan!');
    }

    public function destroy($id_event) {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $event->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil dihapus!');
    }
}