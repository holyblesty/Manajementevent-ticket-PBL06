<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Event Ticket - Event & Ticketing')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:  { DEFAULT: '#6B21A8', light: '#7C3AED', dark: '#4C1D95' },
                        purple:   { 50:'#faf5ff', 100:'#f3e8ff', 200:'#e9d5ff', 300:'#d8b4fe', 400:'#c084fc', 500:'#a855f7', 600:'#9333ea', 700:'#7e22ce', 800:'#6b21a8', 900:'#581c87' },
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-purple-50 hover:text-purple-700 transition-all duration-200 font-medium; }
        .sidebar-link.active { @apply bg-purple-100 text-purple-700 font-semibold; }
        .btn-primary { @apply bg-purple-800 hover:bg-purple-900 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 w-full text-center block; }
        .btn-outline { @apply border-2 border-purple-800 text-purple-800 hover:bg-purple-50 font-semibold py-3 px-6 rounded-xl transition-all duration-200 w-full text-center block; }
        .input-field { @apply w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all; }
        .card { @apply bg-white rounded-2xl border border-gray-200 shadow-sm; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- TOP NAVBAR --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-screen-xl mx-auto px-6 h-16 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('pengunjung.beranda') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-500 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-ticket text-white text-lg"></i>
                </div>
                <div class="leading-tight">
                    <p class="font-bold text-purple-800 text-base leading-none">Event Ticket</p>
                    <p class="text-xs text-gray-500 font-medium tracking-wide">EVENT & TICKETING</p>
                </div>
            </a>

            {{-- Search --}}
            <form action="{{ route('pengunjung.acara') }}" method="GET" class="hidden md:flex items-center gap-2 flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" placeholder="Cari event..."
                        value="{{ request('search') }}"
                        class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <button type="submit" class="bg-purple-800 hover:bg-purple-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    Cari
                </button>
            </form>

            {{-- Nav Links --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('pengunjung.beranda') }}"
                    class="text-sm font-medium {{ request()->routeIs('pengunjung.beranda') ? 'text-purple-800 font-bold' : 'text-gray-600 hover:text-purple-800' }} transition-colors">
                    Beranda
                </a>
                <a href="{{ route('pengunjung.acara') }}"
                    class="text-sm font-medium {{ request()->routeIs('pengunjung.acara*') ? 'text-purple-800 font-bold' : 'text-gray-600 hover:text-purple-800' }} transition-colors">
                    Acara
                </a>
                <a href="{{ route('pengunjung.tentang') }}"
                    class="text-sm font-medium {{ request()->routeIs('pengunjung.tentang-kami') ? 'text-purple-800 font-bold' : 'text-gray-600 hover:text-purple-800' }} transition-colors">
                    Tentang kami
                </a>

                @guest
                    <a href="{{ route('login') }}" class="bg-purple-800 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-purple-900 transition-all">
                        Masuk
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- PURPLE ACCENT BAR --}}
    <div class="h-1 bg-gradient-to-r from-purple-800 via-purple-600 to-pink-500"></div>

    {{-- MAIN LAYOUT --}}
    <div class="max-w-screen-xl mx-auto px-6 py-8">
        <div class="flex gap-8">

            {{-- SIDEBAR --}}
            @auth
            <aside class="w-64 flex-shrink-0">
                <div class="card p-5 sticky top-24">

                    {{-- User Profile --}}
                    <div class="flex flex-col items-center text-center mb-6 pb-6 border-b border-gray-100">
                        <div class="w-20 h-20 rounded-full overflow-hidden bg-purple-100 mb-3 ring-4 ring-purple-200">
                            @if(Auth::user()->foto)
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-purple-100">
                                    <span class="text-2xl font-bold text-purple-700">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <p class="font-bold text-gray-800 text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 capitalize">{{ Auth::user()->role }}</p>
                    </div>

                    {{-- Nav Menu --}}
                    <nav class="space-y-1">
                        <a href="{{ route('pengunjung.beranda') }}"
                            class="sidebar-link {{ request()->routeIs('pengunjung.beranda') ? 'active' : '' }}">
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('pengunjung.tiket-saya') }}"
                            class="sidebar-link {{ request()->routeIs('pengunjung.tiket-saya') ? 'active' : '' }}">
                            <i class="fa-solid fa-ticket w-5 text-center"></i>
                            <span>Tiket Saya</span>
                        </a>
                        <a href="{{ route('pengunjung.riwayat') }}"
                            class="sidebar-link {{ request()->routeIs('pengunjung.riwayat') ? 'active' : '' }}">
                            <i class="fa-regular fa-clock w-5 text-center"></i>
                            <span>Riwayat Pendaftaran</span>
                        </a>
                        <a href="{{ route('pengunjung.profil') }}"
                            class="sidebar-link {{ request()->routeIs('pengunjung.profil') ? 'active' : '' }}">
                            <i class="fa-regular fa-user w-5 text-center"></i>
                            <span>Profil</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit"
                                class="sidebar-link w-full text-left text-red-500 hover:bg-red-50 hover:text-red-600">
                                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>
            @endauth

            {{-- MAIN CONTENT --}}
            <main class="flex-1 min-w-0">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-green-500"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="bg-purple-950 text-white mt-16">
        <div class="max-w-screen-xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- Brand --}}
                <div class="col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-ticket text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-base leading-none">Event Ticket</p>
                            <p class="text-xs text-purple-300 font-medium tracking-wide">EVENT & TICKETING</p>
                        </div>
                    </div>
                    <p class="text-sm text-purple-200 leading-relaxed">
                        EventTicketing adalah platform untuk menemukan dan memesan tiket event terbaik dengan mudah dan cepat.
                    </p>
                </div>

                {{-- Navigasi --}}
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-widest mb-4 text-purple-300">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-purple-200">
                        <li><a href="{{ route('pengunjung.beranda') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('pengunjung.acara') }}" class="hover:text-white transition-colors">Acara</a></li>
                        <li><a href="{{ route('pengunjung.tentang') }}" class="hover:text-white transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>

                {{-- Kategori --}}
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-widest mb-4 text-purple-300">Kategori</h4>
                    <ul class="space-y-2 text-sm text-purple-200">
                        <li><a href="{{ route('pengunjung.acara', ['kategori' => 'Hiburan']) }}" class="hover:text-white transition-colors">Hiburan</a></li>
                        <li><a href="{{ route('pengunjung.acara', ['kategori' => 'Olahraga']) }}" class="hover:text-white transition-colors">Olahraga</a></li>
                        <li><a href="{{ route('pengunjung.acara', ['kategori' => 'Seminar']) }}" class="hover:text-white transition-colors">Seminar</a></li>
                    </ul>
                </div>

                {{-- Hubungi Kami --}}
                <div>
                    <h4 class="font-bold text-sm uppercase tracking-widest mb-4 text-purple-300">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-purple-200">
                        <li class="flex items-center gap-2">
                            <i class="fa-regular fa-envelope"></i>
                            <span>Jesinaaa@appmail.com</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone"></i>
                            <span>+62 896 3128 7605</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-purple-900 py-4">
            <p class="text-center text-xs text-purple-400">
                © 2026 Event Ticketing System. All Rights Reserved
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>