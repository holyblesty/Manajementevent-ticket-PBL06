@extends('layouts.pengunjung')

@section('title', 'Dashboard Pengunjung')

@section('content')

{{-- WELCOME --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#7a4988]">
        Halo, Sisi! 👋
    </h1>

    <p class="text-gray-500 mt-2">
        Selamat datang kembali! Temukan event menarik dan dapatkan pengalaman terbaik.
    </p>

</div>

{{-- STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">

    <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100">
        <p class="text-gray-800 text-sm">Ticket Saya</p>
        <h2 class="text-4xl font-bold text-[#24112e] mt-2">2</h2>
        <p class="text-xs text-gray-400 mt-1">Ticket aktif</p>
    </div>

    <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100">
        <p class="text-gray-800 text-sm">Riwayat Pendaftaran</p>
        <h2 class="text-4xl font-bold text-[#24112e] mt-2">5</h2>
        <p class="text-xs text-gray-400 mt-1">Event diikuti</p>
    </div>

    <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100">
        <p class="text-gray-800 text-sm">Event Mendatang</p>
        <h2 class="text-4xl font-bold text-[#24112e] mt-2">3</h2>
        <p class="text-xs text-gray-400 mt-1">Event terdaftar</p>
    </div>

</div>

{{-- EVENT --}}
<div class="flex items-center justify-between mb-6">

    <h2 class="text-xl font-bold text-[#24112e]">
        Event Rekomendasi Untuk Anda
    </h2>

    <a href="#"
       class="text-[#7a4988] font-semibold text-sm no-underline">
        Lihat Semua
    </a>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- CARD 1 --}}
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">

        <img src="{{ asset('images/basket.png') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-[#7a4988] text-white text-xs px-3 py-1 rounded-full">
                Olahraga
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e]">
                TURNAMEN BASKET 2026
            </h3>

            <p class="text-gray-500 text-sm mt-3">
                📍 GOR Bandung
            </p>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 200.000
                </h4>

            </div>

        </div>

    </div>

    {{-- CARD 2 --}}
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">

        <img src="{{ asset('images/seminar.jpg') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full">
                Seminar
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e]">
                AI & MASA DEPAN KITA
            </h3>

            <p class="text-gray-500 text-sm mt-3">
                📍 Gedung Utama Bandung
            </p>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 150.000
                </h4>

            </div>

        </div>

    </div>

    {{-- CARD 3 --}}
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">

        <img src="{{ asset('images/musik.png') }}"
             class="h-52 w-full object-cover">

        <div class="p-5">

            <span class="bg-pink-500 text-white text-xs px-3 py-1 rounded-full">
                Hiburan
            </span>

            <h3 class="mt-4 text-xl font-bold text-[#24112e]">
                FESTIVAL BAND MAHASISWA
            </h3>

            <p class="text-gray-500 text-sm mt-3">
                📍 Open Space Bandung
            </p>

            <div class="mt-6">

                <p class="text-xs text-gray-400">
                    Mulai dari
                </p>

                <h4 class="text-2xl font-bold text-[#7a4988]">
                    Rp 75.000
                </h4>

            </div>

        </div>

    </div>

</div>

@endsection