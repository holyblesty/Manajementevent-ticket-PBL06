<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | EventTicket</title>

    <script src="https://cdn.tailwindcss.com"></script>
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

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body{
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

<header class="bg-white shadow-sm">
    <div class="container mx-auto px-6 py-5 flex items-center justify-between">

        <a href="{{ route('home') }}" class="flex items-center gap-3 group">

            <img src="{{ asset('images/logo.jpeg') }}"
                 class="w-14 h-14 rounded-xl object-cover shadow-sm">

            <span class="text-2xl font-black text-purpleDark">
                EVENT<span class="text-purplePrimary">TICKET</span>
            </span>

        </a>

        <nav class="flex items-center gap-6">

            <a href="{{ route('pengunjung.tentang') }}"
               class="text-sm font-medium hover:text-purplePrimary">
                Tentang Kami
            </a>

            <a href="{{ route('pengunjung.kontak') }}"
               class="text-sm font-medium hover:text-purplePrimary">
                Kontak Kami
            </a>

            @if(Auth::guard('admin')->check())

                <a href="{{ route('admin.dashboard') }}"
                   class="bg-purpleAccent text-white text-xs font-bold px-4 py-2 rounded hover:bg-purplePrimary">
                    Dashboard Admin
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-600 text-xs font-bold">
                        Keluar
                    </button>
                </form>

            @elseif(Auth::guard('web')->check())

                <a href="{{ route('pengunjung.dashboard') }}"
                   class="bg-purpleAccent text-white text-xs font-bold px-4 py-2 rounded hover:bg-purplePrimary">
                    Menu Saya
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-600 text-xs font-bold">
                        Keluar
                    </button>
                </form>

            @else

                <button onclick="openModal('loginModal')"
                        class="bg-purpleHover text-white text-xs font-bold px-5 py-2 rounded">
                    Masuk
                </button>

                <button onclick="openModal('registerModal')"
                        class="bg-purpleAccent text-white text-xs font-bold px-5 py-2 rounded">
                    Daftar
                </button>

            @endif

        </nav>

    </div>
</header>

@if(session('success'))
<div class="container mx-auto mt-4 px-6">
    <div class="bg-green-100 text-green-700 rounded-lg p-4">
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="container mx-auto mt-4 px-6">
    <div class="bg-red-100 text-red-700 rounded-lg p-4">
        {{ session('error') }}
    </div>
</div>
@endif

<main class="container mx-auto px-6 py-10 flex-1">

    @yield('content')

</main>

@include('components.footer')

@if(!Auth::guard('admin')->check() && !Auth::guard('web')->check())
    @include('components.auth-modals')
@endif

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('click', function(e) {
        document.querySelectorAll('.modal-overlay').forEach(function(modal) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
</script>

</body>
</html>