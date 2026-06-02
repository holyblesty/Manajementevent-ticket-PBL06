@extends('layouts.pengunjung')

@section('title', 'Detail Event')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">

    <span>Beranda</span>
    <span>›</span>

    <span>Acara</span>
    <span>›</span>

    <span class="text-[#7a4988] font-semibold">
        Detail Event
    </span>

</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    {{-- LEFT CONTENT --}}
    <div class="xl:col-span-2">

        {{-- EVENT HEADER --}}
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- IMAGE --}}
            <div class="w-full lg:w-72">

                <img src="{{ asset('images/basket.png') }}"
                     class="w-full h-72 object-cover rounded-2xl shadow-sm">

            </div>

            {{-- INFO --}}
            <div class="flex-1">

                <h1 class="text-4xl font-bold text-[#24112e]">
                    TURNAMEN BASKET 2026
                </h1>

                <p class="mt-4 text-gray-500 leading-relaxed">

                    Turnamen olahraga antar tim untuk menjunjung sportivitas,
                    kebersamaan, dan semangat kompetisi yang sehat.

                </p>

                {{-- DETAIL --}}
                <div class="mt-6 space-y-4">

                    <div class="flex items-center gap-3 text-gray-600">

                        <span>📅</span>

                        <span>Sabtu, 15 Maret 2026</span>

                    </div>

                    <div class="flex items-center gap-3 text-gray-600">

                        <span>🕒</span>

                        <span>08.00 - 17.00 WIB</span>

                    </div>

                    <div class="flex items-center gap-3 text-gray-600">

                        <span>📍</span>

                        <span>GOR Bandung</span>

                    </div>

                    <div class="flex items-center gap-3 text-gray-600">

                        <span>🎫</span>

                        <span>Ticket: 1x Early Bird</span>

                    </div>

                </div>

            </div>

        </div>

        {{-- TAB --}}
        <div class="mt-10 border-b border-gray-200">

            <div class="flex items-center gap-10">

                <button class="pb-4 border-b-2 border-[#7a4988] text-[#7a4988] font-semibold">
                    Deskripsi
                </button>

                <button class="pb-4 text-gray-500 hover:text-[#7a4988]">
                    Susunan Acara
                </button>

                <button class="pb-4 text-gray-500 hover:text-[#7a4988]">
                    Pembicara
                </button>

                <button class="pb-4 text-gray-500 hover:text-[#7a4988]">
                    Lokasi
                </button>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mt-6">

            <p class="text-gray-600 leading-relaxed">

                Turnamen ini menjadi wadah bagi para atlet untuk menunjukkan
                kemampuan terbaik mereka serta mempererat hubungan antar komunitas olahraga.

                Saksikan pertandingan seru dan dukung tim favorit Anda!

            </p>

            <h3 class="mt-8 text-xl font-bold text-[#7a4988]">
                Yang akan Anda dapatkan:
            </h3>

            <ul class="mt-5 space-y-4 text-gray-600">

                <li>✔️ Akses semua pertandingan</li>
                <li>✔️ Sertifikat partisipasi</li>
                <li>✔️ Souvenir eksklusif</li>
                <li>✔️ Doorprize menarik</li>
                <li>✔️ Fasilitas nyaman dan lengkap</li>

            </ul>

        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

            <h2 class="text-xl font-bold text-[#24112e] mb-6">
                Pilih Tiket
            </h2>

            {{-- EARLY BIRD --}}
            <div class="border-2 border-[#7a4988] rounded-2xl p-5 mb-4">

                <div class="flex items-start justify-between">

                    <div>

                        <div class="flex items-center gap-3">

                            <input type="radio" checked>

                            <span class="font-bold text-[#24112e]">
                                Early Bird
                            </span>

                        </div>

                        <h3 class="mt-2 text-2xl font-bold text-[#7a4988]">
                            Rp 100.000
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            Akses semua sesi
                        </p>

                    </div>

                    <span class="text-sm text-gray-400">
                        Sisa 50
                    </span>

                </div>

            </div>

            {{-- NORMAL --}}
            <div class="border border-gray-200 rounded-2xl p-5 mb-4">

                <div class="flex items-start justify-between">

                    <div>

                        <div class="flex items-center gap-3">

                            <input type="radio">

                            <span class="font-bold text-[#24112e]">
                                Normal
                            </span>

                        </div>

                        <h3 class="mt-2 text-2xl font-bold text-[#24112e]">
                            Rp 150.000
                        </h3>

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
            <div class="border border-gray-200 rounded-2xl p-5">

                <div class="flex items-start justify-between">

                    <div>

                        <div class="flex items-center gap-3">

                            <input type="radio">

                            <span class="font-bold text-[#24112e]">
                                VIP
                            </span>

                        </div>

                        <h3 class="mt-2 text-2xl font-bold text-[#24112e]">
                            Rp 250.000
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            Lunch & souvenir eksklusif
                        </p>

                    </div>

                    <span class="text-sm text-gray-400">
                        Sisa 30
                    </span>

                </div>

            </div>

            {{-- JUMLAH --}}
            <div class="mt-8">

                <label class="block text-sm font-semibold text-gray-600 mb-3">
                    Jumlah Tiket
                </label>

                <input type="number"
                       value="1"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#7a4988] focus:outline-none">

            </div>

            {{-- TOTAL --}}
            <div class="flex items-center justify-between mt-8">

                <span class="text-gray-600 font-semibold">
                    Total Pembayaran
                </span>

                <span class="text-2xl font-bold text-[#7a4988]">
                    Rp 100.000
                </span>

            </div>

            {{-- BUTTON --}}
            <button class="w-full mt-6 bg-[#7a4988] text-white py-4 rounded-xl font-bold hover:bg-[#693b76] transition">

                Beli Sekarang

            </button>

            {{-- TICKET --}}
            <div class="mt-6 border-2 border-dashed border-gray-300 rounded-2xl h-28 flex items-center justify-center text-gray-400">

                🎫 Ticket Preview

            </div>

        </div>

    </div>

</div>

@endsection