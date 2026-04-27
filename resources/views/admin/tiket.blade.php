<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tiket - {{ $event->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: linear-gradient(135deg, #7a4988 0%, #be93d4 100%); min-height: 100vh; }
    </style>
</head>
<body class="flex flex-col items-center py-10 font-sans antialiased">

    <div class="w-full max-w-[850px] mb-4 px-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm no-underline hover:opacity-80">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white w-full max-w-[850px] rounded-2xl shadow-2xl overflow-hidden mb-10 mx-4">
        <div class="bg-[#24112e] p-8 text-white">
            <h1 class="text-2xl font-black uppercase tracking-tighter">Kelola Tiket Event</h1>
            <p class="text-sm text-[#be93d4] font-bold">{{ $event->judul }}</p>
        </div>

        <form action="#" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8 p-4 bg-purple-50 border border-purple-100 rounded-xl flex items-center justify-between">
                <div>
                    <h3 class="text-[#7a4988] font-black text-xs uppercase tracking-widest">Total Kapasitas Terhitung</h3>
                    <p class="text-[10px] text-gray-500 font-medium">Otomatis menjumlahkan semua kuota tiket di bawah</p>
                </div>
                <div class="text-3xl font-black text-[#24112e]">
                    <span id="display_total">{{ $event->kapasitas }}</span> <span class="text-xs text-gray-400">Org</span>
                </div>
                <input type="hidden" name="kapasitas" id="input_total" value="{{ $event->kapasitas }}">
            </div>

            <div class="space-y-4">
                @foreach(['early_bird' => 'Early Bird', 'vip' => 'VIP', 'normal' => 'Normal'] as $key => $label)
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-[#7a4988] mb-2">{{ $label }}</label>
                        <input type="text" value="{{ $event->tiket[$key]->nama }}" class="w-full p-2 border border-gray-300 rounded-lg text-sm font-bold outline-none focus:border-[#7a4988]">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2">Harga (Rp)</label>
                        <input type="number" value="{{ $event->tiket[$key]->harga }}" class="w-full p-2 border border-gray-300 rounded-lg text-sm font-bold outline-none focus:border-[#7a4988]">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2">Kuota</label>
                        <input type="number" value="{{ $event->tiket[$key]->kuota }}" class="kuota-input w-full p-2 border border-[#7a4988] bg-white rounded-lg text-sm font-black text-center outline-none" oninput="updateTotal()">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2">Deskripsi</label>
                        <input type="text" value="{{ $event->tiket[$key]->deskripsi }}" class="w-full p-2 border border-gray-300 rounded-lg text-sm outline-none focus:border-[#7a4988]">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="px-8 py-3 bg-gray-100 text-gray-500 rounded-xl font-black text-xs uppercase tracking-widest no-underline">Batal</a>
                <button type="submit" class="px-8 py-3 bg-[#24112e] text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-lg hover:bg-black transition">Simpan Tiket</button>
            </div>
        </form>
    </div>

    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.kuota-input').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('display_total').innerText = total;
            document.getElementById('input_total').value = total;
        }
    </script>
</body>
</html>