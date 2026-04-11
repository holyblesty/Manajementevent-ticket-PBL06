<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengunjung</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

    <h1 class="text-3xl font-bold text-purple-600 mb-6">
        Dashboard Pengunjung
    </h1>

    <div class="flex gap-4">
        <a href="/pendaftaran"
           class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg transition">
           Daftar Event
        </a>

        <a href="/pembayaran"
           class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg transition">
           Pembayaran
        </a>
    </div>

</div>

</body>
</html>
