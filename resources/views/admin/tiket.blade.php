<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tiket - {{ $event->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .no-underline { text-decoration: none !important; }
    </style>
</head>
<body 
    style="
        margin: 0; 
        min-height: 100vh; 
        background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); 
        background-size: 400% 400%; 
        animation: swush 10s ease infinite;
    "
    class="flex flex-col items-center py-10 font-sans antialiased text-gray-900"
>

    <div class="w-full max-w-[850px] mb-4 px-4 text-left">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm no-underline hover:opacity-80 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white w-full max-w-[850px] rounded-2xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-white">Kelola Tiket & Desain</h1>
            <p class="text-sm text-[#be93d4] font-bold mt-1 uppercase tracking-widest text-[#be93d4]">{{ $event->judul }}</p>
        </div>

        <form action="{{ route('admin.acara.tiket.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8 p-6 bg-purple-50 border-2 border-dashed border-purple-200 rounded-2xl flex items-center justify-between shadow-inner">
                <div>
                    <h3 class="text-[#7a4988] font-black text-xs uppercase tracking-widest">Total Kapasitas Terhitung</h3>
                    <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Akumulasi otomatis dari 3 tier tiket</p>
                </div>
                <div class="text-4xl font-black text-[#24112e]">
                    <span id="display_total">{{ $event->kapasitas }}</span> <span class="text-xs text-gray-400 font-bold uppercase">Org</span>
                </div>
                <input type="hidden" name="kapasitas" id="input_total" value="{{ $event->kapasitas }}">
            </div>

            <div class="mb-10 p-6 bg-gray-50/50 border border-gray-200 rounded-2xl shadow-sm">
                <div class="mb-5 text-center">
                    <h3 class="text-[#24112e] font-black text-sm uppercase tracking-widest mb-1">E-Ticket Design</h3>
                    <p class="text-[11px] text-gray-500 font-bold uppercase tracking-tighter">Unggah desain berbeda untuk event ini (Rasio 16:9)</p>
                </div>
                
                <div class="w-full bg-white border-2 border-dashed border-gray-300 rounded-xl h-[240px] flex flex-col items-center justify-center p-4 relative text-center group hover:border-[#7a4988] transition-all duration-300 overflow-hidden shadow-inner cursor-pointer">
                    <input type="file" name="desain_tiket" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this, 'ticket_preview', 'ticket_placeholder')">
                    
                    <img id="ticket_preview" src="{{ $event->desain_tiket ? asset('storage/'.$event->desain_tiket) : '#' }}" class="{{ $event->desain_tiket ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-30">
                    
                    <div id="ticket_placeholder" class="{{ $event->desain_tiket ? 'hidden' : '' }} z-10 flex flex-col items-center group-hover:scale-110 transition-transform">
                        <div class="bg-purple-100 p-4 rounded-2xl mb-3 text-[#7a4988]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-xs font-black text-[#24112e] uppercase tracking-wider">Klik untuk Upload Desain Tiket</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-xs font-black text-[#7a4988] uppercase tracking-[0.3em] whitespace-nowrap">Konfigurasi Kuota & Harga</span>
                    <div class="flex-grow border-t-2 border-gray-100"></div>
                </div>

                @foreach(['early_bird' => 'Early Bird', 'normal' => 'Normal', 'vip' => 'VIP'] as $key => $label)
                <div class="bg-gray-50/50 p-5 rounded-2xl border-2 border-gray-100 grid grid-cols-1 md:grid-cols-3 gap-6 items-end hover:border-[#be93d4] transition-all">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-[#7a4988] mb-2 tracking-widest">Nama Tier (Locked)</label>
                        <input type="text" value="{{ $label }}" readonly class="w-full p-3 border-2 border-gray-200 rounded-xl text-xs font-black text-gray-400 uppercase bg-gray-100 cursor-not-allowed outline-none">
                        <input type="hidden" name="tiket[{{$key}}][nama]" value="{{ $label }}">
                    </div>
                    <div class="relative">
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Harga (Rp)</label>
                        <span class="absolute left-3 bottom-3.5 text-xs text-[#be93d4] font-black">RP</span>
                        <input type="number" name="tiket[{{$key}}][harga]" value="{{ $event->tiket[$key]->harga ?? 0 }}" class="w-full pl-10 pr-2 py-3 border-2 border-gray-200 rounded-xl text-xs font-black text-gray-800 outline-none focus:border-[#7a4988] bg-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Kuota Peserta</label>
                        <input type="number" name="tiket[{{$key}}][kuota]" value="{{ $event->tiket[$key]->kuota ?? 0 }}" class="kuota-input w-full p-3 border-2 border-[#7a4988] bg-white rounded-xl text-sm font-black text-center text-[#7a4988] outline-none shadow-sm focus:ring-2 focus:ring-purple-200" oninput="updateTotal()">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-end gap-4 pt-8 border-t-2 border-gray-50">
                <a href="{{ route('admin.dashboard') }}" class="px-10 py-3 bg-white text-gray-400 rounded-xl font-black text-xs uppercase tracking-widest border-2 border-gray-100 hover:bg-gray-50 transition no-underline">Batal</a>
                <button type="submit" class="px-12 py-3 bg-[#24112e] text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black transition shadow-xl hover:-translate-y-1 transition-all border-none">Simpan Tiket</button>
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