<?php

namespace App\Http\Controllers\pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // ... (Data dummy yang kemarin tetap biarkan saja di sini) ...
        $dummyData = [
            [
                'id' => 1,
                'nama_event' => 'AI & MASA DEPAN KITA TECH FORUM 2024',
                'banner' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=300&q=80',
                'hari_tanggal' => 'Kamis, 29 Mei 2024',
                'jam' => '09.00 - 17.00 WIB',
                'lokasi' => 'Gedung Utama, Jl. Teknologi No. 1, Bandung',
                'qty' => 2,
                'jenis_tiket' => 'Regular',
                'kode_order' => 'EVT-200424-087',
                'status' => 'Selesai',
                'tanggal_beli' => '29 Mei 2024',
                'jam_beli' => '09.00 - 17.00 WIB'
            ],
            // ... data dummy lainnya
        ];

        // Simulasi Pagination Manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($dummyData);
        $perPage = 3;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        
        $riwayat = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $riwayat->setPath($request->url());

        // --- BAGIAN YANG DIUBAH ---
        // Sesuai lokasi asli file kamu: resources/views/Pengunjung/riwayat-pendaftaran.blade.php
        return view('Pengunjung.riwayat-pendaftaran', compact('riwayat'));
    }
}