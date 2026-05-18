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
        /* Hide scrollbar untuk kebersihan layout jika dibutuhkan */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-white text-black antialiased">

    <header class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center justify-center md:justify-start w-full md:w-auto">
                <h3 class="text-2xl font-bold text-purplePrimary flex items-center">
                    <i class="fa-solid fa-ticket-simple me-2"></i>EventTicket
                </h3>
            </div>
            
            <nav class="flex flex-wrap items-center justify-center md:justify-end gap-4 md:gap-8 w-full md:w-auto">
                <a class="text-sm font-medium text-black hover:text-purplePrimary transition-colors" href="{{ url('/') }}">Beranda</a>
                <a class="text-sm font-medium text-black hover:text-purplePrimary transition-colors" href="#">Acara</a>
                <a class="text-sm font-medium text-black hover:text-purplePrimary transition-colors" href="#">Tentang kami</a>
                <a class="bg-purpleHover text-white text-xs font-bold px-5 py-2 rounded shadow hover:bg-purpleAccent transition-colors text-center min-w-[80px]" href="{{ route('login') }}">Masuk</a>
                <a class="bg-purpleAccent text-white text-xs font-bold px-5 py-2 rounded shadow hover:bg-purplePrimary transition-colors text-center min-w-[80px]" href="{{ route('register') }}">Daftar</a>
            </nav>
        </div>
    </header>

    <section class="bg-purplePrimary py-3">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                </span>
                <input type="text" class="w-full bg-white text-sm text-black pl-10 pr-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-purpleHover" placeholder="Mencari acara/kegiatan (otomatis)">
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 mt-4" x-data="{ activeSlide: 0, slides: [0, 1, 2] }" x-init="setInterval(() => activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1, 4000)">
        <div class="relative overflow-hidden rounded-lg shadow-sm bg-gray-100 h-[360px]">
            
            <div class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" x-show="activeSlide === 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <img src="https://via.placeholder.com/1200x400/7a4988/ffffff?text=BASKETBALL+CHAMPIONSHIP+2026" class="w-full h-full object-cover" alt="Turnamen Basket">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-12 left-[6%] max-w-lg hidden md:block text-left">
                    <span class="bg-purpleHover text-purplePrimary text-xs font-bold px-3 py-1.5 rounded mb-3 inline-block">OLAHRAGA</span>
                    <h2 class="text-3xl font-bold text-white mb-2">Turnamen Basket Polibatam 2026</h2>
                    <p class="text-gray-300 text-xs mb-4"><i class="fa-regular fa-calendar me-2"></i>09-06-26 | <i class="fa-solid fa-location-dot me-2"></i>Lapangan Politeknik</p>
                    <a href="#" class="bg-purpleAccent text-white text-xs font-bold px-4 py-2.5 rounded shadow-sm hover:bg-purplePrimary transition-colors inline-block">Pesan Tiket Sekarang <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" x-show="activeSlide === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <img src="https://via.placeholder.com/1200x400/9e7bb5/ffffff?text=HARMONI+KAMPUS+MUSIC+FESTIVAL" class="w-full h-full object-cover" alt="Festival Musik">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-12 left-[6%] max-w-lg hidden md:block text-left">
                    <span class="bg-purplePrimary text-white text-xs font-bold px-3 py-1.5 rounded mb-3 inline-block">HIBURAN</span>
                    <h2 class="text-3xl font-bold text-white mb-2">Harmoni Kampus Music Festival</h2>
                    <p class="text-gray-300 text-xs mb-4"><i class="fa-regular fa-calendar me-2"></i>15-07-26 | <i class="fa-solid fa-location-dot me-2"></i>Depan Gedung Techno</p>
                    <a href="#" class="bg-purplePrimary text-white text-xs font-bold px-4 py-2.5 rounded shadow-sm hover:bg-purpleAccent transition-colors inline-block">Pesan Tiket Sekarang <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out" x-show="activeSlide === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <img src="https://via.placeholder.com/1200x400/333333/ffffff?text=AI+FUTURE+FORUM+2026" class="w-full h-full object-cover" alt="Seminar AI">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-12 left-[6%] max-w-lg hidden md:block text-left">
                    <span class="bg-purpleHover text-purplePrimary text-xs font-bold px-3 py-1.5 rounded mb-3 inline-block">SEMINAR</span>
                    <h2 class="text-3xl font-bold text-white mb-2">National AI Forum: Masa Depan Kita</h2>
                    <p class="text-gray-300 text-xs mb-4"><i class="fa-regular fa-calendar me-2"></i>28-05-26 | <i class="fa-solid fa-location-dot me-2"></i>Auditorium Gedung Utama</p>
                    <a href="#" class="bg-purpleAccent text-white text-xs font-bold px-4 py-2.5 rounded shadow-sm hover:bg-purplePrimary transition-colors inline-block">Pesan Tiket Sekarang <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <button class="absolute top-0 bottom-0 left-0 z-10 flex items-center justify-center w-[5%] text-purpleHover text-2xl font-bold hover:text-purpleAccent" @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="absolute top-0 bottom-0 right-0 z-10 flex items-center justify-center w-[5%] text-purpleHover text-2xl font-bold hover:text-purpleAccent" @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button class="w-3 h-3 rounded-full transition-colors duration-300" :class="activeSlide === index ? 'bg-purplePrimary' : 'bg-gray-400/60'" @click="activeSlide = index"></button>
                </template>
            </div>
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
        <h2 class="text-2xl md:text-3xl font-bold text-black mt-10 mb-6">ACARA YANG SEDANG BERLANGSUNG</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="relative rounded-lg overflow-hidden shadow-md group hover:-translate-y-1 transition-transform duration-300">
                <img src="https://via.placeholder.com/300x420/7a4988/ffffff?text=SPORT+EVENT" class="w-full h-[380px] object-cover" alt="Sport Event">
                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-3 text-center">
                    <div class="text-xs font-bold uppercase mb-1">20 MEI , 16:00</div>
                    <p class="text-[11px] uppercase truncate"><i class="fa-solid fa-location-dot me-1"></i>LAPANGAN POLITEKNIK</p>
                </div>
            </div>

            <div class="relative rounded-lg overflow-hidden shadow-md group hover:-translate-y-1 transition-transform duration-300">
                <img src="https://via.placeholder.com/300x420/9e7bb5/ffffff?text=FESTIVAL+BAND" class="w-full h-[380px] object-cover" alt="Festival Band">
                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-3 text-center">
                    <div class="text-xs font-bold uppercase mb-1">28 MEI , 13:00</div>
                    <p class="text-[11px] uppercase truncate"><i class="fa-solid fa-location-dot me-1"></i>DEPAN TECHNO</p>
                </div>
            </div>

            <div class="relative rounded-lg overflow-hidden shadow-md group hover:-translate-y-1 transition-transform duration-300">
                <img src="https://via.placeholder.com/300x420/333333/ffffff?text=AI+FORUM" class="w-full h-[380px] object-cover" alt="AI Forum">
                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-3 text-center">
                    <div class="text-xs font-bold uppercase mb-1">28 MEI , 13:00</div>
                    <p class="text-[11px] uppercase truncate"><i class="fa-solid fa-location-dot me-1"></i>GEDUNG UTAMA</p>
                </div>
            </div>

            <div class="relative rounded-lg overflow-hidden shadow-md group hover:-translate-y-1 transition-transform duration-300">
                <img src="https://via.placeholder.com/300x420/7a4988/ffffff?text=FUTSAL+CHAMP" class="w-full h-[380px] object-cover" alt="Futsal Kampus">
                <div class="absolute bottom-0 left-0 right-0 bg-black text-white p-3 text-center">
                    <div class="text-xs font-bold uppercase mb-1">30 MEI , 08:00</div>
                    <p class="text-[11px] uppercase truncate"><i class="fa-solid fa-location-dot me-1"></i>LAPANGAN POLITEKNIK</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="#" class="bg-purplePrimary text-white text-sm font-bold px-8 py-2.5 rounded-lg shadow hover:bg-purpleAccent transition-colors inline-block mb-4">Lihat Semua Acara</a>
            <div class="text-sm text-gray-600 max-w-lg mx-auto leading-relaxed mb-3 mt-2">
                Ingin membuat acara atau kegiatan baru? hubungi admin untuk informasi lebih lanjut melalui kontak kami
            </div>
            <a href="#" class="bg-purplePrimary text-white text-sm font-bold px-6 py-2.5 rounded-lg shadow hover:bg-purpleAccent transition-colors inline-block">Kontak kami</a>
        </div>
    </section>

    <footer class="bg-purpleDark text-white pt-12 pb-6 text-sm">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center md:text-left">
                    <h4 class="text-xl font-bold text-white flex items-center justify-center md:justify-start">
                        <i class="fa-solid fa-ticket-simple me-2"></i>EventTicket
                    </h4>
                    <p class="text-purpleHover text-xs leading-relaxed mt-3">
                        Event&Ticketing adalah platform terbaik untuk menemukan, memantau, dan memesan tiket berbagai kegiatan kampus dengan mudah.
                    </p>
                </div>
                
                <div class="text-center md:text-left">
                    <div class="text-sm font-bold tracking-wider text-white uppercase mb-4">NAVIGASI</div>
                    <ul class="space-y-2 text-purpleHover text-xs">
                        <li><a href="#" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Acara</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak Kami</a></li>
                    </ul>
                </div>

                <div class="text-center md:text-left">
                    <div class="text-sm font-bold tracking-wider text-white uppercase mb-4">KATEGORI</div>
                    <ul class="space-y-2 text-purpleHover text-xs">
                        <li><a href="#" class="hover:text-white transition-colors">Hiburan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Olahraga</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Seminar</a></li>
                    </ul>
                </div>

                <div class="text-center md:text-left text-purpleHover text-xs space-y-2">
                    <div class="text-sm font-bold tracking-wider text-white uppercase mb-4">HUBUNGI KAMI</div>
                    <p class="flex items-center justify-center md:justify-start"><i class="fa-regular fa-envelope w-5 mr-1"></i> Jesinaaurora@gmail.com</p>
                    <p class="flex items-center justify-center md:justify-start"><i class="fa-solid fa-phone w-5 mr-1"></i> +62 895 3128 7505</p>
                </div>
            </div>

            <div class="border-t border-white/10 mt-10 pt-5 text-center text-xs text-purpleHover">
                &copy; 2026 Event Tiketing System | All Rights Reserved
            </div>
        </div>
    </footer>

</body>
</html>