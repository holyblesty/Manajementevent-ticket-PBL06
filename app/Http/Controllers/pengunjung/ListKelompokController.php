<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelompok;

class ListKelompokController extends Controller
{
    public function show()
    {
        $kelompoks = Kelompok::all();

        return view(
            'pengunjung.kelompok',
            compact('kelompoks')
        );
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'jumlah_anggota' => 'required|numeric',
            'event_id' => 'required|numeric'
        ]);

        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'jumlah_anggota' => $request->jumlah_anggota,
            'event_id' => $request->event_id
        ]);

        return redirect()
            ->route('kelompok')
            ->with('success', 'Data kelompok berhasil disimpan');
    }
}