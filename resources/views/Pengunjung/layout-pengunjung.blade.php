{{-- resources/views/layouts/pengunjung.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Ticket') - Event Ticketing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom warna sesuai palette mockup */
        :root {
            --purple-deep:    #2b1238;
            --purple-darker:  #24112e;
            --purple-medium:  #7a4988;
            --purple-dark:    #4b1d52;
            --purple-lavender:#9e7bb5;
            --purple-search:  #5e007d;
            --purple-thead:   #7c2f84;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    {{-- ============================== NAVBAR ============================== --}}
    <header class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-sm h-16 flex items-center px-6">

        {{-- Logo --}}
        <a href="{{ route('beranda') ?? '/' }}" class="flex items-center gap-2 min-w-[180px]">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                 style="background: linear-gradient(135deg, #7c2f84, #2b1238);">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <div class="leading-none">
                <p class="text-sm font-extrabold text-purple-800 tracking-tight">Event Ticket</p>
                <p class="text-[10px] text-gray-400 font-medium tracking-widest uppercase">Event & Ticketing</p>
            </div>
        </a>

        {{-- Search Bar --}}
        <div class="flex-1 flex justify-center px-8">
            <div class="flex items-center gap-0 w-full max-w-md">
                <div class="flex items-center gap-2 border border-gray-300 rounded-l-lg px-3 py-2 flex-1 bg-white">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           placeholder="Cari event..."
                           class="flex-1 text-sm outline-none bg-transparent text-gray-700 placeholder-gray-400">
                </div>
                <button class="px-5 py-2 rounded-r-lg text-white text-sm font-semibold transition hover:opacity-90"
                        style="background-color: #7c2f84;">
                    Cari
                </button>
            </div>
        </div>

        {{-- Nav Links --}}
        <nav class="flex items-center gap-6 text-sm font-medium text-gray-700">
            <a href="{{ route('beranda') ?? '/' }}"
               class="hover:text-purple-700 transition {{ request()->routeIs('beranda') ? 'text-purple-700 font-semibold' : '' }}">
                Beranda
            </a>
            <a href="{{ route('acara') ?? '/acara' }}"
               class="hover:text-purple-700 transition {{ request()->routeIs('acara*') ? 'text-purple-700 font-semibold' : '' }}">
                Acara
            </a>
            <a href="{{ route('tentang') ?? '/tentang' }}"
               class="hover:text-purple-700 transition {{ request()->routeIs('tentang*') ? 'text-purple-700 font-semibold' : '' }}">
                Tentang kami
            </a>
        </nav>

    </header>

    {{-- Spacer untuk fixed header --}}
    <div class="h-16"></div>

    {{-- ============================== KONTEN ============================== --}}
    @yield('content')

    {{-- ============================== FOOTER ============================== --}}
    <footer style="background-color: #2b1238;">
        <div class="max-w-7xl mx-auto px-8 py-10">
            <div class="grid grid-cols-4 gap-8">

                {{-- Kolom 1: Brand --}}
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                             style="background: linear-gradient(135deg, #7c2f84, #4b1d52);">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                        </div>
                        <div class="leading-none">
                            <p class="text-sm font-extrabold text-white tracking-tight">Event Ticket</p>
                            <p class="text-[10px] text-purple-300 font-medium tracking-widest uppercase">Event & Ticketing</p>
                        </div>
                    </div>
                    <p class="text-xs text-purple-200 leading-relaxed mt-1">
                        EventTicketing adalah platform untuk menemukan dan memesan tiket event terbaik dengan mudah dan cepat.
                    </p>
                </div>

                {{-- Kolom 2: Navigasi --}}
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 tracking-wide">NAVIGASI</h4>
                    <ul class="space-y-2">
                        @foreach(['Beranda', 'Acara', 'Tentang Kami', 'Kontak Kami'] as $nav)
                        <li>
                            <a href="#" class="text-purple-200 text-xs hover:text-white transition">{{ $nav }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Kolom 3: Kategori --}}
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 tracking-wide">KATEGORI</h4>
                    <ul class="space-y-2">
                        @foreach(['Hiburan', 'Olahraga', 'Seminar'] as $kat)
                        <li>
                            <a href="#" class="text-purple-200 text-xs hover:text-white transition">{{ $kat }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Kolom 4: Hubungi --}}
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 tracking-wide">HUBUNGI KAMI</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-purple-200 text-xs">Jesinaaa@appmail.com</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-purple-200 text-xs">+62 896 3128 7605</span>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Garis & Copyright --}}
            <div class="border-t mt-8 pt-5" style="border-color: #4b1d52;">
                <p class="text-center text-xs text-purple-300">
                    &copy; 2026 Event Ticketing System. All Rights Reserved
                </p>
            </div>
        </div>
    </footer>

</body>
</html>