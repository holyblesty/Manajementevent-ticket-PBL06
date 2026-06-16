<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventTicket - Discover & Book Now!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purplePrimary: '#7a4988',
                        purpleAccent: '#9e7bb5',
                        purpleHover: '#be93d4',
                        purpleDark: '#1a0926',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-white text-black antialiased">

 <header class="container mx-auto px-6 py-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center w-full md:w-auto">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.jpeg') }}" alt="EventTicket Logo" class="h-16 w-16 object-contain shadow-sm rounded-xl transition-transform group-hover:scale-105">
                <span class="text-2xl font-black text-purpleDark tracking-tighter">EVENT<span class="text-purplePrimary">TICKET</span></span>
            </a>
        </div>
        
        <nav class="flex flex-wrap items-center justify-center md:justify-end gap-4 md:gap-8 w-full md:w-auto">
        <a class="text-sm font-medium text-black hover:text-purplePrimary transition-colors" href="{{ route('pengunjung.about') }}">Tentang kami</a>
        <a class="text-sm font-medium text-black hover:text-purplePrimary transition-colors" href="{{ route('pengunjung.contact') }}">Kontak Kami</a>
            
            @if(Auth::guard('admin')->check())
                {{-- Jika Login sebagai Admin --}}
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700">Halo, <strong class="text-purplePrimary">Admin {{ Auth::guard('admin')->user()->username }}</strong>!</span>
                    <a href="{{ route('admin.dashboard') }}" class="bg-purpleAccent text-white text-xs font-bold px-4 py-2 rounded shadow hover:bg-purplePrimary transition-colors text-center">Dashboard Admin</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs font-bold px-4 py-2 rounded transition-colors cursor-pointer">Keluar</button>
                    </form>
                </div>

            @elseif(Auth::guard('web')->check())
                {{-- Jika Login sebagai Pengunjung Biasa --}}
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700">Halo, <strong class="text-purplePrimary">{{ Auth::user()->name }}</strong>!</span>
                    <a href="{{ route('pengunjung.dashboard') }}" class="bg-purpleAccent text-white text-xs font-bold px-4 py-2 rounded shadow hover:bg-purplePrimary transition-colors text-center">Menu Saya</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs font-bold px-4 py-2 rounded transition-colors cursor-pointer">Keluar</button>
                    </form>
                </div>

            @else
                {{-- Jika Belum Login Sama Sekali --}}
                <button onclick="openModal('loginModal')" class="bg-purpleHover text-white text-xs font-bold px-5 py-2 rounded shadow hover:bg-purpleAccent transition-colors text-center min-w-[80px] cursor-pointer">Masuk</button>
                <button onclick="openModal('registerModal')" class="bg-purpleAccent text-white text-xs font-bold px-5 py-2 rounded shadow hover:bg-purplePrimary transition-colors text-center min-w-[80px] cursor-pointer">Daftar</button>
            @endif
        </nav>
        </div>
</header>
    @if(session('success'))
        <div class="container mx-auto px-4 mt-2">
            <div class="p-4 bg-green-100 text-green-700 rounded-lg text-sm font-semibold text-center shadow-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mx-auto px-4 mt-2">
            <div class="p-4 bg-red-100 text-red-700 rounded-lg text-sm font-semibold text-center shadow-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <section class="bg-purplePrimary py-3">
    <div class="container mx-auto px-4">
        <form action="{{ route('pengunjung.search') }}" method="GET" class="max-w-2xl mx-auto relative">
            <button type="submit" class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </button>
            <input type="text" name="keyword" 
                   class="w-full bg-white text-sm text-black pl-10 pr-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-purpleHover" 
                   placeholder="Cari acara berdasarkan judul atau lokasi...">
        </form>
    </div>
