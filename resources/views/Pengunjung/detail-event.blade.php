@extends('layouts.pengunjung')

@section('title', $event->judul)

@section('content')

{{-- Breadcrumb --}}
<div class="flex flex-wrap items-center gap-2 text-sm text-gray-400 mb-6">

    <span>Beranda</span>
    <span>›</span>

    <span>Event</span>
    <span>›</span>

    <span class="font-semibold text-[#7a4988]">
        Detail Event
    </span>

</div>

<div class="grid grid-cols-1 gap-8">

    {{-- HERO SECTION --}}
    <div class="bg-white rounded-3xl shadow-sm border p-6">

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- Poster --}}
            <div>

                <img
                    src="{{ asset('images/'.$event->poster) }}"
                    alt="{{ $event->judul }}"
                    class="w-full rounded-2xl object-cover shadow">

            </div>

            {{-- Informasi --}}
            <div class="flex flex-col justify-between">

                <div>

                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900">
                        {{ strtoupper($event->judul) }}
                    </h1>

                    <p class="mt-4 text-gray-500 leading-relaxed">
                        {{ $event->deskripsi }}
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4 mt-8">

                        <div class="bg-gray-50 rounded-xl p-4">

                            <div class="text-xs text-gray-500">
                                Tanggal
                            </div>

                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                            </div>

                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">

                            <div class="text-xs text-gray-500">
                                Waktu
                            </div>

                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($event->waktu_acara)->format('H:i') }} WIB
                            </div>

                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">

                            <div class="text-xs text-gray-500">
                                Lokasi
                            </div>

                            <div class="font-semibold">
                                {{ $event->lokasi }}
                            </div>

                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">

                            <div class="text-xs text-gray-500">
                                Kuota Tersedia
                            </div>

                            <div class="font-semibold">
                                {{ $event->kuota_tersedia }} Peserta
                            </div>

                        </div>

                    </div>
                     {{-- CTA --}}
                <div class="mt-8">

                    @if($event->kuota_tersedia > 0)

                        <button
                            class="w-full lg:w-auto px-8 py-4 rounded-xl bg-[#7a4988] text-white font-semibold hover:bg-[#693b76]">

                            Daftar Sekarang

                        </button>

                    @else

                        <button
                            disabled
                            class="w-full lg:w-auto px-8 py-4 rounded-xl bg-gray-300 text-white">

                            Kuota Penuh

                        </button>

                </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- DESKRIPSI EVENT --}}
    <div class="bg-white rounded-3xl border shadow-sm p-8">

        <h2 class="text-2xl font-bold mb-5">
            Tentang Event
        </h2>

        <p class="text-gray-600 leading-loose whitespace-pre-line">
            {{ $event->deskripsi }}
        </p>

    </div>

    {{-- INFORMASI TAMBAHAN --}}
    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-2xl border">

            <h3 class="font-bold mb-3">
                Status Event
            </h3>

            <span
                class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">

                {{ ucfirst($event->status_event) }}

            </span>

        </div>

        <div class="bg-white p-6 rounded-2xl border">

            <h3 class="font-bold mb-3">
                Kapasitas
            </h3>

            <p>{{ $event->kapasitas }} Peserta</p>

        </div>

        <div class="bg-white p-6 rounded-2xl border">

            <h3 class="font-bold mb-3">
                Sisa Kuota
            </h3>

            <p>{{ $event->kuota_tersedia }} Peserta</p>

        </div>

    </div>

</div>

@endsection