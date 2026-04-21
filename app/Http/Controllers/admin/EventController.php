<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    // Dummy data untuk simulasi (nanti diganti dengan Model/DB)
    private function getDummyAcara()
    {
        return [
            [
                'id'       => 1,
                'poster'   => 'https://placehold.co/60x40/6d28d9/ffffff?text=Event',
                'judul'    => 'Turnamen Basket Antar Mahasiswa',
                'tanggal'  => '20-05-2026',
                'lokasi'   => 'Lapangan Basket Politeknik Batam',
                'kategori' => 'Olahraga',
            ],
            [
                'id'       => 2,
                'poster'   => 'https://placehold.co/60x40/6d28d9/ffffff?text=Event',
                'judul'    => 'Turnamen Futsal Antar Mahasiswa',
                'tanggal'  => '28-05-2026',
                'lokasi'   => 'Lantai 2, Gedung Utama',
                'kategori' => 'Seminar',
            ],
            [
                'id'       => 3,
                'poster'   => 'https://placehold.co/60x40/6d28d9/ffffff?text=Event',
                'judul'    => 'Peran AI dalam Transformasi Digital',
                'tanggal'  => '28-05-2026',
                'lokasi'   => 'Halaman depan techno',
                'kategori' => 'Hiburan',
            ],
            [
                'id'       => 4,
                'poster'   => 'https://placehold.co/60x40/6d28d9/ffffff?text=Event',
                'judul'    => 'Festival Musik Kampus 2026',
                'tanggal'  => '30-05-2026',
                'lokasi'   => 'Lapangan Bola Politeknik Batam',
                'kategori' => 'Olahraga',
            ],
        ];
    }

    /**
     * Tampilkan daftar acara (index)
     */
    public function index(Request $request)
    {
        $acaraList  = $this->getDummyAcara();
        $kategoris  = ['Semua Kategori', 'Olahraga', 'Seminar', 'Hiburan'];
        $search     = $request->get('search', '');
        $kategori   = $request->get('kategori', 'Semua Kategori');

        return view('admin.kelola_acara.index', compact('acaraList', 'kategoris', 'search', 'kategori'));
    }

    /**
     * Tampilkan form tambah acara
     */
    public function create()
    {
        $kategoris = ['Teknologi', 'Olahraga', 'Seminar', 'Hiburan', 'Seni'];
        return view('admin.kelola_acara.create', compact('kategoris'));
    }

    /**
     * Simpan acara baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal'   => 'required|date',
            'kategori'  => 'required|string',
            'jenis'     => 'required|in:tim,individu',
            'lokasi'    => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'poster'    => 'nullable|image|mimes:jpg,png|max:5120',
        ]);

        // TODO: Simpan ke database menggunakan Model Acara
        // Acara::create($request->validated());

        return redirect()->route('admin.acara.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit acara
     */
    public function edit($id)
    {
        $acaraList = $this->getDummyAcara();
        $acara     = collect($acaraList)->firstWhere('id', (int) $id);
        $kategoris = ['Teknologi', 'Olahraga', 'Seminar', 'Hiburan', 'Seni'];

        if (!$acara) {
            abort(404, 'Acara tidak ditemukan');
        }

        return view('admin.kelola-acara.edit', compact('acara', 'kategoris'));
    }

    /**
     * Update data acara
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal'   => 'required|date',
            'kategori'  => 'required|string',
            'jenis'     => 'required|in:tim,individu',
            'lokasi'    => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'poster'    => 'nullable|image|mimes:jpg,png|max:5120',
        ]);

        // TODO: Update ke database
        // Acara::findOrFail($id)->update($request->validated());

        return redirect()->route('admin.acara.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Hapus acara
     */
    public function destroy($id)
    {
        // TODO: Hapus dari database
        // Acara::findOrFail($id)->delete();

        return redirect()->route('admin.acara.index')->with('success', 'Event berhasil dihapus!');
    }
}