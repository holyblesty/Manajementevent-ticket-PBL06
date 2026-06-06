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

    {{-- Wrapper Utama Menggunakan Flex --}}
    <div class="flex min-h-screen w-full !overflow-visible">

        {{-- TOP NAVIGATION HEADER --}}
        <header class="fixed top-0 z-50 w-full shadow-sm">
            <nav class="w-full bg-white h-16 flex items-center justify-between px-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-12 w-auto">
                </div>
                <div class="flex items-center space-x-6 text-sm font-semibold">
                    <a href="#" class="transition-colors" style="text-decoration: none !important; color: #4b5563 !important;" onmouseover="this.style.color='#7a4988'" onmouseout="this.style.color='#4b5563'">Beranda</a>
                    <a href="#" class="transition-colors" style="text-decoration: none !important; color: #4b5563 !important;" onmouseover="this.style.color='#7a4988'" onmouseout="this.style.color='#4b5563'">Acara</a>
                    <a href="#" class="transition-colors" style="text-decoration: none !important; color: #4b5563 !important;" onmouseover="this.style.color='#7a4988'" onmouseout="this.style.color='#4b5563'">Tentang kami</a>
                    
                    <div class="flex items-center space-x-3 border-l border-gray-200 pl-6">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-lg text-xs font-black transition uppercase shadow-sm" style="color: #2b1238 !important; background-color: #be93d4 !important; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#9e7bb5'" onmouseout="this.style.backgroundColor='#be93d4'">Keluar</button>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="w-full bg-[#7a4988] h-1"></div>
        </header>

        {{-- SIDEBAR KIRI --}}
        <aside class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-64px)] bg-white border-r border-gray-200 flex flex-col justify-between py-6">
            <div class="w-full">
                {{-- FOTO PROFIL (PERBAIKAN AMAN) --}}
                <a href="{{ route('admin.profile') }}" class="flex flex-col items-center mb-6 no-underline group">
                    <div class="w-36 h-36 rounded-full border-4 border-[#7a4988] overflow-hidden shadow-md transition-all duration-300 group-hover:scale-105">
                        <img src="{{ asset('images/' . (session('admin_foto') ?: 'profile_default.jpg')) }}" 
                             alt="Admin"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('admin_name','Admin')) }}&color=ffffff&background=7a4988';"
                             class="w-full h-full object-cover">
                    </div>

                    <h3 class="mt-3 text-[#24112e] font-black text-xs uppercase tracking-wider text-center group-hover:text-[#7a4988] transition-colors">
                        {{ Auth::guard('admin')->user()->username ?? session('admin_name', 'Admin') }}
                    </h3>

                    <span class="text-xs text-gray-500 mt-1 font-semibold">Edit Profile</span>
                </a>
                
                {{-- NAVIGASI SIDEBAR --}}
                <nav class="w-full space-y-2 px-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 rounded-xl font-bold text-sm transition" style="text-decoration: none !important; {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.acara.*') ? 'background-color: #7a4988; color: #ffffff !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);' : 'color: #4b5563 !important;' }}" onmouseover="this.style.color='#7a4988'; this.style.backgroundColor='#f9fafb'" onmouseout="this.style.color='{{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.acara.*') ? '#ffffff' : '#4b5563' }}'; this.style.backgroundColor='{{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.acara.*') ? '#7a4988' : 'transparent' }}'">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                        <span style="text-decoration: none !important;">KELOLA ACARA</span>
                    </a>

                    <a href="{{ route('admin.peserta.index') }}" class="flex items-center px-4 py-3.5 rounded-xl font-bold text-sm transition" style="text-decoration: none !important; {{ request()->routeIs('admin.peserta.*') ? 'background-color: #7a4988; color: #ffffff !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);' : 'color: #4b5563 !important;' }}" onmouseover="this.style.color='#7a4988'; this.style.backgroundColor='#f9fafb'" onmouseout="this.style.color='{{ request()->routeIs('admin.peserta.*') ? '#ffffff' : '#4b5563' }}'; this.style.backgroundColor='{{ request()->routeIs('admin.peserta.*') ? '#7a4988' : 'transparent' }}'">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                        <span style="text-decoration: none !important;">KELOLA PESERTA</span>
                    </a>

                    <a href="{{ route('admin.statistik') }}" class="flex items-center px-4 py-3.5 rounded-xl font-bold text-sm transition" style="text-decoration: none !important; {{ request()->routeIs('admin.statistik') ? 'background-color: #7a4988; color: #ffffff !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);' : 'color: #4b5563 !important;' }}" onmouseover="this.style.color='#7a4988'; this.style.backgroundColor='#f9fafb'" onmouseout="this.style.color='{{ request()->routeIs('admin.statistik') ? '#ffffff' : '#4b5563' }}'; this.style.backgroundColor='{{ request()->routeIs('admin.statistik') ? '#7a4988' : 'transparent' }}'">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                        <span style="text-decoration: none !important;">STATISTIK</span>
                    </a>
                </nav>
            </div>
            <div class="w-full flex justify-center px-4">
                <img src="{{ asset('images/logo1.jpeg') }}" class="h-24 w-auto object-contain">
            </div>
        </aside>

        {{-- AREA KANAN (CONTENT & FOOTER) --}}
        <div class="flex-1 min-w-0 ml-64 mt-16 p-8 bg-gray-50 flex flex-col justify-between min-h-[calc(100vh-64px)] !overflow-visible">
            @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-2xl bg-green-50 border border-green-100 shadow-sm transition-all duration-500" role="alert">
                <div class="ms-3 text-xs font-black uppercase tracking-wider">{{ session('success') }}</div>
            </div>
            @endif

            <main class="flex-grow !overflow-visible">
                @yield('content')
            </main>

            <footer class="mt-12 bg-[#24112e] rounded-3xl p-8 text-white shadow-xl flex-shrink-0">
                <div class="flex flex-col md:flex-row items-start justify-between gap-8">
                    {{-- Konten Footer Tetap Sama --}}
                    <div class="md:w-[35%]">...</div>
                    <div class="md:w-[15%]">...</div>
                    <div class="md:w-[15%]">...</div>
                    <div class="md:w-[25%]">...</div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>