<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang EventTicket - Rayakan Momenmu!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purplePrimary: '#7a4988',
                        purpleAccent: '#9e7bb5',
                        purpleDark: '#24112e',
                        bubblegum: '#fdf2f8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#fdf2f8] font-sans overflow-x-hidden">

    {{-- Decorative Background Circles --}}
    <div class="fixed top-[-100px] left-[-100px] w-72 h-72 bg-purpleAccent rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="fixed bottom-[-100px] right-[-100px] w-72 h-72 bg-purplePrimary rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse delay-1000"></div>

    <div class="relative container mx-auto px-6 py-16">
        
        {{-- Kembali Button --}}
        <a href="{{ url('/') }}" class="inline-flex items-center text-purplePrimary font-black hover:scale-110 transition-transform">
            <i class="fa-solid fa-arrow-left mr-2"></i> KEMBALI
        </a>

        {{-- Header Section --}}
        <div class="text-center mt-12 mb-20">
            <h1 class="text-6xl md:text-8xl font-black text-purpleDark uppercase italic rotate-[-2deg] mb-6 drop-shadow-lg">
                <span class="text-purplePrimary">LET'S</span> PARTY!
            </h1>
            <p class="text-xl md:text-2xl font-bold text-gray-700 max-w-2xl mx-auto">
                EventTicket adalah tempat di mana kegembiraan dimulai. Kami tidak cuma jual tiket, kami mengantarmu ke <span class="text-purplePrimary underline decoration-wavy">pengalaman seru!</span>
            </p>
        </div>

        {{-- Bento Grid / Cards Section --}}
        <div class="grid md:grid-cols-3 gap-8 items-center max-w-6xl mx-auto">
            
            {{-- Card 1: Musik --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-[8px_8px_0px_rgba(122,73,136,0.2)] border-2 border-purplePrimary transform hover:rotate-[-2deg] transition-all">
                <i class="fa-solid fa-music text-5xl text-purplePrimary mb-4"></i>
                <h3 class="text-2xl font-black uppercase mb-2">Music & Vibes</h3>
                <p class="text-gray-600">Rasakan bass-nya, nikmati lagunya. Pesan tiket festivalmu sekarang sebelum kehabisan!</p>
            </div>

            {{-- Card 2: Olahraga --}}
            <div class="bg-purplePrimary p-8 rounded-[2rem] shadow-[8px_8px_0px_rgba(36,17,46,0.2)] text-white transform hover:rotate-[2deg] transition-all">
                <i class="fa-solid fa-trophy text-5xl text-yellow-300 mb-4"></i>
                <h3 class="text-2xl font-black uppercase mb-2">Game On!</h3>
                <p class="text-purple-100">Dukung tim futsal/basket favoritmu. Dapatkan tiket kursi barisan depan dan jadi saksi kemenangan!</p>
            </div>

            {{-- Card 3: Seminar --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-[8px_8px_0px_rgba(122,73,136,0.2)] border-2 border-purplePrimary transform hover:rotate-[-2deg] transition-all">
                <i class="fa-solid fa-chalkboard-user text-5xl text-purplePrimary mb-4"></i>
                <h3 class="text-2xl font-black uppercase mb-2">Seminar & Insight</h3>
                <p class="text-gray-600">Upgrade skill-mu! Ikuti seminar dari pakar industri untuk masa depan yang lebih cerah.</p>
            </div>
            
        </div>

        {{-- Footer Call to Action --}}
        <div class="mt-20 text-center">
            <a href="{{ route('pengunjung.kontak') }}" class="inline-block bg-white px-10 py-5 rounded-full border-4 border-dashed border-purplePrimary animate-bounce hover:bg-purplePrimary hover:text-white transition-all duration-300 group">
                <p class="text-lg font-black text-purplePrimary group-hover:text-white uppercase">Siap bikin event? Hubungi kami!</p>
            </a>
        </div>