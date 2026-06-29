@extends('layouts.public')

@section('title', $event->judul)

@section('content')

@php
    $totalKuota = $event->tiket->sum('kuota_tersedia');
@endphp

<div class="mb-6">
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#7a4988]/10 text-[#7a4988] font-semibold hover:bg-[#7a4988] hover:text-white transition">

        <i class="fa-solid fa-chevron-left text-xs"></i>
        <span>Kembali ke daftar event</span>

    </a>
</div>

<div class="grid grid-cols-1 gap-8">

    {{-- HERO --}}
    <div class="bg-white rounded-3xl shadow-sm border p-6">

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- Poster --}}
            <div>
                <img src="{{ asset('images/'.$event->poster) }}"
                     class="w-full rounded-2xl object-cover shadow">
            </div>

            {{-- Informasi --}}
            <div class="flex flex-col justify-between">

                <div>

                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900">
                        {{ $event->judul }}
                    </h1>

                    <p class="mt-4 text-gray-500 leading-relaxed">
                        {{ $event->deskripsi }}
                    </p>

                    {{-- INFO GRID --}}
                    <div class="grid sm:grid-cols-2 gap-4 mt-8">

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Tanggal</div>
                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($event->tgl_mulai)->translatedFormat('l, d F Y') }}
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Waktu</div>
                            <div class="font-semibold">
                                {{ $event->jam_mulai }} WIB
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Lokasi</div>
                            <div class="font-semibold">
                                {{ $event->lokasi }}
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Sisa Kuota</div>
                            <div class="font-semibold">
                                {{ $totalKuota }} Peserta
                            </div>
                        </div>

                    </div>

                    {{-- BUTTON BUY --}}
                    <div class="mt-8">

                        @if($totalKuota > 0)

                            @auth('web')
                                <a href="{{ route('pengunjung.pembelian', $event->id_event) }}"
                                   class="inline-block px-6 py-3 bg-[#7a4988] text-white rounded-xl font-semibold hover:bg-[#693b76] transition">
                                    Beli Sekarang
                                </a>
                            @else
                                <button onclick="openModal('loginModal')"
                                        class="inline-block px-6 py-3 bg-[#7a4988] text-white rounded-xl font-semibold hover:bg-[#693b76] transition">
                                    Login untuk Beli
                                </button>
                            @endauth

                        @else

                            <button disabled
                                class="px-6 py-3 rounded-xl bg-gray-300 text-white font-semibold cursor-not-allowed">
                                Kuota Penuh
                            </button>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- DETAIL BOTTOM --}}
    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl border">
            <h3 class="font-bold mb-2">Status Event</h3>
            <p class="text-green-600 font-semibold">
                {{ ucfirst($event->status_event) }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border">
            <h3 class="font-bold mb-2">Kapasitas</h3>
            <p>{{ $event->kapasitas }} Peserta</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border">
            <h3 class="font-bold mb-2">Sisa Kuota</h3>
            <p>{{ $totalKuota }} Peserta</p>
        </div>

    </div>

    {{-- TIKET --}}
    <div class="bg-white rounded-3xl border shadow-sm p-8">

        <h2 class="text-2xl font-bold mb-5">Daftar Tiket</h2>

        <div class="grid md:grid-cols-3 gap-6">

            @foreach($event->tiket as $t)

                <div class="p-4 border rounded-xl {{ $t->kuota_tersedia <= 0 ? 'bg-red-50' : 'bg-gray-50' }}">

                    <h3 class="font-bold text-lg">
                        {{ $t->jenis_tiket }}
                    </h3>

                    <p class="text-sm text-gray-500">
                        Rp{{ number_format($t->harga) }}
                    </p>

                    <p class="mt-2 font-semibold">
                        {{ $t->kuota_tersedia > 0 ? $t->kuota_tersedia.' tersisa' : 'Habis' }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection