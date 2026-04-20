<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - EventTicket</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Flowbite CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   { DEFAULT: '#7C3AED', dark: '#5B21B6', light: '#A78BFA' },
                        sidebar:   '#F3F4F6',
                        headerBg:  '#7C3AED',
                    },
                    fontFamily: {
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Gradient header admin */
        .admin-header-bg {
            background: linear-gradient(135deg, #7C3AED 0%, #9333EA 50%, #C026D3 100%);
        }

        /* Sidebar active */
        .sidebar-active {
            background: #7C3AED;
            color: #ffffff !important;
            border-radius: 8px;
        }
        .sidebar-active svg { color: #ffffff !important; }

        /* Navbar top */
        .navbar-top {
            background: linear-gradient(90deg, #7C3AED, #9333EA, #C026D3);
        }

        /* Table header */
        .table-header { background: linear-gradient(90deg, #7C3AED, #A855F7); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #9333EA; border-radius: 3px; }
    </style>

    @stack('styles')
</head>
<body class="bg-purple-50 min-h-screen font-jakarta">

    {{-- ===== TOP NAVBAR ===== --}}
    <nav class="navbar-top fixed top-0 left-0 right-0 z-50 px-6 py-2.5 flex items-center justify-between shadow-lg">
        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span class="text-white font-bold text-sm hidden sm:block">EventTicket</span>
        </div>

        {{-- Nav Links --}}
        <div class="flex items-center gap-6">
            <a href="#" class="text-white/90 hover:text-white text-sm font-medium transition">Beranda</a>
            <a href="#" class="text-white/90 hover:text-white text-sm font-medium transition">Acara</a>
            <a href="#" class="text-white/90 hover:text-white text-sm font-medium transition">Tentang kami</a>
        </div>

        {{-- Right Icons --}}
        <div class="flex items-center gap-3">
            <button class="text-white/80 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
            <a href="#" class="bg-white/20 hover:bg-white/30 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition border border-white/30">
                Keluar
            </a>
        </div>
    </nav>

    {{-- ===== MAIN LAYOUT ===== --}}
    <div class="pt-14 flex min-h-screen">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-52 min-h-[calc(100vh-3.5rem)] bg-white shadow-md flex flex-col fixed left-0 top-14 bottom-0 z-40">

            {{-- Profile Section --}}
            <div class="admin-header-bg px-4 py-5 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-white/20 border-2 border-white/50 flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-white/70">WELCOME</p>
                        <p class="font-bold text-sm">ADMIN</p>
                    </div>
                </div>
            </div>

            {{-- Nav Items --}}
            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('admin.acara.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-semibold transition
                          {{ request()->routeIs('admin.acara.*') ? 'sidebar-active' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700 rounded-lg' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    KELOLA ACARA
                </a>

                <a href="#"
                   class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-gray-600 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    KELOLA PESERTA
                </a>

                <a href="#"
                   class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-gray-600 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    STATISTIK
                </a>
            </nav>

            {{-- Logo Bottom --}}
            <div class="px-4 py-4 border-t border-gray-100 flex justify-center">
                <div class="text-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-fuchsia-500 rounded-xl mx-auto flex items-center justify-center mb-1 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <p class="text-[10px] font-bold text-purple-700 leading-none">EventTicket</p>
                    <p class="text-[8px] text-gray-400">EVENT & TICKETING</p>
                </div>
            </div>
        </aside>

        {{-- ===== CONTENT AREA ===== --}}
        <main class="ml-52 flex-1 flex flex-col min-h-[calc(100vh-3.5rem)]">

            {{-- Page Content --}}
            <div class="flex-1">
                @yield('content')
            </div>

            {{-- ===== FOOTER ===== --}}
            <footer class="bg-gray-900 text-white mt-auto">
                <div class="max-w-full px-8 py-8">
                    <div class="grid grid-cols-4 gap-8">
                        {{-- Brand --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-fuchsia-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">EventTicket</p>
                                    <p class="text-[9px] text-gray-400">EVENT & TICKETING</p>
                                </div>
                            </div>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                Event&Ticketing adalah platform untuk menemukan dan memesan tiket event terbaik dengan mudah dan cepat.
                            </p>
                        </div>

                        {{-- Navigasi --}}
                        <div>
                            <h4 class="font-bold text-sm mb-3 text-purple-300">NAVIGASI</h4>
                            <ul class="space-y-1.5 text-xs text-gray-400">
                                <li><a href="#" class="hover:text-white transition">Beranda</a></li>
                                <li><a href="#" class="hover:text-white transition">Acara</a></li>
                                <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                                <li><a href="#" class="hover:text-white transition">Kontak Kami</a></li>
                            </ul>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <h4 class="font-bold text-sm mb-3 text-purple-300">KATEGORI</h4>
                            <ul class="space-y-1.5 text-xs text-gray-400">
                                <li><a href="#" class="hover:text-white transition">Hiburan</a></li>
                                <li><a href="#" class="hover:text-white transition">Olahraga</a></li>
                                <li><a href="#" class="hover:text-white transition">Seminar</a></li>
                            </ul>
                        </div>

                        {{-- Hubungi Kami --}}
                        <div>
                            <h4 class="font-bold text-sm mb-3 text-purple-300">HUBUNGI KAMI</h4>
                            <ul class="space-y-1.5 text-xs text-gray-400">
                                <li class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a href="mailto:Jeshasaurora@gmail.com" class="hover:text-white transition">Jeshasaurora@gmail.com</a>
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    +62 895 3128 7505
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 mt-6 pt-4 text-center text-xs text-gray-500">
                        © 2026 Event Ticketing System | All Rights Reserved
                    </div>
                </div>
            </footer>
        </main>
    </div>

    {{-- Flowbite JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    @stack('scripts')
</body>
</html>