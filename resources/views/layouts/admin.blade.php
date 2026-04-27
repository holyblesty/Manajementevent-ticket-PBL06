<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EventTicket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <header class="fixed top-0 z-50 w-full shadow-md">
        <nav class="w-full bg-white h-16 flex items-center justify-between px-6">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="h-16">
            </div>
            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="#" class="text-gray-600 hover:text-[#7a4988] no-underline">Beranda</a>
                <a href="#" class="text-gray-600 hover:text-[#7a4988] no-underline">Acara</a>
                <a href="#" class="text-gray-600 hover:text-[#7a4988] no-underline">Tentang kami</a>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-[#be93d4] rounded-full flex items-center justify-center text-[#7a4988]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <a href="#" class="bg-[#be93d4] text-[#2b1238] px-4 py-1.5 rounded text-xs font-bold hover:bg-[#9e7bb5] transition uppercase no-underline">Keluar</a>
                </div>
            </div>
        </nav>
        <div class="w-full bg-[#7a4988] h-4"></div>
    </header>

    <aside class="fixed top-20 left-0 z-40 w-64 h-screen bg-white border-r border-gray-200">
        <div class="py-8 px-4 flex flex-col items-center">
               <div class="w-24 h-24 rounded-full border-4 border-[#7a4988] overflow-hidden mx-auto mb-4 shadow-lg">
    <img src="{{ asset('images/' . session('admin_foto', 'profile_default.jpg')) }}" 
         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('admin_name', 'Vivian')) }}&color=ffffff&background=7a4988';"
         class="w-full h-full object-cover">
</div>
            </div>
      <h2 class="text-[#7a4988] font-black text-[10px] tracking-[0.2em] mb-10 uppercase text-center w-full">
        Welcome Admin
     </h2>>
            
            <nav class="w-full space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center p-3 rounded-xl font-bold text-xs transition no-underline
                   {{ request()->routeIs('admin.dashboard') ? 'bg-[#7a4988] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                    KELOLA ACARA
                </a>
                <a href="#" class="flex items-center p-3 rounded-xl font-bold text-xs transition text-gray-500 hover:bg-gray-50 no-underline">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    KELOLA PESERTA
                </a>
                <a href="#" class="flex items-center p-3 rounded-xl font-bold text-xs transition text-gray-500 hover:bg-gray-50 no-underline">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    STATISTIK
                </a>
            </nav>
        </div>
        <div class="absolute bottom-24 w-full flex justify-center">
            <img src="{{ asset('images/logo1.jpeg') }}" class="h-35 object-contain">
        </div>
    </aside>

    <div class="p-8 sm:ml-64 mt-24 min-h-screen bg-gray-50 flex flex-col">
        
        @if(session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-2xl bg-green-50 border border-green-100 shadow-sm transition-all duration-500" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <div class="ms-3 text-xs font-black uppercase tracking-wider">
                {{ session('success') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" onclick="document.getElementById('alert-success').remove()">
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
            <div class="flex flex-col md:flex-row items-start justify-between gap-8">
                <div class="md:w-[35%]">
                    <div class="flex items-center gap-5 mb-4">
                        <img src="{{ asset('images/footer.jpg') }}" class="h-32 w-auto object-cover rounded-xl">
                        <div class="flex-grow">
                            <h3 class="text-lg font-black tracking-tighter text-[#be93d4] mb-2 uppercase">Event&Ticketing</h3>
                            <p class="text-[11px] text-gray-300 leading-relaxed font-medium">
                                Platform terpercaya untuk menemukan dan memesan tiket event terbaik dengan pengalaman admin yang lebih presisi dan modern.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="md:w-[15%] md:border-l md:border-white/10 md:pl-8 py-2">
                    <h4 class="text-white font-bold text-[10px] mb-4 uppercase tracking-[0.2em] opacity-50">Navigasi</h4>
                    <ul class="text-[11px] space-y-2 text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Beranda</a></li>
                        <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Acara</a></li>
                        <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="md:w-[15%] md:border-l md:border-white/10 md:pl-8 py-2">
                    <h4 class="text-white font-bold text-[10px] mb-4 uppercase tracking-[0.2em] opacity-50">Kategori</h4>
                    <ul class="text-[11px] space-y-2 text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Hiburan</a></li>
                        <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Olahraga</a></li>
                        <li><a href="#" class="hover:text-[#be93d4] transition no-underline">Seminar</a></li>
                    </ul>
                </div>

                <div class="md:w-[25%] md:border-l md:border-white/10 md:pl-8 py-2">
                    <h4 class="text-white font-bold text-[10px] mb-4 uppercase tracking-[0.2em] opacity-50">Hubungi Kami</h4>
                    <ul class="text-[11px] space-y-3 text-gray-400 font-medium">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#be93d4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Jesinaaurora@gmail.com
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#be93d4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 895 3128 7505
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 mt-10 pt-6 text-center">
                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">
                    © 2026 Event Ticketing System | All Rights Reserved
                </p>
            </div>
        </footer>
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