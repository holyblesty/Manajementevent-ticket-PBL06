@extends('layouts.pengunjung')

@section('title','Detail Tiket')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-[#7a4988] p-8 text-white">

            <h1 class="text-3xl font-bold">
                E-Ticket Event
            </h1>

            <p class="mt-2">
                Tunjukkan tiket ini kepada panitia.
            </p>

        </div>

        <div class="p-8">

            <div class="bg-purple-50 rounded-2xl p-6 text-center mb-8">

                <p class="text-gray-500">
                    Kode Registrasi
                </p>

                <h2 class="text-4xl font-bold text-[#7a4988] mt-2">
                    {{ $pemesanan->kode_registrasi }}
                </h2>

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Nama Event</p>
                    <h3 class="font-bold">
                        {{ $pemesanan->event->judul }}
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Jenis Tiket</p>
                    <h3 class="font-bold">
                        {{ $pemesanan->tiket->jenis_tiket }}
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Tanggal Event</p>
                    <h3 class="font-bold">
                        {{ $pemesanan->event->tgl_mulai }}
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Jam Event</p>
                    <h3 class="font-bold">
                        {{ $pemesanan->event->jam_mulai }}
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Lokasi</p>
                    <h3 class="font-bold">
                        {{ $pemesanan->event->lokasi }}
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Jumlah Tiket</p>
                    <h3 class="font-bold">
                        {{ $pemesanan->jumlah_tiket }}
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Metode Pembayaran</p>
                    <h3 class="font-bold">
                        Cash
                    </h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl">
                    <p class="text-gray-500">Status</p>
                    <h3 class="font-bold text-orange-500">
                        {{ $pemesanan->sts_transaksi }}
                    </h3>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection