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
<body class="flex flex-col items-center py-10 font-sans antialiased text-gray-900">

    <div class="w-full max-w-[850px] mb-4 px-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm no-underline hover:opacity-80 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white w-full max-w-[850px] rounded-2xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        <div class="bg-[#24112e] p-8 text-white">
            <h1 class="text-2xl font-black uppercase tracking-tighter">Kelola Tiket Event</h1>
            <p class="text-sm text-[#be93d4] font-bold mt-1">{{ $event->judul }}</p>
        </div>

        <form action="{{ route('admin.acara.tiket.update', $event->id ?? 1) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8 p-4 bg-purple-50 border border-purple-100 rounded-xl flex items-center justify-between shadow-sm">
                <div>
                    <h3 class="text-[#7a4988] font-black text-xs uppercase tracking-widest">Total Kapasitas Terhitung</h3>
                    <p class="text-[10px] text-gray-500 font-medium">Otomatis menjumlahkan semua kuota tiket di bawah</p>
                </div>
                <div class="text-3xl font-black text-[#24112e]">
                    <span id="display_total">{{ $event->kapasitas }}</span> <span class="text-xs text-gray-400">Org</span>
                </div>
                <input type="hidden" name="kapasitas" id="input_total" value="{{ $event->kapasitas }}">
            </div>

            <div class="mb-10 p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="mb-4">
                    <h3 class="text-[#24112e] font-black text-sm uppercase tracking-widest mb-1 flex items-center gap-2">
                        Desain E-Ticket 
                        <span class="bg-[#be93d4]/20 text-[#7a4988] px-2 py-0.5 rounded text-[9px] tracking-widest font-black">OPSIONAL</span>
                    </h3>
                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Unggah template dasar tiket untuk event ini. Sistem akan otomatis mencetak nama peserta dan jenis tier tiket di atas gambar ini.</p>
                </div>
                
                <div class="w-full bg-purple-50/30 border-2 border-dashed border-[#be93d4] rounded-xl h-[200px] flex flex-col items-center justify-center p-4 relative text-center group hover:bg-purple-50 hover:border-[#7a4988] transition-all duration-300">
                    <input type="file" name="desain_tiket" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this, 'ticket_preview', 'ticket_placeholder')">
                    
                    <img id="ticket_preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover rounded-xl z-30 shadow-sm">
                    
                    <div id="ticket_placeholder" class="z-10 transition group-hover:scale-105 flex flex-col items-center">
                        <div class="bg-white p-3 rounded-full shadow-sm mb-3 group-hover:shadow-md transition-all">
                            <svg class="w-7 h-7 text-[#7a4988]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <p class="text-xs font-black text-[#24112e] uppercase tracking-wider mb-1">Klik atau Drag Desain Tiket</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Rasio 16:9 (Landscape) • Maks 2MB</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center space-x-4 mb-4">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-widest whitespace-nowrap">Tier Tiket Berbayar</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                @foreach(['early_bird' => 'Early Bird', 'vip' => 'VIP', 'normal' => 'Normal'] as $key => $label)
                <div class="bg-white p-5 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-4 items-end shadow-sm hover:border-[#be93d4] transition-colors">
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-[#7a4988] mb-2">{{ $label }}</label>
                        <input type="text" name="tiket[{{$key}}][nama]" value="{{ $event->tiket[$key]->nama ?? '' }}" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-800 outline-none focus:ring-1 focus:ring-[#7a4988]">
                    </div>
                    <div class="md:col-span-1 relative">
                        <label class="block text-[10px] font-black uppercase text-gray-500 mb-2">Harga (Rp)</label>
                        <span class="absolute left-3 bottom-3 text-sm text-gray-400 font-bold">Rp</span>
                        <input type="number" name="tiket[{{$key}}][harga]" value="{{ $event->tiket[$key]->harga ?? '' }}" class="w-full pl-9 pr-2 py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-800 outline-none focus:ring-1 focus:ring-[#7a4988]">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-gray-500 mb-2">Kuota Peserta</label>
                        <input type="number" name="tiket[{{$key}}][kuota]" value="{{ $event->tiket[$key]->kuota ?? 0 }}" class="kuota-input w-full p-2.5 border border-gray-400 bg-gray-50 rounded-lg text-sm font-black text-center text-[#24112e] outline-none focus:border-[#7a4988] focus:bg-white transition-colors" oninput="updateTotal()">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black uppercase text-gray-500 mb-2">Deskripsi Ringkas</label>
                        <input type="text" name="tiket[{{$key}}][deskripsi]" value="{{ $event->tiket[$key]->deskripsi ?? '' }}" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 outline-none focus:ring-1 focus:ring-[#7a4988]">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center justify-center px-10 py-2.5 bg-gray-100 text-gray-500 rounded font-black text-sm hover:bg-gray-200 transition uppercase tracking-widest no-underline border border-gray-200" 
                   style="text-decoration: none !important; font-size: 0.875rem;">
                   Batal
                </a>
                
                <button type="submit" 
                    class="inline-flex items-center justify-center px-10 py-2.5 bg-[#24112e] text-white rounded font-black text-sm hover:bg-black transition shadow-md uppercase tracking-widest border-none"
                    style="font-size: 0.875rem;">
                    Simpan Tiket
                </button>
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

        function previewImage(input, imgId, placeholderId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById(imgId);
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    const placeholder = document.getElementById(placeholderId);
                    if(placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>