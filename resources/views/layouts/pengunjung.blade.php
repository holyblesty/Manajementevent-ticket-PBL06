<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 font-sans antialiased">

    {{-- ================= NAVBAR ================= --}}
    <header class="fixed top-0 z-50 w-full bg-white shadow-sm">

        <nav class="h-16 flex items-center justify-between px-8">

            {{-- LOGO --}}
            <div class="flex items-center gap-4">

                <img src="{{ asset('images/logo.jpeg') }}"
                     class="h-10">

            </div>

            {{-- SEARCH --}}
            <div class="hidden lg:flex items-center w-[420px]">

                <div class="relative w-full">

                    <input type="text"
                           placeholder="Cari event..."
                           class="w-full border border-gray-200 rounded-l-xl py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#7a4988] focus:outline-none">

                    <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>

                    </svg>

                </div>

                <button class="bg-[#7a4988] text-white px-5 py-2 rounded-r-xl text-sm font-semibold hover:bg-[#693b76]">
                    Cari
                </button>

            </div>

            {{-- MENU --}}
            <div class="flex items-center gap-8">

                <a href="#" class="text-sm font-semibold text-gray-700 hover:text-[#7a4988] no-underline">
                    Beranda
                </a>

                <a href="#" class="text-sm font-semibold text-gray-700 hover:text-[#7a4988] no-underline">
                    Acara
                </a>

                <a href="#" class="text-sm font-semibold text-gray-700 hover:text-[#7a4988] no-underline">
                    Tentang kami
                </a>

               @auth

<div class="flex items-center gap-3 border-l pl-6">

    <div class="flex items-center gap-3">

        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-[#7a4988]">

            <img src="{{ asset('images/profile-user.jpg') }}"
                 class="w-full h-full object-cover">

        </div>

        <div>

            <p class="text-sm font-bold text-[#24112e]">
                {{ Auth::user()->name }}
            </p>

            <p class="text-xs text-[#7a4988]">
                Pengunjung
            </p>

        </div>

    </div>

</div>

@endauth

@guest

<div class="flex items-center gap-3 border-l pl-6">

    <button class="px-5 py-2 rounded-lg text-xs font-bold bg-[#2b1238] text-white hover:bg-[#1c0c25]">
        Masuk
    </button>

    <button class="px-5 py-2 rounded-lg text-xs font-bold bg-[#be93d4] text-[#2b1238] hover:bg-[#a97bc2]">
        Daftar
    </button>

</div>

@endguest

            </div>

        </nav>

        <div class="w-full h-1 bg-[#7a4988]"></div>

    </header>

    {{-- ================= CONTENT ================= --}}
    <div class="flex pt-16">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="fixed left-0 top-16 w-64 h-screen bg-white border-r border-gray-200 py-8 flex flex-col">

            {{-- PROFILE --}}
            <div class="flex flex-col items-center">

                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#7a4988] shadow-md">

                    <img src="{{ asset('images/profile-user.jpg') }}"
                         class="w-full h-full object-cover">

                </div>

                <h2 class="mt-4 text-lg font-bold text-[#24112e]">
                    Sisi
                </h2>

                <p class="text-sm text-[#7a4988] font-medium">
                    Pengunjung
                </p>

            </div>

            {{-- MENU --}}
            <nav class="mt-10 px-4 space-y-2">

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#f3ebf8] text-[#7a4988] font-semibold no-underline">

                    🏠 Beranda

                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-[#f9f5fc] hover:text-[#7a4988] no-underline">

                    🎫 Ticket Saya

                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-[#f9f5fc] hover:text-[#7a4988] no-underline">

                    🕒 Riwayat Pendaftaran

                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-[#f9f5fc] hover:text-[#7a4988] no-underline">

                    👤 Profil

                </a>

                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-500 no-underline">

                    🚪 Keluar

                </a>

            </nav>

        </aside>

        {{-- ================= MAIN ================= --}}
        <main class="flex-1 ml-64 p-8 bg-gray-50 min-h-screen">

            @yield('content')

        </main>

    </div>

    {{-- ================= FOOTER ================= --}}
    <footer class="ml-64 bg-[#24112e] text-white px-10 py-10">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- LOGO --}}
            <div>

                <img src="{{ asset('images/footer.jpg') }}"
                     class="h-20 mb-4">

                <p class="text-gray-300 text-sm leading-relaxed">
                    EventTicketing adalah platform untuk menemukan dan memesan tiket event terbaik dengan mudah dan cepat.
                </p>

            </div>

            {{-- NAVIGASI --}}
            <div>

                <h3 class="text-[#be93d4] font-bold mb-4 uppercase">
                    Navigasi
                </h3>

                <ul class="space-y-2 text-gray-300">

                    <li>Beranda</li>
                    <li>Acara</li>
                    <li>Tentang Kami</li>
                    <li>Kontak Kami</li>

                </ul>

            </div>

            {{-- KATEGORI --}}
            <div>

                <h3 class="text-[#be93d4] font-bold mb-4 uppercase">
                    Kategori
                </h3>

                <ul class="space-y-2 text-gray-300">

                    <li>Olahraga</li>
                    <li>Seminar</li>
                    <li>Hiburan</li>

                </ul>

            </div>

            {{-- KONTAK --}}
            <div>

                <h3 class="text-[#be93d4] font-bold mb-4 uppercase">
                    Hubungi Kami
                </h3>

                <ul class="space-y-3 text-gray-300">

                    <li>📧 Sisi@gmail.com</li>
                    <li>📞 +62 895 3128 7505</li>

                </ul>

            </div>

        </div>

        <div class="border-t border-white/10 mt-8 pt-4 text-center text-gray-400 text-sm">

            © 2026 Event Ticketing System | All Rights Reserved

        </div>

    </footer>