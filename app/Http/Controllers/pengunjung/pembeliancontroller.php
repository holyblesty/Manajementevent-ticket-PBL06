<?php

namespace App\Http\Controllers\pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class pembeliancontroller extends Controller
{
    public function index()
    {
        // Data dummy event yang sedang dipilih untuk dibeli sesuai mockup
        $event = [
            'nama_event' => 'AI & MASA DEPAN KITA TECH FORUM 2024',
            'banner' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=500&q=80',
            'hari_tanggal' => 'Kamis, 29 Mei 2024',
            'jam' => '09.00 - 17.00 WIB',
            'lokasi' => 'Gedung Utama, Jl. Teknologi No. 1, Bandung',
            'deskripsi' => 'Tech Forum yang membahas perkembangan kecerdasan buatan dan masa depan teknologi.'
        ];

        // Mengarah ke folder layouts/Pengunjung/pembeliantiket.blade.php
        return view('layouts.Pengunjung.pembeliantiket', compact('event'));
    }
}