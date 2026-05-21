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
     * Menampilkan Dashboard Utama
     */
    public function index()
    {
        $events = Event::all();
        return view('admin.dashboard', compact('events'));
    }

    /**
     * Menampilkan halaman manajemen tiket
     */
    public function tiket($id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        
        // Mengambil data dari tabel tikets langsung secara aman
        $tikets = DB::table('tikets')->where('id_event', $id_event)->get();
        
        // Memformat data menjadi array sesuai dengan struktur pemanggilan desain Blade kamu: $event->tiket[$key]
        $keyedTiket = [];
        foreach ($tikets as $tiket) {
            // SINKRONISASI DATABASE: Menggunakan $tiket->nama_tiket sesuai struktur tabel kamu
            $key = strtolower(str_replace(' ', '_', $tiket->nama_tiket)); 
            $keyedTiket[$key] = $tiket;
        }
        
        // Menyuntikkan array data ke dalam objek event secara dinamis
        $event->tiket = $keyedTiket;
        
        return view('admin.tiket', compact('event'));
    }

    /**
     * Menampilkan Profil Admin yang sedang login
     */
    public function profile() 
    {
        $admin = Auth::guard('admin')->user(); 
        return view('admin.profile', compact('admin'));
    }

    /**
     * Update Profil Admin
     */
    public function updateProfile(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->name = $request->name;

        if ($request->hasFile('foto')) {
            if ($admin->foto && $admin->foto !== 'profile_default.jpg') {
                $oldPath = public_path('images/' . $admin->foto);
                if (File::exists($oldPath)) File::delete($oldPath);
            }

            $imageName = 'profile_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            $admin->foto = $imageName;
        }

        $admin->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Store Event Baru
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

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil ditambah!');
    }

    /**
     * Update Data Kapasitas, Desain Tiket, & 3 Tier Tiket
     */
    public function updateTiket(Request $request, $id_event) 
    {
        $request->validate([
            'kapasitas' => 'required|integer|min:0',
            'desain_tiket' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();
        $data = ['kapasitas' => $request->kapasitas];
        
        if ($request->hasFile('desain_tiket')) {
            if ($event->desain_tiket && File::exists(public_path('images/' . $event->desain_tiket))) {
                File::delete(public_path('images/' . $event->desain_tiket));
            }
            
            $imageName = 'ticket_' . time() . '.' . $request->desain_tiket->extension();
            $request->desain_tiket->move(public_path('images'), $imageName);
            $data['desain_tiket'] = $imageName;
        }

        // 1. Update data utama event (Kapasitas total & Desain Tiket)
        $event->update($data);

        // 2. Logika Menyimpan/Mengupdate rincian 3 Tier Tiket ke tabel 'tikets'
        if ($request->has('tiket')) {
            foreach ($request->tiket as $key => $tierData) {
                DB::table('tikets')->updateOrInsert(
                    ['id_event' => $id_event, 'nama_tiket' => $tierData['nama']],
                    [
                        'harga' => $tierData['harga'] ?? 0,
                        'kuota_total' => $tierData['kuota'] ?? 0,
                        'kuota_tersedia' => $tierData['kuota'] ?? 0, 
                    ]
                );
            }
        }

        // ALTERNATIF AMAN: Redirect langsung ke Dashboard Admin utama agar tidak terlempar ke welcome page
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Kapasitas & Rincian Tiket berhasil diperbarui!');
    }

    /**
     * Hapus Event
     */
    public function destroy($id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        
        if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
            File::delete(public_path('images/' . $event->poster));
        }
        if ($event->desain_tiket && File::exists(public_path('images/' . $event->desain_tiket))) {
            File::delete(public_path('images/' . $event->desain_tiket));
        }

        $event->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil dihapus!');
    }
}