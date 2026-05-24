@extends('layouts.app')

@section('content')

<div>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-5">

        <span>Beranda</span>

        <i class="fa-solid fa-chevron-right text-xs"></i>

        <span class="text-purple-700 font-medium">
            Event
        </span>

    </div>

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-4xl font-bold text-purple-700">
            Semua Event
        </h1>

        <p class="text-gray-500 mt-2">
            Temukan berbagai event menarik yang bisa kamu ikuti.
        </p>

    </div>

    {{-- Filter --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border mb-8">

        <div class="grid grid-cols-4 gap-5">

            {{-- Search --}}
            <div class="col-span-2">

                <div class="relative">

                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-gray-400"></i>

                    <input type="text"
                           placeholder="Cari event berdasarkan judul..."
                           class="w-full border rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

                </div>

            </div>

            {{-- Category --}}
            <div>

                <select class="w-full border rounded-xl py-3 px-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

                    <option>Semua Kategori</option>
                    <option>Olahraga</option>
                    <option>Seminar</option>
                    <option>Hiburan</option>

                </select>

            </div>

            {{-- Button --}}
            <div>

                <button class="w-full border rounded-xl py-3 font-medium hover:bg-gray-100 transition">
                    <i class="fa-solid fa-rotate-right mr-2"></i>
                    Reset Filter
                </button>

            </div>

        </div>

    </div>

    {{-- Category Tabs --}}
    <div class="flex items-center gap-3 mb-8">

        <button class="bg-purple-700 text-white px-5 py-2 rounded-xl font-medium">
            Semua
        </button>

        <button class="border px-5 py-2 rounded-xl hover:bg-purple-50">
            Olahraga
        </button>

        <button class="border px-5 py-2 rounded-xl hover:bg-purple-50">
            Seminar
        </button>

        <button class="border px-5 py-2 rounded-xl hover:bg-purple-50">
            Hiburan
        </button>

    </div>

    {{-- Event Grid --}}
    <div class="grid grid-cols-4 gap-6">

        {{-- CARD 1 --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border hover:shadow-lg transition">

            <div class="relative">

                <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200"
                     class="w-full h-52 object-cover">

                <div class="absolute top-4 left-4">

                    <span class="bg-purple-700 text-white text-xs px-3 py-1 rounded-full">
                        Seminar
                    </span>

                </div>

            </div>

            <div class="p-5">

                <h2 class="font-bold text-xl leading-8 mb-4">
                    AI & MASA DEPAN KITA TECH FORUM 2026
                </h2>

                <div class="space-y-3 text-sm text-gray-500">

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-calendar text-purple-700"></i>

                        <span>29 Mei 2026</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-clock text-purple-700"></i>

                        <span>09.00 - 17.00 WIB</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-location-dot text-purple-700"></i>

                        <span>Gedung Utama, Bandung</span>

                    </div>

                </div>

                <div class="mt-5">

                    <p class="text-sm text-gray-400">
                        Mulai dari
                    </p>

                    <h3 class="text-2xl font-bold text-purple-700">
                        Rp 150.000
                    </h3>

                </div>

                <button class="w-full mt-6 border-2 border-purple-700 text-purple-700 py-3 rounded-xl font-semibold hover:bg-purple-700 hover:text-white transition">
                    Lihat Detail
                </button>

            </div>

        </div>

        {{-- CARD 2 --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border hover:shadow-lg transition">

            <div class="relative">

                <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1200"
                     class="w-full h-52 object-cover">

                <div class="absolute top-4 left-4">

                    <span class="bg-blue-700 text-white text-xs px-3 py-1 rounded-full">
                        Olahraga
                    </span>

                </div>

            </div>

            <div class="p-5">

                <h2 class="font-bold text-xl leading-8 mb-4">
                    FUTSAL KAMPUS CHAMPIONSHIP 2026
                </h2>

                <div class="space-y-3 text-sm text-gray-500">

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-calendar text-purple-700"></i>

                        <span>30 Mei 2026</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-clock text-purple-700"></i>

                        <span>08.00 - 18.00 WIB</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-location-dot text-purple-700"></i>

                        <span>Lapangan Politeknik Bandung</span>

                    </div>

                </div>

                <div class="mt-5">

                    <p class="text-sm text-gray-400">
                        Mulai dari
                    </p>

                    <h3 class="text-2xl font-bold text-purple-700">
                        Rp 100.000
                    </h3>

                </div>

                <a href="/events/show"
                    class="block text-center w-full mt-6 border-2 border-purple-700 text-purple-700 py-3 rounded-xl font-semibold hover:bg-purple-700 hover:text-white transition">
                         Lihat Detail
                </a>
                </button>

            </div>

        </div>

        {{-- CARD 3 --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border hover:shadow-lg transition">

            <div class="relative">

                <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=1200"
                     class="w-full h-52 object-cover">

                <div class="absolute top-4 left-4">

                    <span class="bg-pink-600 text-white text-xs px-3 py-1 rounded-full">
                        Hiburan
                    </span>

                </div>

            </div>

            <div class="p-5">

                <h2 class="font-bold text-xl leading-8 mb-4">
                    FESTIVAL BAND MAHASISWA 2026
                </h2>

                <div class="space-y-3 text-sm text-gray-500">

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-calendar text-purple-700"></i>

                        <span>31 Mei 2026</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-clock text-purple-700"></i>

                        <span>17.00 - 22.00 WIB</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-location-dot text-purple-700"></i>

                        <span>Open Space, Bandung</span>

                    </div>

                </div>

                <div class="mt-5">

                    <p class="text-sm text-gray-400">
                        Mulai dari
                    </p>

                    <h3 class="text-2xl font-bold text-purple-700">
                        Rp 75.000
                    </h3>

                </div>

                <button class="w-full mt-6 border-2 border-purple-700 text-purple-700 py-3 rounded-xl font-semibold hover:bg-purple-700 hover:text-white transition">
                    Lihat Detail
                </button>

            </div>

        </div>

        {{-- CARD 4 --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border hover:shadow-lg transition">

            <div class="relative">

                <img src="https://images.unsplash.com/photo-1515169067868-5387ec356754?q=80&w=1200"
                     class="w-full h-52 object-cover">

                <div class="absolute top-4 left-4">

                    <span class="bg-purple-700 text-white text-xs px-3 py-1 rounded-full">
                        Seminar
                    </span>

                </div>

            </div>

            <div class="p-5">

                <h2 class="font-bold text-xl leading-8 mb-4">
                    CREATIVEPRENEUR FEST 2026
                </h2>

                <div class="space-y-3 text-sm text-gray-500">

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-calendar text-purple-700"></i>

                        <span>10 Juni 2026</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-clock text-purple-700"></i>

                        <span>10.00 - 18.00 WIB</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="fa-solid fa-location-dot text-purple-700"></i>

                        <span>Eldorado Dome, Bandung</span>

                    </div>

                </div>

                <div class="mt-5">

                    <p class="text-sm text-gray-400">
                        Mulai dari
                    </p>

                    <h3 class="text-2xl font-bold text-purple-700">
                        Rp 125.000
                    </h3>

                </div>

                <button class="w-full mt-6 border-2 border-purple-700 text-purple-700 py-3 rounded-xl font-semibold hover:bg-purple-700 hover:text-white transition">
                    Lihat Detail
                </button>

            </div>

        </div>

    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-center gap-3 mt-12">

        <button class="w-10 h-10 border rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <button class="w-10 h-10 bg-purple-700 text-white rounded-lg">
            1
        </button>

        <button class="w-10 h-10 border rounded-lg hover:bg-gray-100">
            2
        </button>

        <button class="w-10 h-10 border rounded-lg hover:bg-gray-100">
            3
        </button>

        <button class="w-10 h-10 border rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>

</div>

@endsection