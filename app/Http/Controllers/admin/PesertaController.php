<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    /**
     * Ambil data dummy peserta dari session
     */
    private function getDummyPeserta()
    {
        if (session()->has('data_peserta')) {
            return session('data_peserta');
        }

        // Data awal kalau session masih kosong
        $peserta = [
            1 => [
                'id' => 'TKT-001',
                'nama' => 'Tim Teknik Elektro',
                'kontak' => '0812-3344-5566',
                'event' => 'Turnamen Basket',
                'tier' => 'Early Bird',
                'status_bayar' => 'Lunas',
                'hadir' => false
            ],
            2 => [
                'id' => 'TKT-002',
                'nama' => 'Budi Santoso',
                'kontak' => '0899-8877-6655',
                'event' => 'Seminar Nasional AI',
                'tier' => 'VIP',
                'status_bayar' => 'Pending',
                'hadir' => false
            ],
            3 => [
                'id' => 'TKT-003',
                'nama' => 'Siska Anggraini',
                'kontak' => '0877-1122-3344',
                'event' => 'Festival Musik',
                'tier' => 'Normal',
                'status_bayar' => 'Lunas',
                'hadir' => true
            ],
        ];

        session(['data_peserta' => $peserta]);
        return $peserta;
    }

    public function index()
    {
        $peserta = $this->getDummyPeserta();
        return view('admin.peserta', compact('peserta'));
    }

    public function checkIn($id)
    {
        $data = $this->getDummyPeserta();

        // Cari peserta berdasarkan ID (key array)
        foreach ($data as $key => $val) {
            if ($val['id'] == $id) {
                if ($data[$key]['status_bayar'] !== 'Lunas') {
                    return redirect()->back()->with('error', 'Peserta belum lunas pembayaran!');
                }

                $data[$key]['hadir'] = true;
                session(['data_peserta' => $data]);
                session()->save();

                return redirect()->back()->with('success', 'Check-in berhasil untuk ' . $val['nama']);
            }
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
}