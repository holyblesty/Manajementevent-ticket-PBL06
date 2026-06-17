<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;

class TiketController extends Controller
{
    public function index()
    {
        return view('pengunjung.pembelian-tiket');
    }
}