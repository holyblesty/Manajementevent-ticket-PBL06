<?php

// app/Http/Controllers/pengunjung/RiwayatController.php

namespace App\Http\Controllers\pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RiwayatController extends Controller
{
    /**
     * Data dummy riwayat pendaftaran (tanpa database)
     */
    private function getDummyData(): array
    {
        return [
            [
                'id'          => 1,
                'kode_order'  => 'EVT-200424-087',
                'jumlah'      => 2,
                'jenis_tiket' => 'Regular',
                'status'      => 'selesai',
                'event' => [
                    'nama'        => 'AI & MASA DEPAN KITA TECH FORUM 2024',
                    'tanggal'     => '2024-05-29',
                    'jam_mulai'   => '09.00',
                    'jam_selesai' => '17.00',
                    'lokasi'      => 'Gedung Utama, Jl. Teknologi No. 1, Bandung',
                    'thumbnail'   => null,
                ],
            ],
            [
                'id'          => 2,
                'kode_order'  => 'EVT-100324-056',
                'jumlah'      => 1,
                'jenis_tiket' => 'Early Bird',
                'status'      => 'selesai',
                'event' => [
                    'nama'        => 'CREATIVEPRENEUR FEST 2024',
                    'tanggal'     => '2024-03-10',
                    'jam_mulai'   => '10.00',
                    'jam_selesai' => '18.00',
                    'lokasi'      => 'Eldorado Dome, Bandung',
                    'thumbnail'   => null,
                ],
            ],
            [
                'id'          => 3,
                'kode_order'  => 'EVT-240224-033',
                'jumlah'      => 1,
                'jenis_tiket' => 'Standard',
                'status'      => 'selesai',
                'event' => [
                    'nama'        => 'WEBINAR UI/UX DESIGN 2024',
                    'tanggal'     => '2024-02-24',
                    'jam_mulai'   => '13.00',
                    'jam_selesai' => '16.00',
                    'lokasi'      => 'Online via Zoom',
                    'thumbnail'   => null,
                ],
            ],
            [
                'id'          => 4,
                'kode_order'  => 'EVT-150124-012',
                'jumlah'      => 3,
                'jenis_tiket' => 'VIP',
                'status'      => 'selesai',
                'event' => [
                    'nama'        => 'STARTUP SUMMIT INDONESIA 2024',
                    'tanggal'     => '2024-01-15',
                    'jam_mulai'   => '08.00',
                    'jam_selesai' => '20.00',
                    'lokasi'      => 'Jakarta Convention Center, Jakarta',
                    'thumbnail'   => null,
                ],
            ],
            [
                'id'          => 5,
                'kode_order'  => 'EVT-201223-099',
                'jumlah'      => 1,
                'jenis_tiket' => 'Regular',
                'status'      => 'selesai',
                'event' => [
                    'nama'        => 'DIGITAL MARKETING MASTERCLASS 2023',
                    'tanggal'     => '2023-12-20',
                    'jam_mulai'   => '09.00',
                    'jam_selesai' => '15.00',
                    'lokasi'      => 'Hotel Santika, Bandung',
                    'thumbnail'   => null,
                ],
            ],
        ];
    }

    /**
     * Ubah array biasa menjadi object agar bisa diakses dengan ->
     */
    private function toObject(array $data): object
    {
        $obj              = new \stdClass();
        $obj->id          = $data['id'];
        $obj->kode_order  = $data['kode_order'];
        $obj->jumlah      = $data['jumlah'];
        $obj->jenis_tiket = $data['jenis_tiket'];
        $obj->status      = $data['status'];

        $e                = new \stdClass();
        $e->nama          = $data['event']['nama'];
        $e->tanggal       = $data['event']['tanggal'];
        $e->jam_mulai     = $data['event']['jam_mulai'];
        $e->jam_selesai   = $data['event']['jam_selesai'];
        $e->lokasi        = $data['event']['lokasi'];
        $e->thumbnail     = $data['event']['thumbnail'];

        $obj->event = $e;
        return $obj;
    }

    /**
     * Tampilkan halaman riwayat pendaftaran (dummy, tanpa DB)
     */
    public function index(Request $request)
    {
        $perPage     = 3;
        $currentPage = (int) $request->get('page', 1);
        $allData     = collect($this->getDummyData())->map(fn($d) => $this->toObject($d));

        $paged = new LengthAwarePaginator(
            $allData->forPage($currentPage, $perPage)->values(),
            $allData->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('Pengunjung.riwayat-pendaftaran', ['riwayat' => $paged]);
    }

    /**
     * Detail riwayat (dummy)
     */
    public function detail($id)
    {
        $item = collect($this->getDummyData())
            ->firstWhere('id', (int) $id);

        if (!$item) abort(404);

        $item = $this->toObject($item);
        return view('Pengunjung.riwayat-detail', compact('item'));
    }

    /**
     * E-Tiket (dummy)
     */
    public function etiket($id)
    {
        $item = collect($this->getDummyData())
            ->firstWhere('id', (int) $id);

        if (!$item) abort(404);

        $item = $this->toObject($item);
        return view('Pengunjung.etiket', compact('item'));
    }
}