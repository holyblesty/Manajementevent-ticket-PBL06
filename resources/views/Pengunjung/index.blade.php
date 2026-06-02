@extends('layouts.pengunjung')

@section('title', 'Semua Acara')

@section('content')

{{-- BREADCRUMB --}}
<div class="mb-6">

    <div class="flex items-center gap-2 text-sm text-gray-400">

        <span>Beranda</span>
        <span>›</span>
        <span class="text-[#7a4988] font-semibold">
            Acara
        </span>

    </div>

    <h1 class="mt-2 text-4xl font-bold text-[#7a4988]">
        Semua Acara
    </h1>

    <p class="text-gray-500 mt-2">
        Temukan berbagai event menarik yang bisa kamu ikuti.
    </p>

</div>

{{-- FILTER --}}
<div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">

    {{-- SEARCH --}}
    <div class="lg:col-span-2 relative">

        <input type="text"
               placeholder="Cari event berdasarkan judul..."
               class="w-full border border-gray-200 rounded-xl py-3 pl-12 pr-4 text-sm focus:ring-2 focus:ring-[#7a4988] focus:outline-none">

        <svg class="w-5 h-5 absolute left-4 top-4 text-gray-400"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>

        </svg>

    </div>

    {{-- KATEGORI --}}
    <select class="border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7a4988] focus:outline-none">

        <option>Semua Kategori</option>
        <option>Olahraga</option>
        <option>Seminar</option>
        <option>Hiburan</option>

    </select>

    {{-- RESET --}}
    <button class="border border-gray-200 rounded-xl py-3 text-sm font-semibold hover:bg-gray-50">

        Reset Filter

    </button>

</div>

{{-- FILTER BUTTON --}}
<div class="flex items-center justify-between mb-8">

    <div class="flex items-center gap-3">

        <button class="bg-[#7a4988] text-white px-5 py-2 rounded-lg text-sm font-semibold">
            Semua
        </button>

        <button class="border border-gray-200 px-5 py-2 rounded-lg text-sm hover:bg-gray-50">
            Olahraga
        </button>

        <button class="border border-gray-200 px-5 py-2 rounded-lg text-sm hover:bg-gray-50">
            Seminar
        </button>

        <button class="border border-gray-200 px-5 py-2 rounded-lg text-sm hover:bg-gray-50">
            Hiburan
        </button>

    </div>

    {{-- SORT --}}
    <select class="border border-gray-200 rounded-xl px-4 py-2 text-sm">

        <option>Terbaru</option>
        <option>Terlama</option>

    </select>

</div>

{{-- EVENT GRID --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- CARD 1 --}}
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">

        <img src="{{ asset('images/seminar.jpg') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full">
                Seminar
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e] leading-snug">
                AI & MASA DEPAN KITA TECH FORUM 2026
            </h3>

            <div class="mt-4 space-y-2 text-sm text-gray-500">

                <p>📅 29 Mei 2026 • 09.00 - 17.00 WIB</p>
                <p>📍 Gedung Utama, Bandung</p>

            </div>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 150.000
                </h4>

            </div>

            <button class="w-full mt-5 border border-[#7a4988] text-[#7a4988] py-2 rounded-lg font-semibold hover:bg-[#7a4988] hover:text-white transition">

                Lihat Detail

            </button>

        </div>

    </div>

    {{-- CARD 2 --}}
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">

        <img src="{{ asset('images/futsal.jpg') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-[#7a4988] text-white text-xs px-3 py-1 rounded-full">
                Olahraga
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e] leading-snug">
                FUTSAL KAMPUS CHAMPIONSHIP 2026
            </h3>

            <div class="mt-4 space-y-2 text-sm text-gray-500">

                <p>📅 30 Mei 2026 • 08.00 - 18.00 WIB</p>
                <p>📍 Lapangan Politeknik Bandung</p>

            </div>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 100.000
                </h4>

            </div>

            <button class="w-full mt-5 border border-[#7a4988] text-[#7a4988] py-2 rounded-lg font-semibold hover:bg-[#7a4988] hover:text-white transition">

                Lihat Detail

            </button>

        </div>

    </div>

    {{-- CARD 3 --}}
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">

        <img src="{{ asset('images/musik.png') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-pink-500 text-white text-xs px-3 py-1 rounded-full">
                Hiburan
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e] leading-snug">
                FESTIVAL BAND MAHASISWA 2026
            </h3>

            <div class="mt-4 space-y-2 text-sm text-gray-500">

                <p>📅 31 Mei 2026 • 17.00 - 22.00 WIB</p>
                <p>📍 Open Space, Bandung</p>

            </div>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 75.000
                </h4>

            </div>

            <button class="w-full mt-5 border border-[#7a4988] text-[#7a4988] py-2 rounded-lg font-semibold hover:bg-[#7a4988] hover:text-white transition">

                Lihat Detail

            </button>

        </div>

    </div>

    {{-- CARD 4 --}}
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">

        <img src="{{ asset('images/entrepreneur.jpg') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-violet-600 text-white text-xs px-3 py-1 rounded-full">
                Seminar
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e] leading-snug">
                CREATIVEPRENEUR FEST 2026
            </h3>

            <div class="mt-4 space-y-2 text-sm text-gray-500">

                <p>📅 10 Juni 2026 • 10.00 - 18.00 WIB</p>
                <p>📍 Eldorado Dome, Bandung</p>

            </div>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 125.000
                </h4>

            </div>

            <button class="w-full mt-5 border border-[#7a4988] text-[#7a4988] py-2 rounded-lg font-semibold hover:bg-[#7a4988] hover:text-white transition">

                Lihat Detail

            </button>

        </div>

    </div>

</div>

{{-- PAGINATION --}}
<div class="flex items-center justify-center gap-3 mt-10">

    <button class="w-10 h-10 rounded-lg border border-gray-200 hover:bg-gray-50">
        ‹
    </button>

    <button class="w-10 h-10 rounded-lg bg-[#7a4988] text-white font-bold">
        1
    </button>

    <button class="w-10 h-10 rounded-lg border border-gray-200 hover:bg-gray-50">
        2
    </button>

    <button class="w-10 h-10 rounded-lg border border-gray-200 hover:bg-gray-50">
        3
    </button>

    <button class="w-10 h-10 rounded-lg border border-gray-200 hover:bg-gray-50">
        ›
    </button>

</div>

@endsection