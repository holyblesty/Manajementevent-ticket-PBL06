<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pembayaran</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="max-w-md w-full bg-white shadow-lg rounded-xl p-8 text-center">

    <h1 class="text-3xl font-bold text-purple-600 mb-6">Hasil Pembayaran</h1>

    <p class="text-lg mb-4">Metode : <span class="font-semibold">{{ $metode }}</span></p>

    @if($status == 'berhasil')
        <h2 class="text-green-600 text-2xl font-semibold mb-4">✔️ Pembayaran Berhasil</h2>
    @elseif($status == 'pending')
        <h2 class="text-yellow-500 text-2xl font-semibold mb-4">⏳ Pembayaran Pending</h2>
    @elseif($status == 'gagal')
        <h2 class="text-red-500 text-2xl font-semibold mb-4">❌ Pembayaran Gagal</h2>
    @endif

    <a href="/dashboard-pengunjung"
       class="inline-block mt-6 bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-6 rounded-lg transition">
       Kembali ke Dashboard
    </a>

</div>

</body>
</html>