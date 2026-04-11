<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Event</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="max-w-md w-full bg-white shadow-lg rounded-xl p-8">

    <h1 class="text-3xl font-bold text-purple-600 mb-6 text-center">Pendaftaran Event</h1>

    <form class="space-y-4">
        <!-- Nama -->
        <div>
            <label class="block mb-1 font-medium text-gray-700">Nama</label>
            <input type="text" placeholder="Nama"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>

        <!-- Pilihan Tiket -->
        <div>
            <label class="block mb-1 font-medium text-gray-700">Tipe Tiket</label>
            <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option>VIP</option>
                <option>Regular</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button type="submit"
                    class="bg-purple-500 hover:bg-purple-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                Daftar
            </button>
        </div>
    </form>

</div>

</body>
</html>