 @vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <!-- Header -->
    <div class="max-w-5xl mx-auto mb-6">
        <h1 class="text-3xl font-bold text-purple-600">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang, Admin!</p>
    </div>

    <!-- Card Container -->
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card Event -->
        <div class="bg-white shadow-lg rounded-xl p-6 text-center border border-gray-100">
            <h5 class="text-xl font-semibold text-purple-600 mb-2">Event</h5>
            <p class="text-gray-600 mb-4">Kelola semua event</p>
            <a href="{{ route('admin.events') }}"
               class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition duration-300">
                Lihat Event
            </a>
        </div>

        <!-- Card Peserta -->
        <div class="bg-white shadow-lg rounded-xl p-6 text-center border border-gray-100">
            <h5 class="text-xl font-semibold text-purple-600 mb-2">Peserta</h5>
            <p class="text-gray-600 mb-4">Lihat semua peserta</p>
            <a href="{{ route('admin.participants') }}"
               class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition duration-300">
                Lihat Peserta
            </a>
        </div>

    </div>

</body>
</html>