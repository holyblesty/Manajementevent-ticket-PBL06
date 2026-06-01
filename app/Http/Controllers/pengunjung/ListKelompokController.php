<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;

class ListKelompokController extends Controller
{
    public function show()
    {
        // Mengambil semua data dari tabel kelompoks
        $data = Kelompok::get();

        // Membuat array kosong
        $nama_kelompok = [];
        $jumlah_anggota = [];
        $event_id = [];

        // Looping data
        foreach ($data as $kelompok) {

            $nama_kelompok[] = $kelompok->nama_kelompok;

            $jumlah_anggota[] = $kelompok->jumlah_anggota;

            $event_id[] = $kelompok->event_id;
        }

        // Mengirim data ke view
        return view(
            'Pengunjung.kelompok.list_kelompok',
            compact(
                'nama_kelompok',
                'jumlah_anggota',
                'event_id'
            )
        );
    }
}