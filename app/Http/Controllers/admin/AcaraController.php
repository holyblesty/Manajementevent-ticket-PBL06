<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AcaraController extends Controller
{
    /**
     * Data Dummy Global
     */
    private function getDummyEvents()
    {
        return [
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
                'desain_tiket' => null,
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
                'deskripsi' => 'Turnamen futsal bergengsi.',
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
                'deskripsi' => 'Membahas perkembangan teknologi AI.',
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
    }

    // --- METHOD UNTUK PROFILE ---
    
    public function profile()
    {
        // Logika Session: Ambil dari session jika ada, kalau tidak pakai default
        $user = (object) [
            'name' => session('admin_name', 'Vivian Sarah Diva Alisianoi'),
            'email' => 'vivian_018@student.polibatam.ac.id',
            'foto' => session('admin_foto', 'profile_default.jpg')
        ];

        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan nama ke Session agar tidak hilang saat refresh
        session(['admin_name' => $request->name]);

        if ($request->hasFile('foto')) {
            $imageName = 'profile_' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            // Simpan nama file foto ke Session
            session(['admin_foto' => $imageName]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // --- METHOD UNTUK EVENT ---

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal'   => 'required|date',
            'kategori'  => 'required',
            'jenis'     => 'required',
            'lokasi'    => 'required',
            'kapasitas' => 'required|integer',
            'poster'    => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Event baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $allEvents = $this->getDummyEvents();
        $data = isset($allEvents[$id]) ? $allEvents[$id] : $allEvents[1];
        $event = (object) $data;

        return view('admin.edit', compact('event'));
    }

    public function tiket($id)
    {
        $allEvents = $this->getDummyEvents();
        $data = isset($allEvents[$id]) ? $allEvents[$id] : $allEvents[1];
        $event = (object) $data;

        return view('admin.tiket', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal'   => 'required|date',
            'kategori'  => 'required',
            'jenis'     => 'required',
            'lokasi'    => 'required',
            'kapasitas' => 'required|integer',
            'poster'    => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Informasi event berhasil diperbarui!');
    }

    public function updateTiket(Request $request, $id)
    {
        $request->validate([
            'kapasitas'    => 'required|integer',
            'tiket'        => 'nullable|array',
            'desain_tiket' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('desain_tiket')) {
            $imageName = 'ticket_' . time() . '.' . $request->desain_tiket->extension();
            $request->desain_tiket->move(public_path('images'), $imageName);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Pengaturan tiket dan desain berhasil disimpan!');
    }
}