<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Pendaftaran::latest()->get();

        return view('Pengunjung.riwayat', compact('riwayat'));
    }
}