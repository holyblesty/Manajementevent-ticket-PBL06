<!DOCTYPE html>
<html>
<head>
    <title>Home</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md">

        <h1 class="text-3xl font-bold text-center text-purple-600 mb-8">
            Event Sedang Berlangsung
        </h1>

        <div class="bg-white p-8 rounded-xl shadow-lg text-center">
            <h3 class="text-xl font-semibold mb-2">Seminar IT 2026</h3>
            <p class="text-gray-600 mb-6">Tanggal : 20 Mei 2026</p>

            <a href="/pendaftaran"
               class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg shadow transition">
                Daftar Event
            </a>
        </div>

    </div>

</body>
</html>