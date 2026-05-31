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
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil ditambah!');
    }

    public function edit($id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        return view('admin.edit', compact('event'));
    }

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

    public function tiket($id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $tikets = DB::table('tikets')->where('id_event', $id_event)->get();
        
        $keyedTiket = [];
        foreach ($tikets as $tiket) {
            $key = strtolower(str_replace(' ', '_', $tiket->nama_tiket)); 
            $keyedTiket[$key] = $tiket;
        }
        
        $event->tiket = $keyedTiket;
        return view('admin.tiket', compact('event'));
    }

    public function updateTiket(Request $request, $id_event) 
    {
        $request->validate([
            'kapasitas' => 'required|integer|min:0',
            'desain_tiket' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tiket' => 'required|array',
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:0',
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();
        $data = ['kapasitas' => $request->kapasitas];
        
        // Memperbaiki masalah desain_tiket yang tidak tersimpan
        if ($request->hasFile('desain_tiket')) {
            if ($event->desain_tiket && $event->desain_tiket !== 'ticket_default.jpg' && File::exists(public_path('images/' . $event->desain_tiket))) {
                File::delete(public_path('images/' . $event->desain_tiket));
            }
            $imageName = 'ticket_' . time() . '.' . $request->desain_tiket->extension();
            $request->desain_tiket->move(public_path('images'), $imageName);
            
            // INI YANG DITAMBAHKAN:
            $data['desain_tiket'] = $imageName;
        }

        $event->update($data);

        foreach ($request->tiket as $tierData) {
            DB::table('tikets')->updateOrInsert(
                ['id_event' => $id_event, 'nama_tiket' => $tierData['nama']],
                [
                    'harga' => $tierData['harga'],
                    'kuota_total' => $tierData['kuota'] ?? 0,
                    'kuota_tersedia' => $tierData['kuota'] ?? 0, 
                ]
            );
        }

        return redirect()->route('admin.dashboard')->with('success', 'Tiket dan desain berhasil diperbarui!');
    }

    public function profile() 
    {
        $admin = Auth::guard('admin')->user(); 
        if (!$admin) {
            abort(403, 'Anda belum login sebagai Admin.');
        }
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request) 
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $admin = Auth::guard('admin')->user();

        if ($request->hasFile('foto')) {
            if ($admin->foto && $admin->foto !== 'profile_default.jpg' && File::exists(public_path('images/' . $admin->foto))) {
                File::delete(public_path('images/' . $admin->foto));
            }

            $imageName = 'profile_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            
            $admin->foto = $imageName;
            session(['admin_foto' => $imageName]);
        }

        $admin->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy($id_event) 
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $event->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil dihapus!');
    }
}