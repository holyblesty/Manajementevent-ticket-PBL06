@extends('layouts.app')

@section('content')

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

@endsection