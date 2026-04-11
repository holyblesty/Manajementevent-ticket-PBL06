<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Pembayaran</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

    <h1 class="text-3xl font-bold text-purple-600 text-center mb-6">
        SIMULASI PEMBAYARAN
    </h1>

    <h3 class="text-xl font-semibold mb-4 text-center">
        Total : <span class="text-green-600">Rp 50.000</span>
    </h3>

    <form action="/pembayaran/proses" method="POST" class="space-y-6">
        @csrf

        <div>
            <h4 class="text-lg font-medium mb-2">Metode Pembayaran</h4>
            <div class="flex flex-col space-y-2">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="metode" value="Transfer Bank" class="form-radio text-blue-500">
                    <span>Transfer Bank</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="metode" value="QRIS" class="form-radio text-blue-500">
                    <span>QRIS</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="metode" value="E-Wallet" class="form-radio text-blue-500">
                    <span>E-Wallet</span>
                </label>
            </div>
        </div>

        <hr class="my-4 border-gray-300">

        <div>
            <h4 class="text-lg font-medium mb-2">Transfer Dummy</h4>
            <p class="text-gray-700">BCA : <span class="font-semibold">1234567890</span></p>
            <p class="text-gray-700">A/N EVENT</p>
        </div>

        <div>
            <h4 class="text-lg font-medium mb-2">Pilih Status Simulasi</h4>
            <div class="flex gap-4">
                <button type="submit" name="status" value="berhasil"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                    ✔️ Berhasil
                </button>

                <button type="submit" name="status" value="pending"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                    ⏳ Pending
                </button>

                <button type="submit" name="status" value="gagal"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                    ❌ Gagal
                </button>
            </div>
        </div>

    </form>

</div>

</body>
</html>