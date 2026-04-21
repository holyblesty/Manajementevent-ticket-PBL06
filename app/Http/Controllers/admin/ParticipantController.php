<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    // 1. Menampilkan halaman Pilih Event (Gambar 1)
    public function index()
    {
        // Path menyesuaikan nama folder di gambarmu: admin/Kelola Peserta/index.blade.php
        return view('admin.kelola_peserta.index');
    }

    // 2. Menampilkan detail event Futsal / Tim (Gambar 2 & 3)
    public function showTeam()
    {
        return view('admin.kelola_peserta.team');
    }

    // 3. Menampilkan detail event Seminar / Individu (Gambar 4)
    public function showIndividual()
    {
        return view('admin.kelola_peserta.individual');
    }
}