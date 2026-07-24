@extends('layouts.pengunjung')

@section('content')

<div class="container mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-6">
        Riwayat Pendaftaran Event
    </h1>

    @if(session('success'))
        <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-[#7a4988] text-white">

                <tr>
                    <th class="p-4 text-left">Kode</th>
                    <th class="p-4 text-left">Event</th>
                    <th class="p-4 text-left">Jenis Tiket</th>
                    <th class="p-4 text-center">Jumlah</th>
                    <th class="p-4 text-left">Metode</th>
                    <th class="p-4 text-left">Total</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

            @forelse($riwayat as $item)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4 font-semibold">
                        {{ $item->kode_registrasi }}
                    </td>

                    <td class="p-4">
                        {{ $item->event->judul }}
                    </td>

                    <td class="p-4">
                        {{ $item->tiket->jenis_tiket }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $item->jumlah_tiket }}
                    </td>

                    <td class="p-4">
                        {{ $item->metode_pembayaran }}
                    </td>

                    <td class="p-4">
                        Rp {{ number_format($item->total_harga,0,',','.') }}
                    </td>

                    <td class="p-4 text-center">

                        @if($item->sts_transaksi == 'Belum Bayar')

                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">
                                Belum Bayar
                            </span>

                        @elseif($item->sts_transaksi == 'Menunggu Verifikasi')

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                                Menunggu Verifikasi
                            </span>

                        @elseif($item->sts_transaksi == 'Lunas')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                Lunas
                            </span>

                        @elseif($item->sts_transaksi == 'Ditolak')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                Ditolak
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">
                                {{ $item->sts_transaksi }}
                            </span>

                        @endif

                    </td>

                    <td class="p-4 text-center">

                        @if($item->sts_transaksi == 'Lunas')

                            <a href="{{ route('pengunjung.tiket.detail',$item->id_pesanan) }}"
                               class="bg-[#7a4988] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#5e3566]">
                                Lihat Tiket
                            </a>

                        @elseif($item->sts_transaksi == 'Belum Bayar')

                            <span class="text-orange-600 font-semibold text-sm">
                                Menunggu Pembayaran
                            </span>

                        @elseif($item->sts_transaksi == 'Menunggu Verifikasi')

                            <span class="text-yellow-600 font-semibold text-sm">
                                Diproses Admin
                            </span>

                        @elseif($item->sts_transaksi == 'Ditolak')

                            <span class="text-red-600 font-semibold text-sm">
                                Pembayaran Ditolak
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center py-10 text-gray-500">

                        Belum ada riwayat pendaftaran.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection