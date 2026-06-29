<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 font-sans antialiased">

    {{-- ================= NAVBAR ================= --}}
    <header class="fixed top-0 z-50 w-full bg-white shadow-sm">

        <nav class="h-16 flex items-center justify-between px-8">

            {{-- LOGO --}}
            <div class="flex items-center gap-4">

                <img src="{{ asset('images/logo.jpeg') }}"
                     class="h-16">

            </div>

            {{-- SEARCH --}}
            <form
                action="{{ route('pengunjung.dashboard') }}"
                method="GET"
                class="hidden lg:flex items-center w-[420px]">

                <div class="relative w-full">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari event..."
                        class="w-full border border-gray-200 rounded-l-xl py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#7a4988] focus:outline-none">

                </div>

                <button
                    type="submit"
                    class="bg-[#7a4988] text-white px-5 py-2 rounded-r-xl text-sm font-semibold hover:bg-[#693b76]">

                    Cari

                </button>

            </form>

            {{-- MENU --}}
            <div class="flex items-center gap-8">

                <a href="{{ route('home') }}"
                class="text-sm font-bold text-blue hover:text-[#7a4988] no-underline">
                    Beranda
                </a>

                <a href="{{ route('pengunjung.dashboard') }}"
                class="text-sm font-bold text-blue hover:text-[#7a4988] no-underline">
                    Acara
                </a>

                <a href="{{ route('pengunjung.tentang') }}"
                class="text-sm font-bold text-blue hover:text-[#7a4988] no-underline">
                    Tentang Kami
                </a>

               @auth


<div class="flex items-center gap-3 border-l pl-6">

    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="button"
            onclick="confirmLogout()"
            class="flex items-center gap-2 px-5 py-2 bg-[#7a4988] text-white rounded-r-xl text-sm font-semibold hover:bg-[#693b76]">


            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-5 h-5">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15m-3-3h8.25m0 0l-3-3m3 3l-3 3" />
            </svg>
            
            <span>Keluar</span>

        </button>
    </form>

</div>

@endauth

@guest

<div class="flex items-center gap-3 border-l pl-6">

    <button class="px-5 py-2 rounded-lg text-xs font-bold bg-[#2b1238] text-white hover:bg-[#1c0c25]">
        Masuk
    </button>

    <button class="px-5 py-2 rounded-lg text-xs font-bold bg-[#be93d4] text-[#2b1238] hover:bg-[#a97bc2]">
        Daftar
    </button>

</div>

@endguest

            </div>

        </nav>

        <div class="w-full h-1 bg-[#7a4988]"></div>

    </header>

    {{-- ================= CONTENT ================= --}}
    <div class="flex pt-16">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="fixed left-0 top-16 w-64 h-screen bg-white border-r border-gray-200 py-8 flex flex-col">

            {{-- PROFILE --}}
            <div class="flex flex-col items-center">

                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#7a4988] shadow-md">

                    <img src="{{ asset('images/profile_1777288175.webp') }}"
                         class="w-full h-full object-cover">

                </div>

                @auth

                <h2 class="text-base font-semibold text-center break-words">
                    {{ Auth::user()->name }}
                </h2>

                <p class="text-sm text-[#7a4988] font-medium">
                    Pengunjung
                </p>

                @endauth
            {{-- MENU --}}
            <nav class="mt-4 px-3 flex-col gap-1 font-bold">

                <a href="{{ route('pengunjung.dashboard') }}"
                   class="flex items-center gap-3 px-2 py-3 rounded-xl bg-[#f3ebf8] text-[#7a4988] font-semibold no-underline">

                    🏠 Beranda

                </a>

                <a href="{{ route('pengunjung.riwayat') }}"
                   class="flex items-center gap-4 px-2 py-3 rounded-xl text-gray-600 hover:bg-[#f9f5fc] hover:text-[#7a4988] no-underline">

                    🎫 Ticket Saya

                </a>

                <a href="{{ route('pengunjung.riwayat') }}"
                    class="flex items-center gap-2 px-2 py-3 rounded-xl">
                    🕒 Riwayat Pendaftaran
                </a>

                <a href="{{ route('pengunjung.profil') }}"
                   class="flex items-center gap-2 px-2 py-3 rounded-xl text-gray-600 hover:bg-[#f9f5fc] hover:text-[#7a4988] no-underline">
                </a>

                    👤 Profil

                </a>


            </nav>

        </aside>

        {{-- ================= MAIN ================= --}}
        <main class="flex-1 ml-64 p-8 bg-gray-50 min-h-screen">

            @yield('content')

        </main>

    </div>

    {{-- ================= FOOTER ================= --}}
    @include('components.footer')

    <script>
function confirmLogout() {
    Swal.fire({
        title: 'Keluar dari akun?',
        text: 'Anda akan logout dari sistem.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
}
</script>

</body>
</html>