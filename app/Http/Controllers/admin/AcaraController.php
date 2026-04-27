<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AcaraController extends Controller
{
    /**
     * Data Dummy Global dengan dukungan Session
     */
    private function getDummyEvents()
    {
        // Jika sudah ada data di session, pakai yang itu
        if (session()->has('custom_events')) {
            return session('custom_events');
        }

        // Data awal jika session masih kosong (Pastikan semua field LENGKAP)
        $events = [
            1 => [
                'id' => 1,
                'judul' => 'Turnamen Basket Antar Mahasiswa',
                'deskripsi' => 'Pertandingan basket seru antar jurusan di Politeknik Batam.',
                'tanggal' => '2026-05-20',
                'kategori' => 'Olahraga',
                'jenis' => 'tim',
                'lokasi' => 'Lapangan Basket Politeknik Batam',
                'kapasitas' => 50,
                'poster' => 'basket.png',
                'desain_tiket' => null, // Tambahkan field ini agar tidak error
                'tiket' => [
                    'early_bird' => (object)['nama' => 'Early Bird', 'harga' => 50000, 'kuota' => 10],
                    'vip'         => (object)['nama' => 'VIP', 'harga' => 150000, 'kuota' => 10],
                    'normal'      => (object)['nama' => 'Normal', 'harga' => 75000, 'kuota' => 30],
                ]
            ],
            2 => [
                'id' => 2,
                'judul' => 'Festival Musik Kampus 2026',
                'deskripsi' => 'Konser musik tahunan mahasiswa Politeknik Batam.',
                'tanggal' => '2026-05-30',
                'kategori' => 'Hiburan',
                'jenis' => 'individu',
                'lokasi' => 'Lapangan Bola Politeknik Batam',
                'kapasitas' => 500,
                'poster' => 'musik.png',
                'desain_tiket' => null,
                'tiket' => [
                    'early_bird' => (object)['nama' => 'Presale 1', 'harga' => 80000, 'kuota' => 100],
                    'vip'         => (object)['nama' => 'VIP', 'harga' => 350000, 'kuota' => 50],
                    'normal'      => (object)['nama' => 'Festival', 'harga' => 120000, 'kuota' => 350],
                ]
            ],
            3 => [
                'id' => 3,
                'judul' => 'Futsal Kampus Championship',
                'deskripsi' => 'Turnamen futsal bergengsi memperebutkan piala Direktur.',
                'tanggal' => '2026-06-09',
                'kategori' => 'Olahraga',
                'jenis' => 'tim',
                'lokasi' => 'Sport Hall Politeknik Batam',
                'kapasitas' => 32,
                'poster' => 'futsal.jpg',
                'desain_tiket' => null,
                'tiket' => [
                    'early_bird' => (object)['nama' => 'Promo', 'harga' => 25000, 'kuota' => 10],
                    'vip'         => (object)['nama' => 'VIP', 'harga' => 75000, 'kuota' => 2],
                    'normal'      => (object)['nama' => 'Reguler', 'harga' => 35000, 'kuota' => 20],
                ]
            ],
            4 => [
                'id' => 4,
                'judul' => 'Seminar Nasional: Masa Depan AI',
                'deskripsi' => 'Membahas perkembangan teknologi AI di industri masa kini.',
                'tanggal' => '2026-06-15',
                'kategori' => 'Seminar',
                'jenis' => 'individu',
                'lokasi' => 'Auditorium Gd. Utama',
                'kapasitas' => 200,
                'poster' => 'seminar.jpg',
                'desain_tiket' => null,
                'tiket' => [
                    'early_bird' => (object)['nama' => 'Early Bird', 'harga' => 50000, 'kuota' => 50],
                    'vip'         => (object)['nama' => 'VIP', 'harga' => 200000, 'kuota' => 50],
                    'normal'      => (object)['nama' => 'Normal', 'harga' => 100000, 'kuota' => 100],
                ]
            ],
        ];

        session(['custom_events' => $events]);
        return $events;
    }

    // --- PROFILE ---
    public function profile() {
        $user = (object) [
            'name' => session('admin_name', 'Vivian Sarah Diva Alisianoi'),
            'email' => 'vivian_018@student.polibatam.ac.id',
            'foto' => session('admin_foto', 'profile_default.jpg')
        ];
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        session(['admin_name' => $request->name]);
        if ($request->hasFile('foto')) {
            $imageName = 'profile_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            session(['admin_foto' => $imageName]);
        }
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
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

        $allEvents = $this->getDummyEvents();
        $newId = count($allEvents) > 0 ? max(array_keys($allEvents)) + 1 : 1;
        
        $imageName = time() . '.' . $request->poster->extension();
        $request->poster->move(public_path('images'), $imageName);

        $allEvents[$newId] = [
            'id' => $newId,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'lokasi' => $request->lokasi,
            'kapasitas' => 0, 
            'poster' => $imageName,
            'desain_tiket' => null,
            'tiket' => [
                'early_bird' => (object)['nama' => 'Early Bird', 'harga' => 0, 'kuota' => 0],
                'vip' => (object)['nama' => 'VIP', 'harga' => 0, 'kuota' => 0],
                'normal' => (object)['nama' => 'Normal', 'harga' => 0, 'kuota' => 0],
            ]
        ];

        session(['custom_events' => $allEvents]);
        return redirect()->route('admin.dashboard')->with('success', 'Event baru berhasil ditambah!');
    }

    public function edit($id) {
        $allEvents = $this->getDummyEvents();
        $event = (object) ($allEvents[$id] ?? abort(404));
        return view('admin.edit', compact('event'));
    }

    public function tiket($id) {
        $allEvents = $this->getDummyEvents();
        $event = (object) ($allEvents[$id] ?? abort(404));
        return view('admin.tiket', compact('event'));
    }

    public function update(Request $request, $id) {
        $allEvents = $this->getDummyEvents();
        if (isset($allEvents[$id])) {
            $allEvents[$id]['judul'] = $request->judul;
            $allEvents[$id]['deskripsi'] = $request->deskripsi;
            $allEvents[$id]['tanggal'] = $request->tanggal;
            $allEvents[$id]['lokasi'] = $request->lokasi;
            $allEvents[$id]['kategori'] = $request->kategori;
            $allEvents[$id]['jenis'] = $request->jenis;
            
            if ($request->hasFile('poster')) {
                $imageName = time() . '.' . $request->poster->extension();
                $request->poster->move(public_path('images'), $imageName);
                $allEvents[$id]['poster'] = $imageName;
            }
            session(['custom_events' => $allEvents]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Perubahan event disimpan!');
    }

    public function updateTiket(Request $request, $id) {
        $request->validate([
            'kapasitas' => 'required|integer|min:0',
            'tiket' => 'nullable|array',
            'desain_tiket' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $allEvents = $this->getDummyEvents();
        if (isset($allEvents[$id])) {
            $allEvents[$id]['kapasitas'] = $request->kapasitas;
            
            if($request->has('tiket')) {
                foreach($request->tiket as $key => $val) {
                    $allEvents[$id]['tiket'][$key] = (object)$val;
                }
            }

            if ($request->hasFile('desain_tiket')) {
                $imageName = 'ticket_' . time() . '.' . $request->desain_tiket->extension();
                $request->desain_tiket->move(public_path('images'), $imageName);
                $allEvents[$id]['desain_tiket'] = $imageName;
            }
            session(['custom_events' => $allEvents]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Kapasitas dan Tiket berhasil disimpan!');
    }

    public function destroy($id) {
        $allEvents = $this->getDummyEvents();
        if (isset($allEvents[$id])) {
            unset($allEvents[$id]);
            session(['custom_events' => $allEvents]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil dihapus!');
    }
}