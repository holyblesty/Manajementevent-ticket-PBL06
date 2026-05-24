@extends('layouts.app')

@section('content')

<<<<<<< HEAD
<div>

    {{-- Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-purple-700">
            Halo, Jesina! 👋
        </h1>

        <p class="text-gray-500 mt-2">
            Selamat datang kembali! Temukan event menarik dan dapatkan pengalaman terbaik.
        </p>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-6 rounded-2xl shadow-sm border">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center text-purple-700 text-2xl">
                    <i class="fa-solid fa-ticket"></i>
                </div>

                <div>
                    <h3 class="text-gray-500 text-sm">
                        Ticket Saya
                    </h3>

                    <h1 class="text-3xl font-bold">
                        2
                    </h1>

                    <p class="text-gray-500 text-sm">
                        Ticket aktif
                    </p>
                </div>

            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 text-2xl">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div>
                    <h3 class="text-gray-500 text-sm">
                        Riwayat Pendaftaran
                    </h3>

                    <h1 class="text-3xl font-bold">
                        5
                    </h1>

                    <p class="text-gray-500 text-sm">
                        Event diikuti
                    </p>
                </div>

            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center text-green-700 text-2xl">
                    <i class="fa-solid fa-calendar"></i>
                </div>

                <div>
                    <h3 class="text-gray-500 text-sm">
                        Event Mendatang
                    </h3>

                    <h1 class="text-3xl font-bold">
                        3
                    </h1>

                    <p class="text-gray-500 text-sm">
                        Event terdaftar
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- Event --}}
    <div class="grid grid-cols-4 gap-6">

        {{-- Left --}}
        <div class="col-span-3">

            <div class="flex items-center justify-between mb-5">

                <h2 class="text-xl font-bold">
                    Event Rekomendasi Untuk Anda
                </h2>

                <a href="#" class="text-purple-700 font-medium">
                    Lihat semua
                </a>

            </div>

            <div class="grid grid-cols-3 gap-6">

                {{-- Card --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border">

                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=1200"
                         class="h-48 w-full object-cover">

                    <div class="p-5">

                        <span class="bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full">
                            Olahraga
                        </span>

                        <h3 class="font-bold text-lg mt-4">
                            TURNAMEN BASKET 2026
                        </h3>

                        <div class="space-y-2 mt-4 text-sm text-gray-500">

                            <p>
                                <i class="fa-solid fa-calendar mr-2"></i>
                                15 Maret 2026
                            </p>

                            <p>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                GOR Bandung
                            </p>

                        </div>

                        <div class="mt-5">

                            <p class="text-gray-400 text-sm">
                                Mulai dari
                            </p>

                            <h2 class="text-purple-700 text-2xl font-bold">
                                Rp 200.000
                            </h2>

                        </div>

                    </div>

                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border">

                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200"
                         class="h-48 w-full object-cover">

                    <div class="p-5">

                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                            Seminar
                        </span>

                        <h3 class="font-bold text-lg mt-4">
                            AI & MASA DEPAN
                        </h3>

                        <div class="space-y-2 mt-4 text-sm text-gray-500">

                            <p>
                                <i class="fa-solid fa-calendar mr-2"></i>
                                29 Mei 2026
                            </p>

                            <p>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                Bandung
                            </p>

                        </div>

                        <div class="mt-5">

                            <p class="text-gray-400 text-sm">
                                Mulai dari
                            </p>

                            <h2 class="text-purple-700 text-2xl font-bold">
                                Rp 150.000
                            </h2>

                        </div>

                    </div>

                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border">

                    <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=1200"
                         class="h-48 w-full object-cover">

                    <div class="p-5">

                        <span class="bg-pink-100 text-pink-700 text-xs px-3 py-1 rounded-full">
                            Hiburan
                        </span>

                        <h3 class="font-bold text-lg mt-4">
                            FESTIVAL BAND
                        </h3>

                        <div class="space-y-2 mt-4 text-sm text-gray-500">

                            <p>
                                <i class="fa-solid fa-calendar mr-2"></i>
                                31 Mei 2026
                            </p>

                            <p>
                                <i class="fa-solid fa-location-dot mr-2"></i>
                                Open Space
                            </p>

                        </div>

                        <div class="mt-5">

                            <p class="text-gray-400 text-sm">
                                Mulai dari
                            </p>

                            <h2 class="text-purple-700 text-2xl font-bold">
                                Rp 75.000
                            </h2>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div class="bg-white p-6 rounded-2xl border shadow-sm h-fit">

            <h3 class="font-bold text-lg mb-6">
                Kategori Event
            </h3>

            <div class="space-y-5">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-700">
                            <i class="fa-solid fa-basketball"></i>
                        </div>

                        <span>Olahraga</span>

                    </div>

                    <span class="text-gray-500">
                        12
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-700">
                            <i class="fa-solid fa-microphone"></i>
                        </div>

                        <span>Seminar</span>

                    </div>

                    <span class="text-gray-500">
                        18
                    </span>

                </div>

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center text-pink-700">
                            <i class="fa-solid fa-music"></i>
                        </div>

                        <span>Hiburan</span>

                    </div>

                    <span class="text-gray-500">
                        24
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

=======
<!-- HEADER -->
<div class="bg-gradient-to-r from-purple-700 to-purple-500 px-6 py-3 flex items-center justify-between text-white">

    <div class="font-bold text-lg">Event Ticket</div>

    <div class="flex items-center gap-2">
        <input type="text" placeholder="Mencari acara, kategori, atau lokasi"
            class="px-3 py-1 rounded text-black w-80">
        <button class="bg-white text-black px-3 py-1 rounded">Cari</button>
    </div>

    <div class="flex items-center gap-4">
        <a href="#">Beranda</a>
        <a href="#">Acara</a>
        <a href="#">Tentang kami</a>
        <button class="border px-3 py-1 rounded">Masuk</button>
        <button class="bg-white text-black px-3 py-1 rounded">Daftar</button>
    </div>
</div>

<!-- HERO -->
<div class="mx-6 mt-4 relative rounded-lg overflow-hidden">
    <img src="https://images.unsplash.com/photo-1515169067868-5387ec356754"
         class="w-full h-[300px] object-cover">

    <div class="absolute inset-0 bg-black/40 flex items-center justify-between px-10 text-white">
        <div>
            <h1 class="text-3xl font-bold">EVENT & TICKETING</h1>
            <p class="mt-2">Discover & Book Now!</p>
        </div>
        <button class="bg-white text-black px-6 py-2 rounded">BOOK NOW</button>
    </div>
</div>

<!-- KATEGORI -->
<div class="text-center mt-6">
    <h2 class="font-semibold">KATEGORI ACARA</h2>

    <div class="flex justify-center gap-10 mt-4">
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/69/69524.png"
                 class="w-16 h-16 mx-auto">
            <p class="mt-2">Olahraga</p>
        </div>
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/854/854894.png"
                 class="w-16 h-16 mx-auto">
            <p class="mt-2">Hiburan</p>
        </div>
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                 class="w-16 h-16 mx-auto">
            <p class="mt-2">Seminar</p>
        </div>
    </div>
</div>

<!-- EVENT -->
<div class="mx-6 mt-8">
    <h2 class="font-semibold mb-4">ACARA YANG SEDANG BERLANGSUNG</h2>

    <div class="grid grid-cols-4 gap-4">

        <!-- CARD -->
        @for ($i = 0; $i < 4; $i++)
        <div class="bg-white rounded shadow hover:shadow-lg transition">

            <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df"
                 class="w-full h-40 object-cover">

            <div class="p-3">
                <h3 class="font-medium">Digital Marketing Seminar</h3>
                <p class="text-sm text-gray-500">20 Mei, 18:00</p>
                <p class="text-sm text-gray-500">Batam</p>

                <button class="mt-2 border px-3 py-1 rounded hover-ungu">
                    Lihat Detail
                </button>
            </div>
        </div>
        @endfor

    </div>

    <div class="text-center mt-4">
        <button class="border px-4 py-2 rounded hover-ungu">
            Lihat Semua Acara
        </button>
    </div>
</div>

<!-- CTA -->
<div class="text-center mt-6">
    <p>Ingin membuat acara atau kegiatan baru?</p>
    <button class="bg-purple-600 text-white px-4 py-2 rounded mt-2 hover:bg-purple-800">
        Kontak kami
    </button>
</div>

<!-- FOOTER -->
<footer class="mt-10 bg-[#201132] text-white px-6 py-8">
    <div class="grid grid-cols-4 gap-6">

        <div>
            <h3 class="font-bold">Event Ticket</h3>
            <p class="text-sm text-gray-300 mt-2">
                Platform untuk menemukan dan memesan tiket event terbaik.
            </p>
        </div>

        <div>
            <h4 class="font-semibold mb-2">Navigasi</h4>
            <p>Beranda</p>
            <p>Acara</p>
            <p>Kontak</p>
        </div>

        <div>
            <h4 class="font-semibold mb-2">Bantuan</h4>
            <p>FAQ</p>
            <p>Kontak Kami</p>
            <p>Kebijakan</p>
        </div>

        <div>
            <h4 class="font-semibold mb-2">Ikuti Kami</h4>
            <p>Instagram</p>
            <p>Twitter</p>
            <p>Facebook</p>
        </div>

    </div>

    <div class="text-center text-sm text-gray-400 mt-6">
        © 2026 Event Ticketing System
    </div>
</footer>

>>>>>>> 889d72a19758b80bc3675b82d99414c2aa8680c4
@endsection