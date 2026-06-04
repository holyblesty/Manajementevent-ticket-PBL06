<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Halaman Pembelian Tiket
     */
    public function index($id)
    {
        // AMBIL EVENT
        $event = Event::findOrFail($id);

        // AMBIL TIKET BERDASARKAN EVENT
        $tikets = Tiket::where(
            'id_event',
            $id
        )->get();

        // KIRIM KE VIEW
        return view(
            'Pengunjung.pembeliantiket',
            compact(
                'event',
                'tikets'
            )
        );
    }

    /**
     * Simpan Pembelian
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update Pembelian
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Hapus Pembelian
     */
    public function destroy($id)
    {
        //
    }
}