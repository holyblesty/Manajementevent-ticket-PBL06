@extends('layouts.app')

@section('content')

<div>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">

        <span>Beranda</span>

        <i class="fa-solid fa-chevron-right text-xs"></i>

        <span>Event</span>

        <i class="fa-solid fa-chevron-right text-xs"></i>

        <span class="text-purple-700 font-medium">
            Detail Event
        </span>

    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-3 gap-8">

        {{-- Left --}}
        <div class="col-span-2">

            {{-- Header Event --}}
            <div class="bg-white rounded-2xl border shadow-sm p-6">

                <div class="flex gap-6">

                    {{-- Image --}}
                    <div class="w-[260px]">

                        <img
                            src="https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=1200"
                            class="rounded-2xl h-[220px] object-cover w-full">

                    </div>

                    {{-- Info --}}
                    <div class="flex-1">

                        <h1 class="text-4xl font-bold text-purple-700 leading-tight">
                            TURNAMEN BASKET 2026
                        </h1>

                        <p class="text-gray-500 mt-4 leading-7">
                            Turnamen olahraga antar tim untuk menjunjung sportivitas,
                            kebersamaan, dan semangat kompetisi yang sehat.
                        </p>

                        <div class="space-y-4 mt-6">

                            <div class="flex items-center gap-4">

                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-700">
                                    <i class="fa-solid fa-calendar"></i>
                                </div>

                                <span class="text-gray-700">
                                    Sabtu, 15 Maret 2026
                                </span>

                            </div>

                            <div class="flex items-center gap-4">

                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-700">
                                    <i class="fa-solid fa-clock"></i>
                                </div>

                                <span class="text-gray-700">
                                    08.00 - 17.00 WIB
                                </span>

                            </div>

                            <div class="flex items-center gap-4">

                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-700">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>

                                <span class="text-gray-700">
                                    Gelanggang Olahraga (GOR) Bandung
                                </span>

                            </div>

                            <div class="flex items-center gap-4">

                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-700">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>

                                <span class="text-gray-700">
                                    Tiket: 1 x Early Bird
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Tabs --}}
            <div class="bg-white rounded-2xl border shadow-sm mt-8 p-6">

                {{-- Tab Menu --}}
                <div class="flex gap-8 border-b pb-4 mb-6">

                    <button class="text-purple-700 font-bold border-b-2 border-purple-700 pb-3">
                        Deskripsi
                    </button>

                    <button class="text-gray-500 hover:text-purple-700">
                        Susunan Acara
                    </button>

                    <button class="text-gray-500 hover:text-purple-700">
                        Pembicara
                    </button>

                    <button class="text-gray-500 hover:text-purple-700">
                        Lokasi
                    </button>

                </div>

                {{-- Description --}}
                <div>

                    <p class="text-gray-600 leading-8">
                        Turnamen ini menjadi wadah bagi para atlet untuk menunjukkan kemampuan terbaik mereka sekaligus mempererat hubungan antar komunitas olahraga.
                        Saksikan pertandingan seru dan dukung tim favorit Anda!
                    </p>

                    <h3 class="text-xl font-bold text-purple-700 mt-8 mb-5">
                        Yang akan Anda dapatkan:
                    </h3>

                    <div class="space-y-4">

                        <div class="flex items-center gap-3">

                            <i class="fa-solid fa-check text-purple-700"></i>

                            <span>Akses semua pertandingan</span>

                        </div>

                        <div class="flex items-center gap-3">

                            <i class="fa-solid fa-check text-purple-700"></i>

                            <span>Sertifikat partisipasi</span>

                        </div>

                        <div class="flex items-center gap-3">

                            <i class="fa-solid fa-check text-purple-700"></i>

                            <span>Souvenir eksklusif</span>

                        </div>

                        <div class="flex items-center gap-3">

                            <i class="fa-solid fa-check text-purple-700"></i>

                            <span>Doorprize menarik</span>

                        </div>

                        <div class="flex items-center gap-3">

                            <i class="fa-solid fa-check text-purple-700"></i>

                            <span>Fasilitas lengkap dan nyaman</span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div>

            {{-- Ticket Box --}}
            <div class="bg-white rounded-2xl border shadow-sm p-6 sticky top-6">

                <h2 class="text-2xl font-bold mb-6">
                    Pilih Tiket
                </h2>

                {{-- Early Bird --}}
                <div class="border-2 border-purple-700 rounded-2xl p-5 mb-5">

                    <div class="flex justify-between">

                        <div>

                            <div class="flex items-center gap-3">

                                <input type="radio" checked>

                                <h3 class="font-bold text-lg">
                                    Early Bird
                                </h3>

                            </div>

                            <h2 class="text-2xl font-bold text-purple-700 mt-3">
                                Rp 100.000
                            </h2>

                            <p class="text-sm text-gray-500 mt-2">
                                Akses semua sesi
                            </p>

                            <p class="text-sm text-gray-500">
                                Kuota terbatas!
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            Sisa 50
                        </span>

                    </div>

                </div>

                {{-- Normal --}}
                <div class="border rounded-2xl p-5 mb-5">

                    <div class="flex justify-between">

                        <div>

                            <div class="flex items-center gap-3">

                                <input type="radio">

                                <h3 class="font-bold text-lg">
                                    Normal
                                </h3>

                            </div>

                            <h2 class="text-2xl font-bold text-purple-700 mt-3">
                                Rp 150.000
                            </h2>

                            <p class="text-sm text-gray-500 mt-2">
                                Akses semua sesi
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            Sisa 120
                        </span>

                    </div>

                </div>

                {{-- VIP --}}
                <div class="border rounded-2xl p-5">

                    <div class="flex justify-between">

                        <div>

                            <div class="flex items-center gap-3">

                                <input type="radio">

                                <h3 class="font-bold text-lg">
                                    VIP
                                </h3>

                            </div>

                            <h2 class="text-2xl font-bold text-purple-700 mt-3">
                                Rp 250.000
                            </h2>

                            <p class="text-sm text-gray-500 mt-2">
                                Akses semua sesi, lunch &
                                souvenir eksklusif
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            Sisa 30
                        </span>

                    </div>

                </div>

                {{-- Qty --}}
                <div class="mt-8">

                    <div class="flex items-center justify-between mb-4">

                        <span class="font-medium">
                            Jumlah Tiket
                        </span>

                        <input type="number"
                               value="1"
                               class="w-20 border rounded-lg px-3 py-2">

                    </div>

                    <div class="flex items-center justify-between mb-6">

                        <span class="font-medium text-lg">
                            Total Pembayaran
                        </span>

                        <span class="text-3xl font-bold text-purple-700">
                            Rp 100.000
                        </span>

                    </div>

                    {{-- Buttons --}}
                    <div class="space-y-4">

                        <a href="/register-individual"
                           class="block w-full bg-purple-700 hover:bg-purple-800 text-white py-4 rounded-xl text-center font-bold transition">

                            Daftar Individu

                        </a>

                        <a href="/register-team"
                           class="block w-full border-2 border-purple-700 text-purple-700 hover:bg-purple-700 hover:text-white py-4 rounded-xl text-center font-bold transition">

                            Daftar Tim

                        </a>

                    </div>

                </div>

                {{-- Ticket Preview --}}
                <div class="mt-8 border rounded-2xl p-5">

                    <div class="h-20 border-2 border-dashed rounded-xl flex items-center justify-center text-gray-400">

                        Preview Ticket

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection