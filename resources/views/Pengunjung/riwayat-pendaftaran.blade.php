<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pendaftaran</title>

    @vite('resources/css/app.css')

    {{-- ICON --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="bg-[#f8f5fb] font-sans">

    {{-- NAVBAR --}}
    @include('Pengunjung.components.navbar')

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('Pengunjung.components.sidebar')

        {{-- CONTENT --}}
        <main class="flex-1 p-8">

            <h1 class="text-4xl font-bold text-[#3b1365]">
                Riwayat Pendaftaran
            </h1>

            <p class="text-gray-600 mt-2 mb-8">
                Berikut adalah riwayat event yang telah Anda ikuti.
            </p>

            <div class="space-y-6">

                {{-- CARD 1 --}}
                @include('Pengunjung.components.riwayat-card', [
                    'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200',
                    'title' => 'AI & MASA DEPAN KITA TECH FORUM 2024',
                    'date' => 'Kamis, 29 Mei 2024',
                    'time' => '09.00 - 17.00 WIB',
                    'location' => 'Gedung Utama, Jl. Teknologi No. 1, Bandung',
                    'ticket' => '2 x Regular',
                    'code' => 'EVT-200424-087'
                ])

                {{-- CARD 2 --}}
                @include('Pengunjung.components.riwayat-card', [
                    'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1200',
                    'title' => 'CREATIVEPRENEUR FEST 2024',
                    'date' => 'Minggu, 10 Maret 2024',
                    'time' => '10.00 - 18.00 WIB',
                    'location' => 'Eldorado Dome, Bandung',
                    'ticket' => '1 x Early Bird',
                    'code' => 'EVT-100324-056'
                ])

                {{-- CARD 3 --}}
                @include('Pengunjung.components.riwayat-card', [
                    'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1200',
                    'title' => 'WEBINAR UI/UX DESIGN 2024',
                    'date' => 'Sabtu, 24 Februari 2024',
                    'time' => '13.00 - 16.00 WIB',
                    'location' => 'Online via Zoom',
                    'ticket' => '1 x Standard',
                    'code' => 'EVT-240224-033'
                ])

            </div>

            {{-- PAGINATION --}}
            <div class="flex items-center justify-center mt-10 gap-3">

                <button
                    class="w-10 h-10 rounded border border-gray-300 bg-white text-gray-500">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <button
                    class="w-10 h-10 rounded bg-[#5b178f] text-white font-semibold">
                    1
                </button>

                <button
                    class="w-10 h-10 rounded border border-gray-300 bg-white">
                    2
                </button>

                <button
                    class="w-10 h-10 rounded border border-gray-300 bg-white text-gray-500">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

            </div>

        </main>
    </div>

    {{-- FOOTER --}}
    @include('Pengunjung.components.footer')

</body>
</html>