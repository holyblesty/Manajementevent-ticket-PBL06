<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EventTicket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
        </div>
        <div class="flex items-center space-x-6 text-sm font-medium">
            <a href="#" class="text-gray-600 hover:text-[#7a4988]">Beranda</a>
            <a href="#" class="text-gray-600 hover:text-[#7a4988]">Acara</a>
            <a href="#" class="text-gray-600 hover:text-[#7a4988]">Tentang kami</a>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-[#be93d4] rounded-full flex items-center justify-center text-[#7a4988]">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                </div>
                <a href="#" class="bg-[#be93d4] text-[#2b1238] px-4 py-1.5 rounded text-xs font-bold hover:bg-[#9e7bb5] transition uppercase">Keluar</a>
            </div>
        </div>
    </nav>

    <aside class="fixed top-16 left-0 z-40 w-64 h-screen bg-white border-r border-gray-200">
        <div class="py-8 px-4 flex flex-col items-center">
            <div class="w-24 h-24 rounded-full border-4 border-[#7a4988] p-1 mb-4">
                <img src="{{ asset('images/profile_placeholder.png') }}" class="w-full h-full rounded-full object-cover shadow-sm">
            </div>
            <h2 class="text-[#7a4988] font-black text-[10px] tracking-[0.2em] mb-10 uppercase">Welcome Admin</h2>
            
            <nav class="w-full space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center p-3 rounded-xl font-bold text-xs transition 
                   {{ request()->routeIs('admin.dashboard') ? 'bg-[#7a4988] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                    KELOLA ACARA
                </a>

                <a href="#" 
                   class="flex items-center p-3 rounded-xl font-bold text-xs transition text-gray-500 hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    KELOLA PESERTA
                </a>

                <a href="#" 
                   class="flex items-center p-3 rounded-xl font-bold text-xs transition text-gray-500 hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    STATISTIK
                </a>
            </nav>
        </div>
        <div class="absolute bottom-24 w-full flex justify-center opacity-30">
            <img src="{{ asset('images/logo.png') }}" class="h-10">
        </div>
    </aside>

    <div class="p-8 sm:ml-64 mt-16 min-h-screen bg-gray-50 flex flex-col">
        
        @if(session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-2xl bg-green-50 border border-green-100 shadow-sm transition-all duration-500" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <div class="ms-3 text-xs font-black uppercase tracking-wider">
                {{ session('success') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" onclick="document.getElementById('alert-success').remove()">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @endif

        <div class="flex-grow">
            @yield('content')
        </div>

        <footer class="mt-12 bg-[#24112e] rounded-3xl p-10 text-white shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 mb-6 brightness-0 invert opacity-80">
                    <p class="text-[11px] text-gray-400 leading-relaxed font-medium">Platform manajemen event & ticketing terbaik untuk kemudahan acara kampus Anda.</p>
                </div>
                <div>
                    <h4 class="text-[#be93d4] font-black text-[10px] mb-6 uppercase tracking-[0.2em]">Navigasi</h4>
                    <ul class="text-[11px] space-y-3 text-gray-400 font-bold">
                        <li><a href="#" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#" class="hover:text-white transition">Acara</a></li>
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[#be93d4] font-black text-[10px] mb-6 uppercase tracking-[0.2em]">Kategori</h4>
                    <ul class="text-[11px] space-y-3 text-gray-400 font-bold">
                        <li class="hover:text-white cursor-pointer transition">Hiburan</li>
                        <li class="hover:text-white cursor-pointer transition">Olahraga</li>
                        <li class="hover:text-white cursor-pointer transition">Seminar</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[#be93d4] font-black text-[10px] mb-6 uppercase tracking-[0.2em]">Hubungi Kami</h4>
                    <ul class="text-[11px] space-y-3 text-gray-400 font-bold">
                        <li class="flex items-center"><svg class="w-3 h-3 mr-2 text-[#be93d4]" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg> admin@eventticket.com</li>
                        <li class="flex items-center"><svg class="w-3 h-3 mr-2 text-[#be93d4]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C10.12 18 2 9.88 2 2V3z"></path></svg> +62 895 3128 7505</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 mt-10 pt-6 text-center text-[9px] text-gray-600 font-bold uppercase tracking-widest">
                © 2026 Event Ticketing System | Crafted with Purple Passion
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById('alert-success');
            if(alert) alert.remove();
        }, 5000);
    </script>
</body>
</html>