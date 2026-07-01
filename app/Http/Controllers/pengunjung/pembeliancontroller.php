<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pemesanan;
use App\Models\Pengunjung;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(int $id_event)
    {
        $event = Event::findOrFail($id_event);

        $tiket = Tiket::where(
            'id_event',
            $id_event
        )->get();

        $pengunjung = Auth::guard('web')->user();

        return view(
            'pengunjung.pembeliantiket',
            compact(
                'event',
                'tiket',
                'pengunjung'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email',
            'no_hp'                => 'required',
            'alamat'               => 'required',
            'id_event'             => 'required|exists:events,id_event',
            'id_tiket'             => 'required|exists:tiket,id_tiket',
            'jumlah_tiket'         => 'required|integer|min:1',
            'metode_pembayaran'    => 'required',
            'bank_tujuan'          => 'nullable|string',
            'bukti_transfer'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        try {

            $pemesanan = DB::transaction(function () use ($request) {

                $pengunjung = Pengunjung::findOrFail(
                    Auth::guard('web')->id()
                );

                $tiket = Tiket::lockForUpdate()->findOrFail(
                    $request->id_tiket
                );

                if (
                    $tiket->kuota_tersedia <
                    $request->jumlah_tiket
                ) {
                    throw new \Exception(
                        'Kuota tiket tidak mencukupi.'
                    );
                }

                $pengunjung->update([
                    'name'   => $request->name,
                    'email'  => $request->email,
                    'no_hp'  => $request->no_hp,
                    'alamat' => $request->alamat,
                ]);

                $bukti = null;

                if ($request->hasFile('bukti_transfer')) {

                    $bukti = time() .
                        '_' .
                        $request->file('bukti_transfer')->getClientOriginalName();

                    $request->file('bukti_transfer')
                        ->move(
                            public_path('bukti_transfer'),
                            $bukti
                        );
                }

                if ($request->metode_pembayaran == 'Transfer') {

                    $status = 'Menunggu Verifikasi';
                    $batas = null;

                } else {

                    $status = 'Belum Bayar';
                    $batas = now()->addDays(1);

                }

                $pesanan = Pemesanan::create([

                    'id_event'              => $request->id_event,

                    'id_pengunjung'         => $pengunjung->id_pengunjung,

                    'id_tiket'              => $request->id_tiket,

                    'tgl_pesan'             => now(),

                    'tgl_bayar'             => null,

                    'metode_pembayaran'     => $request->metode_pembayaran,

                    'bank_tujuan'           => $request->bank_tujuan,

                    'bukti_transfer'        => $bukti,

                    'batas_pembayaran'      => $batas,

                    'jumlah_tiket'          => $request->jumlah_tiket,

                    'total_harga'           => $tiket->harga *
                                               $request->jumlah_tiket,

                    'kode_registrasi'       => Pemesanan::generateKode(),

                    'sts_transaksi'         => $status

                ]);

                $tiket->decrement(
                    'kuota_tersedia',
                    $request->jumlah_tiket
                );

                return $pesanan;

            });

            return redirect()->route(
                'pengunjung.pembelian.sukses',
                $pemesanan->id_pesanan
            );

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }
       public function sukses(int $id)
    {
        $pemesanan = Pemesanan::with([
            'event',
            'tiket',
            'pengunjung'
        ])->findOrFail($id);

        return view(
            'pengunjung.pembelian-sukses',
            compact('pemesanan')
        );
    }

    public function tiketSaya()
    {
        $pengunjung = Auth::guard('web')->user();

        $pemesanan = Pemesanan::with([
                'event',
                'tiket'
            ])
            ->where(
                'id_pengunjung',
                $pengunjung->id_pengunjung
            )

            // hanya tiket yang sudah lunas
            ->where('sts_transaksi', 'Lunas')

            ->latest('id_pesanan')
            ->get();

        return view(
            'pengunjung.tiket-saya',
            compact('pemesanan')
        );
    }

    public function detailTiket(int $id)
    {
        $pemesanan = Pemesanan::with([
                'event',
                'tiket',
                'pengunjung'
            ])
            ->findOrFail($id);

        return view(
            'pengunjung.detail-tiket',
            compact('pemesanan')
        );
    }
}