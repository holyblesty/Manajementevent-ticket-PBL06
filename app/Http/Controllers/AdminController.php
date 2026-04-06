<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman dashboard admin
    public function dashboard()
    {
        // nanti bisa kirim data event, tiket, peserta
        return view('admin.dashboard');
    }

    // Contoh method: lihat semua event
    public function events()
    {
        return view('admin.events');
    }

    // Contoh method: lihat semua peserta
    public function participants()
    {
        return view('admin.participants');
    }
}