</section>

    <section class="container mx-auto px-4 mt-4" 
    x-data="{ activeSlide: 0, slides: {{ $latestEvents->count() }} }" 
    x-init="setInterval(() => activeSlide = (activeSlide + 1) % slides, 5000)">
    
    <div class="relative overflow-hidden rounded-xl shadow-lg bg-gray-200 h-[300px] md:h-[400px]">
        
        @foreach($latestEvents as $index => $event)
        <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out" 
             x-show="activeSlide === {{ $index }}" 
             x-transition:enter="transition-opacity duration-700" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-700"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <img src="{{ asset('images/' . $event->poster) }}" 
                 class="absolute inset-0 w-full h-full object-cover object-center" 
                 alt="{{ $event->judul }}">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 md:max-w-2xl text-left">
                <span class="bg-purplePrimary text-white text-[10px] md:text-xs font-bold px-3 py-1 rounded mb-2 inline-block">EVENT TERBARU</span>
                <h2 class="text-2xl md:text-4xl font-bold text-white mb-2 leading-tight">{{ $event->judul }}</h2>
                <p class="text-gray-200 text-xs md:text-sm mb-4">
                    <i class="fa-regular fa-calendar me-2"></i>{{ $event->tgl_mulai ? $event->tgl_mulai->format('d-m-y') : '-' }} | 
                    <i class="fa-solid fa-location-dot me-2"></i>{{ $event->lokasi }}
                </p>
                <a href="#" class="bg-purpleAccent hover:bg-purplePrimary text-white text-xs font-bold px-5 py-2.5 rounded shadow-sm transition-colors inline-block">
                    Detail Acara <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        @endforeach

        <button class="absolute top-1/2 left-4 z-20 bg-black/30 hover:bg-black/50 text-white w-10 h-10 rounded-full flex items-center justify-center transition" @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="absolute top-1/2 right-4 z-20 bg-black/30 hover:bg-black/50 text-white w-10 h-10 rounded-full flex items-center justify-center transition" @click="activeSlide = (activeSlide + 1) % slides">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>

    <section class="container mx-auto px-4 text-center my-12">
        <p class="text-sm font-bold tracking-widest text-gray-700 uppercase mb-6">KATEGORI ACARA</p>
        <div class="flex flex-wrap justify-center gap-8 md:gap-16">
            <div class="flex flex-col items-center">
                <div class="w-28 h-28 border-2 border-purplePrimary rounded-full flex items-center justify-center bg-white shadow-sm hover:scale-105 transition-transform duration-200 cursor-pointer">
                    <i class="fa-solid fa-basketball text-4xl text-purplePrimary"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 mt-3">Olahraga</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-28 h-28 border-2 border-purplePrimary rounded-full flex items-center justify-center bg-white shadow-sm hover:scale-105 transition-transform duration-200 cursor-pointer">
                    <i class="fa-solid fa-masks-theater text-4xl text-purplePrimary"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 mt-3">Hiburan</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-28 h-28 border-2 border-purplePrimary rounded-full flex items-center justify-center bg-white shadow-sm hover:scale-105 transition-transform duration-200 cursor-pointer">
                    <i class="fa-solid fa-chalkboard-user text-4xl text-purplePrimary"></i>
                </div>
                <span class="text-sm font-medium text-gray-700 mt-3">Seminar</span>
            </div>
        </div>
        <hr class="mt-12 border-gray-200 opacity-60">
    </section>

    <section class="container mx-auto px-4 mb-16">
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-10 mb-8 tracking-tight">
            ACARA YANG SEDANG BERLANGSUNG
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($events as $event)
            <div class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 bg-white">
                
                <div class="overflow-hidden h-[300px]">
                    <img src="{{ asset('images/' . $event->poster) }}"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                         alt="{{ $event->judul }}">
                </div>

                <div class="p-5">
                    <span class="text-[10px] font-black text-purplePrimary uppercase tracking-widest">Event</span>
                    
                    <h3 class="font-bold text-lg text-slate-900 mt-1 mb-3 leading-snug group-hover:text-purplePrimary transition-colors">
                        {{ $event->judul }}
                    </h3>

                    <div class="flex items-center text-[11px] text-gray-500 mb-1 font-medium">
                        <i class="fa-regular fa-calendar me-2 text-purplePrimary"></i>
                        {{ $event->tgl_mulai ? $event->tgl_mulai->format('d-m-y') : '-' }}
                    </div>

                    <div class="flex items-center text-[11px] text-gray-500 font-medium">
                        <i class="fa-solid fa-location-dot me-2 text-purplePrimary"></i>
                        <span class="truncate">{{ $event->lokasi }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 italic col-span-full text-center py-6">Belum ada acara yang tersedia saat ini.</p>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="#" class="bg-purplePrimary text-white text-sm font-bold px-8 py-2.5 
            rounded-lg shadow hover:bg-purpleAccent transition-colors inline-block mb-4">Lihat Semua Acara</a>
            <div class="text-sm text-gray-600 max-w-lg mx-auto leading-relaxed mb-3 mt-2">
                Ingin membuat acara atau kegiatan baru? hubungi admin untuk informasi lebih lanjut melalui kontak kami
            </div>
            <a href="#" class="bg-purplePrimary text-white text-sm font-bold px-6 
            py-2.5 rounded-lg shadow hover:bg-purpleAccent transition-colors inline-block">Kontak kami</a>
        </div>
    </section>

    <footer class="w-full">
        @include('components.footer')
    </footer>

    <div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
        <div class="bg-white w-[90%] sm:w-[420px] p-8 rounded-xl shadow-2xl relative transition-all duration-300 border border-gray-100">
            <button onclick="closeModal('loginModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
            
            <h3 class="text-2xl font-bold text-center text-gray-800 uppercase tracking-wide mb-4">Masuk Ke Akun</h3>
            
            @if($errors->has('username') && !old('email'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                    {{ $errors->first('username') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Akun / Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none 
                    focus:border-purplePrimary text-sm" placeholder="Isi nama akun anda" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border 
                    border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary text-sm" 
                    placeholder="Isi kata sandi anda" required>
                </div>
                
                <button type="submit" class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary 
                text-white font-medium rounded-lg transition shadow-md shadow-purpleAccent/20 cursor-pointer text-sm">
                    Masuk
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-500 mt-5">
                Belum punya akun? <a href="javascript:void(0)" 
                onclick="switchModal('loginModal', 'registerModal')" class="text-purplePrimary font-semibold 
                hover:underline">Registrasi disini!</a>
            </p>
        </div>
    </div>

    <div id="registerModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
        <div class="bg-white w-[90%] sm:w-[440px] p-7 rounded-xl shadow-2xl relative max-h-[92vh] overflow-y-auto no-scrollbar border border-gray-100">
            <button onclick="closeModal('registerModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
            
            <h3 class="text-2xl font-bold text-center text-gray-800 uppercase tracking-wide mb-4">DAFTAR AKUN</h3>
            
            @if($errors->any() && (old('email') || old('name')))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs space-y-1 font-semibold">
                    @foreach($errors->all() as $error)
                        <p><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi nama lengkap anda" required>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Buat Nama Akun (Username)</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi nama akun anda" required>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi email aktif anda" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Kata Sandi</label>
                        <input type="password" name="password" class="w-full px-3.5 py-2 text-sm 
                        border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary" 
                        placeholder="Minimal 6 karakter" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Ulangi Sandi</label>
                        <input type="password" name="password_confirmation" class="w-full 
                        px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none 
                        focus:border-purplePrimary" placeholder="Konfirmasi sandi" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi nomor ponsel aktif">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Alamat Rumah</label>
                    <textarea name="alamat" rows="2" class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary" placeholder="Isi alamat rumah anda">{{ old('alamat') }}</textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary text-white font-medium rounded-lg transition shadow-md shadow-purpleAccent/20 text-sm cursor-pointer">
                        Buat Akun Baru
                    </button>
                </div>
            </form>
            
            <p class="text-center text-xs text-gray-500 mt-4">
                Sudah punya akun? 
                <a href="javascript:void(0)" onclick="switchModal('registerModal', 'loginModal')" 
                class="text-purplePrimary font-semibold hover:underline">Masuk disini!</a>
            </p>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function switchModal(modalToClose, modalToOpen) {
            closeModal(modalToClose);
            openModal(modalToOpen);
        }

        window.onclick = function(event) {
            if (event.target.id === 'loginModal') closeModal('loginModal');
            if (event.target.id === 'registerModal') closeModal('registerModal');
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if($errors->any())
                @if(old('email') || old('name'))
                    openModal('registerModal');
                @else
                    openModal('loginModal');
                @endif
            @endif
        });
    </script>
</body>
</html>