<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EventTicket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 h-full">

    {{-- Wrapper Utama --}}
    <div class="flex min-h-screen w-full !overflow-visible">

        {{-- TOP NAVIGATION HEADER --}}
        <header class="fixed top-0 z-50 w-full shadow-sm">
            <nav class="w-full bg-white h-16 flex items-center justify-between px-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-12 w-auto">
                </div>
                <div class="flex items-center space-x-6 text-sm font-semibold">
                    <a href="#" class="transition-colors text-gray-600 hover:text-[#7a4988]" style="text-decoration: none !important;">Beranda</a>
                    <a href="#" class="transition-colors text-gray-600 hover:text-[#7a4988]" style="text-decoration: none !important;">Acara</a>
                    <a href="#" class="transition-colors text-gray-600 hover:text-[#7a4988]" style="text-decoration: none !important;">Tentang kami</a>
                    
                    <div class="flex items-center space-x-3 border-l border-gray-200 pl-6">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-lg text-xs font-black transition uppercase shadow-sm bg-[#be93d4] text-[#2b1238] hover:bg-[#9e7bb5]" style="border: none; cursor: pointer;">Keluar</button>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="w-full bg-[#7a4988] h-1"></div>
        </header>

        {{-- SIDEBAR KIRI --}}
        <aside class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-64px)] bg-white border-r border-gray-200 flex flex-col justify-between py-6">
            <div class="w-full">
                {{-- FOTO PROFIL (FIXED: Mengambil data langsung dari Database) --}}
                @php $admin = Auth::guard('admin')->user(); @endphp
                <a href="{{ route('admin.profile') }}" class="flex flex-col items-center mb-6 no-underline group">
                    <div class="w-36 h-36 rounded-full border-4 border-[#7a4988] overflow-hidden shadow-md transition-all duration-300 group-hover:scale-105">
                        <img src="{{ ($admin && $admin->foto) ? asset('images/' . $admin->foto) : asset('images/profile_default.jpg') }}" 
                             alt="Admin"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($admin->username ?? 'Admin') }}&color=ffffff&background=7a4988';"
                             class="w-full h-full object-cover">
                    </div>

                    <h3 class="mt-3 text-[#24112e] font-black text-xs uppercase tracking-wider text-center group-hover:text-[#7a4988] transition-colors">
                        {{ $admin->username ?? 'Admin' }}
                    </h3>
                    <span class="text-xs text-gray-500 mt-1 font-semibold">Edit Profile</span>
                </a>
                
                {{-- NAVIGASI SIDEBAR --}}
                <nav class="w-full space-y-2 px-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 rounded-xl font-bold text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#7a4988] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}" style="text-decoration: none !important;">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                        KELOLA ACARA
                    </a>

                    <a href="{{ route('admin.peserta.index') }}" class="flex items-center px-4 py-3.5 rounded-xl font-bold text-sm transition {{ request()->routeIs('admin.peserta.*') ? 'bg-[#7a4988] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}" style="text-decoration: none !important;">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                        KELOLA PESERTA
                    </a>

                    <a href="{{ route('admin.statistik') }}" class="flex items-center px-4 py-3.5 rounded-xl font-bold text-sm transition {{ request()->routeIs('admin.statistik') ? 'bg-[#7a4988] text-white shadow-md' : 'text-gray-600 hover:bg-gray-50' }}" style="text-decoration: none !important;">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                        STATISTIK
                    </a>
                </nav>
            </div>
            <div class="w-full flex justify-center px-4">
                <img src="{{ asset('images/logo1.jpeg') }}" class="h-24 w-auto object-contain">
            </div>
        </aside>

        {{-- AREA KANAN --}}
        <div class="flex-1 min-w-0 ml-64 mt-16 p-8 bg-gray-50 flex flex-col justify-between min-h-[calc(100vh-64px)] !overflow-visible">
            @if(session('success'))
            <div class="flex items-center p-4 mb-6 text-green-800 rounded-2xl bg-green-50 border border-green-100 shadow-sm" role="alert">
                <div class="ms-3 text-xs font-black uppercase tracking-wider">{{ session('success') }}</div>
            </div>
            @endif

            <main class="flex-grow !overflow-visible">
                @yield('content')
            </main>

                 {{-- FOOTER --}}
            <footer class="mt-12 bg-[#24112e] rounded-3xl p-8 text-white shadow-xl flex-shrink-0">
                <div class="flex flex-col md:flex-row items-start justify-between gap-8">
                    <div class="md:w-[35%]">
                        <div class="flex items-center gap-5 mb-4">
                            <img src="{{ asset('images/footer.jpg') }}" class="h-35 w-auto object-cover rounded-xl">
                            <div class="flex-grow">
                                <h3 class="text-base font-black tracking-tighter text-[#be93d4] mb-1 uppercase">Event&Ticketing</h3>
                                <p class="text-[20px] text-gray-300 leading-relaxed font-medium">
                                     adalah platform untuk menemukan <br>dan memesan tiket event terbaik dengan<br> mudah dan cepat.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-[15%] md:border-l md:border-white/10 md:pl-8 py-1">
                        <h4 class="text-white font-bold text-[9px] mb-3 uppercase tracking-[0.2em] opacity-50">Navigasi</h4>
                        <ul class="text-[20px] space-y-2 text-gray-400 font-medium">
                            <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Beranda</a></li>
                            <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Acara</a></li>
                            <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Tentang Kami</a></li>
                        </ul>
                    </div>

                    <div class="md:w-[15%] md:border-l md:border-white/10 md:pl-8 py-1">
                        <h4 class="text-white font-bold text-[9px] mb-3 uppercase tracking-[0.2em] opacity-50">Kategori</h4>
                        <ul class="text-[20px] space-y-2 text-gray-400 font-medium">
                            <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Hiburan</a></li>
                            <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Olahraga</a></li>
                            <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Seminar</a></li>
                        </ul>
                    </div>

                    <div class="md:w-[25%] md:border-l md:border-white/10 md:pl-8 py-1">
                        <h4 class="text-white font-bold text-[9px] mb-3 uppercase tracking-[0.2em] opacity-50">Hubungi Kami</h4>
                        <ul class="text-[20px] space-y-2 text-gray-400 font-medium">
                            <li class="flex items-center gap-2.5">
                                <svg class="w-3.5 h-3.5 text-[#be93d4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Jesinaaurora@gmail.com
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-3.5 h-3.5 text-[#be93d4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                +62 895 3128 7505
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-white/5 mt-8 pt-4 text-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                        © 2026 Event Ticketing System | All Rights Reserved
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('alert-success');
            if(alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>
