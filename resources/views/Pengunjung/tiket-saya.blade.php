@extends('layouts.pengunjung')

@section('title', 'Ticket Saya')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-[#7a4988]">
        Ticket Saya
    </h1>

    <p class="text-gray-500 mt-2">
        Daftar tiket event yang telah Anda pesan.
    </p>
</div>

@if($pemesanan->count() == 0)

    <div class="bg-white rounded-3xl shadow p-10 text-center">

        <h2 class="text-2xl font-semibold text-gray-700">
            Belum Ada Tiket
        </h2>

        <p class="text-gray-500 mt-3">
            Anda belum melakukan pemesanan tiket event.
        </p>

    </div>

@else

    <div class="grid gap-5">

        @foreach($pemesanan as $item)

        <div class="bg-white rounded-3xl shadow p-6">

            <div class="flex justify-between items-center">

                <div>

                    <h2 class="text-xl font-bold text-[#7a4988]">
                        {{ $item->event->judul }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Kode Registrasi:
                        <strong>
                            {{ $item->kode_registrasi }}
                        </strong>
                    </p>

                    <p class="text-gray-500">
                        Tiket:
                        {{ $item->tiket->jenis_tiket }}
                    </p>

                    <p class="text-gray-500">
                        Status:
                        {{ $item->sts_transaksi }}
                    </p>

                </div>

                <div>

                    <a href="{{ route('pengunjung.tiket.detail', $item->id_pesanan) }}"
                       class="bg-[#7a4988] text-white px-5 py-2 rounded-xl hover:bg-[#693b76]">

                        Detail Tiket

                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

@endif

@endsection