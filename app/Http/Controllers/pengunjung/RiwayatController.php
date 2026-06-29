<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat =
            Pemesanan::with([
                'event',
                'tiket'
            ])
            ->where(
                'id_pengunjung',
                Auth::user()->id_pengunjung
            )
            ->latest('tgl_pesan')
            ->get();

        return view(
            'pengunjung.riwayat-pendaftaran',
            compact('riwayat')
        );
    }
}
