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

    <div class="flex min-h-screen w-full !overflow-visible">

        {{-- TOP NAVIGATION HEADER --}}
        <header class="fixed top-0 z-50 w-full shadow-sm">
            <nav class="w-full bg-white h-16 flex items-center justify-between px-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-12 w-auto">
                </div>
                
               {{-- NAVIGASI KANAN --}}
<div class="flex items-center space-x-6 text-sm font-semibold">
    <a href="{{ route('home') }}" class="transition-colors text-gray-600 hover:text-[#7a4988]" style="text-decoration: none !important;">Beranda</a>
    
    <a href="#" class="transition-colors text-gray-600 hover:text-[#7a4988] cursor-not-allowed opacity-50" style="text-decoration: none !important;">Acara</a>
    
    <a href="{{ route('pengunjung.tentang') }}" class="transition-colors text-gray-600 hover:text-[#7a4988]" style="text-decoration: none !important;">Tentang kami</a>
    
    <a href="{{ route('pengunjung.kontak') }}" class="transition-colors text-gray-600 hover:text-[#7a4988]" style="text-decoration: none !important;">Kontak Kami</a>
    <div class="flex items-center space-x-3 border-l border-gray-200 pl-6">
                        @auth('admin')
                            {{-- Jika Sudah Login Admin --}}
                            <span class="text-[#7a4988] font-black uppercase text-xs">Halo, Admin {{ Auth::guard('admin')->user()->username }}!</span>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="px-5 py-2 rounded-lg text-xs font-black transition uppercase shadow-sm bg-[#be93d4] text-[#2b1238] hover:bg-[#9e7bb5]" style="border: none; cursor: pointer;">Keluar</button>
                            </form>
                        @else
                            {{-- Jika Belum Login (fallback) --}}
                            <a href="{{ url('/') }}" class="px-5 py-2 rounded-lg text-xs font-black transition uppercase shadow-sm bg-[#7a4988] text-white hover:bg-[#5a3565]" style="text-decoration: none !important;">Login Admin</a>
                        @endauth
                    </div>
                </div>
            </nav>
            <div class="w-full bg-[#7a4988] h-1"></div>
        </header>

        {{-- SIDEBAR KIRI --}}
        <aside class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-64px)] bg-white border-r border-gray-200 flex flex-col justify-between py-6">
            <div class="w-full">
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
            <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-2xl bg-green-50 border border-green-100 shadow-sm transition-opacity duration-500" role="alert">
                <div class="ms-3 text-xs font-black uppercase tracking-wider">{{ session('success') }}</div>
            </div>
            @endif

            <main class="flex-grow !overflow-visible">
                @yield('content')
            </main>

            <footer class="mt-12 bg-[#1E0F30] rounded-3xl p-8 text-white shadow-xl flex-shrink-0">
                {{-- ... (Footer tetap sama) ... --}}
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