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
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal'   => 'required|date',
            'kategori'  => 'required',
            'jenis'     => 'required',
            'lokasi'    => 'required',
            'kapasitas' => 'required|integer',
            'poster'    => 'required|image|mimes:jpeg,png,jpg|max:5120',
            
            'jenis_tiket'       => 'nullable|string', 
            'tiket'             => 'nullable|array',
            'tiket.*.nama'      => 'nullable|string|max:100',
            'tiket.*.harga'     => 'nullable|numeric',
            'tiket.*.kuota'     => 'nullable|integer',
            'tiket.*.deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Event baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman Edit Event
     */
   public function edit($id)
   {
    // DATA DUMMY SINKRON DENGAN DASHBOARDCONTROLLER
    $allEvents = [
        1 => [
            'id' => 1,
            'judul' => 'Turnamen Basket Antar Mahasiswa',
            'deskripsi' => 'Pertandingan basket seru antar jurusan di Politeknik Batam.',
            'tanggal' => '2026-05-20',
            'kategori' => 'Olahraga',
            'jenis' => 'tim',
            'lokasi' => 'Lapangan Basket Politeknik Batam',
            'kapasitas' => 50, // Sesuai Dashboard
            'poster' => 'basket.png',
            'tiket' => [
                'early_bird' => (object)['nama' => 'Early Bird', 'deskripsi' => 'Harga spesial untuk pendaftar pertama', 'harga' => 50000, 'kuota' => 10],
                'vip'        => (object)['nama' => 'VIP', 'deskripsi' => 'Area tribun utama', 'harga' => 100000, 'kuota' => 10],
                'normal'     => (object)['nama' => 'Normal', 'deskripsi' => 'Tiket tribun reguler', 'harga' => 75000, 'kuota' => 30],
            ] // Total = 50
        ],
        2 => [
            'id' => 2,
            'judul' => 'Festival Musik Kampus 2026',
            'deskripsi' => 'Konser musik tahunan mahasiswa Politeknik Batam dengan bintang tamu rahasia!',
            'tanggal' => '2026-05-30',
            'kategori' => 'Hiburan',
            'jenis' => 'individu',
            'lokasi' => 'Lapangan Bola Politeknik Batam',
            'kapasitas' => 500, // Sesuai Dashboard
            'poster' => 'musik.png',
            'tiket' => [
                'early_bird' => (object)['nama' => 'Presale 1', 'deskripsi' => 'Tiket murah meriah', 'harga' => 80000, 'kuota' => 100],
                'vip'        => (object)['nama' => 'VIP Meet & Greet', 'deskripsi' => 'Akses backstage', 'harga' => 350000, 'kuota' => 50],
                'normal'     => (object)['nama' => 'Festival', 'deskripsi' => 'Akses area festival', 'harga' => 120000, 'kuota' => 350],
            ] // Total = 500
        ],
        3 => [
            'id' => 3,
            'judul' => 'Futsal Kampus Championship',
            'deskripsi' => 'Turnamen futsal bergengsi untuk memperebutkan piala Direktur.',
            'tanggal' => '2026-06-09',
            'kategori' => 'Olahraga',
            'jenis' => 'tim',
            'lokasi' => 'Sport Hall Politeknik Batam',
            'kapasitas' => 32, // Sesuai Dashboard
            'poster' => 'futsal.jpg',
            'tiket' => [
                'early_bird' => (object)['nama' => 'Promo Mahasiswa', 'deskripsi' => 'Diskon khusus KTM', 'harga' => 25000, 'kuota' => 10],
                'vip'        => (object)['nama' => 'VIP', 'deskripsi' => 'Kursi pinggir lapangan', 'harga' => 75000, 'kuota' => 2],
                'normal'     => (object)['nama' => 'Reguler', 'deskripsi' => 'Tiket masuk harian', 'harga' => 35000, 'kuota' => 20],
            ] // Total = 32
        ],
        4 => [
            'id' => 4,
            'judul' => 'Seminar Nasional: Masa Depan AI',
            'deskripsi' => 'Membahas perkembangan teknologi AI di industri masa kini.',
            'tanggal' => '2026-06-15',
            'kategori' => 'Seminar',
            'jenis' => 'individu',
            'lokasi' => 'Auditorium Gd. Utama',
            'kapasitas' => 200, // Sesuai Dashboard
            'poster' => 'seminar.jpg',
            'tiket' => [
                'early_bird' => (object)['nama' => 'Early Bird', 'deskripsi' => 'Pendaftaran bulan pertama', 'harga' => 50000, 'kuota' => 50],
                'vip'        => (object)['nama' => 'VIP Bundling', 'deskripsi' => 'Materi VIP + Sertifikat Fisik + Lunch', 'harga' => 200000, 'kuota' => 50],
                'normal'     => (object)['nama' => 'Normal', 'deskripsi' => 'Akses seminar + E-Sertifikat', 'harga' => 100000, 'kuota' => 100],
            ] // Total = 200
        ],
    ];

    $data = isset($allEvents[$id]) ? $allEvents[$id] : $allEvents[1];
    $event = (object) $data;

    return view('admin.edit', compact('event'));
   }

    /**
     * Memproses pembaruan data (Update)
     */
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
            
            'jenis_tiket'       => 'nullable|string', 
            'tiket'             => 'nullable|array',
            'tiket.*.nama'      => 'nullable|string',
            'tiket.*.harga'     => 'nullable|numeric',
        ]);

        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('images'), $imageName);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil diperbarui!');
    }
}