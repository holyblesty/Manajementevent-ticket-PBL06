<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event Baru - Presisi Mockup</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #7a4988 0%, #be93d4 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex flex-col items-center py-10 font-sans antialiased text-gray-900">

    <div class="w-full max-w-[950px] mb-4 px-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm hover:opacity-80 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white w-full max-w-[950px] rounded-xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#8b418b] p-6 text-white border-b-4 border-[#732e73]">
            <h1 class="text-xl font-bold uppercase tracking-tight text-white">Tambah Event Baru</h1>
            <p class="text-[11px] opacity-90 font-medium text-white">Isi semua informasi event sebelum dipublikasikan</p>
        </div>

        <form action="{{ route('admin.acara.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            {{-- Input tersembunyi untuk merekam status "Gratis" atau "Berbayar" --}}
            <input type="hidden" name="jenis_tiket" id="input_jenis_tiket" value="{{ old('jenis_tiket', 'gratis') }}">

            <div class="flex flex-row items-start gap-10">
                
                <div class="flex-grow space-y-5">
                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Event *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Seminar Teknologi Kampus 2026" 
                            class="w-full p-2.5 border border-gray-400 rounded focus:ring-1 focus:ring-[#8b418b] outline-none text-sm font-medium transition text-gray-700">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi *</label>
                        <textarea name="deskripsi" rows="6" placeholder="Ceritakan tentang event ini..." 
                            class="w-full p-2.5 border border-gray-400 rounded focus:ring-1 focus:ring-[#8b418b] outline-none text-sm leading-relaxed text-gray-700">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal *</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full p-2.5 border border-gray-400 rounded text-xs text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori *</label>
                            <select name="kategori" class="w-full p-2.5 border border-gray-400 rounded text-xs text-gray-500 outline-none font-medium">
                                <option value="">Pilih Kategori</option>
                                <option @if(old('kategori') == 'Olahraga') selected @endif>Olahraga</option>
                                <option @if(old('kategori') == 'Seminar') selected @endif>Seminar</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Event *</label>
                            <div class="flex border border-gray-400 rounded overflow-hidden h-[38px]">
                                <label class="flex-1 flex items-center justify-center cursor-pointer">
                                    <input type="radio" name="jenis" value="tim" class="hidden peer" @if(old('jenis') == 'tim') checked @endif>
                                    <span class="w-full h-full flex items-center justify-center text-[10px] font-bold peer-checked:bg-gray-200 text-gray-700">Tim</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center cursor-pointer border-l border-gray-400">
                                    <input type="radio" name="jenis" value="individu" class="hidden peer" @if(old('jenis', 'individu') == 'individu') checked @endif>
                                    <span class="w-full h-full flex items-center justify-center text-[10px] font-bold peer-checked:bg-gray-200 text-gray-700">Individu</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Lokasi *</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Aula Gedung Utama..." 
                            class="w-full p-2.5 border border-gray-400 rounded text-sm focus:ring-1 focus:ring-[#8b418b] outline-none font-medium text-gray-700">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kapasitas Peserta *</label>
                        <div class="relative max-w-[200px]">
                            <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="50" 
                                class="w-full p-2.5 border border-gray-400 rounded text-sm pr-10 outline-none text-gray-700 font-medium">
                            <span class="absolute right-3 top-2.5 text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="w-[250px] flex-shrink-0">
                    <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider">Poster Event</label>
                    <div class="bg-gray-200 border border-gray-300 rounded-lg h-[350px] flex flex-col items-center justify-center p-6 relative text-center group shadow-inner overflow-hidden">
                        
                        <input type="file" name="poster" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this)">
                        
                        <div id="placeholder_view" class="z-10 transition group-hover:scale-105">
                            <div class="bg-[#8b418b] w-12 h-12 rounded-lg mx-auto flex items-center justify-center text-white mb-4 shadow-md">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-800 mb-1">Klik untuk upload poster</p>
                            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest">JPG, PNG : MAKS 5 MB</p>
                        </div>

                        <img id="image_preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover rounded-lg z-10 transition group-hover:scale-105">
                        
                        <div id="overlay_change" class="hidden absolute inset-0 bg-black/50 z-15 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded-lg pointer-events-none">
                            <span class="text-white text-xs font-bold uppercase tracking-wider">Ganti Gambar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-widest whitespace-nowrap">Jenis tiket</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                {{-- Status Berbayar dari fungsi old() --}}
                @php $isPaid = old('jenis_tiket') == 'berbayar'; @endphp

                <div class="flex space-x-3 mb-6">
                    <button type="button" onclick="toggleTipe(false)" id="btn_gratis" class="px-10 py-2 border border-gray-400 rounded font-bold text-xs {{ $isPaid ? 'bg-gray-300 text-gray-700' : 'bg-white text-gray-700' }} transition shadow-sm uppercase tracking-widest">Gratis</button>
                    <button type="button" onclick="toggleTipe(true)" id="btn_berbayar" class="px-10 py-2 border border-gray-400 rounded font-bold text-xs {{ $isPaid ? 'bg-white text-gray-700' : 'bg-gray-300 text-gray-700' }} transition shadow-sm uppercase tracking-widest">Berbayar</button>
                </div>

                <div id="info_gratis" class="{{ $isPaid ? 'hidden' : '' }} border border-gray-300 rounded-lg p-5 bg-white shadow-inner">
                    <h3 class="text-[#8b418b] font-bold text-sm mb-1">Tiket gratis</h3>
                    <p class="text-red-700 text-[11px] leading-relaxed font-medium">Peserta dapat mendaftar tanpa biaya. Kuota diatur dari field kapasitas di atas.</p>
                </div>

                <div id="info_berbayar" class="{{ $isPaid ? '' : 'hidden' }} border border-gray-300 rounded-lg p-6 bg-white shadow-sm">
                    <div class="grid grid-cols-[40px_1.5fr_2.5fr_1.5fr_80px] gap-4 mb-3 px-2">
                        <div></div> <div class="text-sm font-bold text-gray-800 text-center">Nama tier</div>
                        <div class="text-sm font-bold text-gray-800 text-center">Deskripsi</div>
                        <div class="text-sm font-bold text-gray-800 text-center">Harga</div>
                        <div class="text-sm font-bold text-gray-800 text-center">Kuota</div>
                    </div>

                    <div class="bg-gray-200 rounded-lg p-3 mb-3 grid grid-cols-[40px_1.5fr_2.5fr_1.5fr_80px] gap-4 items-start border border-gray-300">
                        <div class="flex justify-center items-center h-10">
                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2L3 14h7v8l10-12h-7V2z"/></svg>
                        </div>
                        <div>
                            <input type="text" name="tiket[early_bird][nama]" value="{{ old('tiket.early_bird.nama', 'Early Bird') }}" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-800 focus:ring-1 focus:ring-[#7a4988] outline-none">
                            <p class="text-[10px] mt-1 text-gray-600 font-medium">Harga special awal</p>
                        </div>
                        <div>
                            <input type="text" name="tiket[early_bird][deskripsi]" value="{{ old('tiket.early_bird.deskripsi') }}" placeholder="Contoh Harga spesial untuk 50 pembeli pertama" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-500 focus:ring-1 focus:ring-[#7a4988] outline-none placeholder-gray-400">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-sm text-gray-400">Rp</span>
                            <input type="number" name="tiket[early_bird][harga]" value="{{ old('tiket.early_bird.harga') }}" class="w-full pl-9 pr-2 py-2 border border-gray-400 rounded text-sm text-gray-800 focus:ring-1 focus:ring-[#7a4988] outline-none">
                        </div>
                        <div>
                            <input type="number" name="tiket[early_bird][kuota]" value="{{ old('tiket.early_bird.kuota', 1) }}" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-800 text-center focus:ring-1 focus:ring-[#7a4988] outline-none">
                        </div>
                    </div>

                    <div class="bg-gray-200 rounded-lg p-3 mb-3 grid grid-cols-[40px_1.5fr_2.5fr_1.5fr_80px] gap-4 items-start border border-gray-300">
                        <div class="flex justify-center items-center h-10">
                            <svg class="w-7 h-7 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                        </div>
                        <div>
                            <input type="text" name="tiket[vip][nama]" value="{{ old('tiket.vip.nama', 'Vip') }}" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-800 focus:ring-1 focus:ring-[#7a4988] outline-none">
                            <p class="text-[10px] mt-1 text-gray-600 font-medium">Akses premium</p>
                        </div>
                        <div>
                            <input type="text" name="tiket[vip][deskripsi]" value="{{ old('tiket.vip.deskripsi') }}" placeholder="Contoh Kursi depan + merchandise eksklusif" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-500 focus:ring-1 focus:ring-[#7a4988] outline-none placeholder-gray-400">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-sm text-gray-400">Rp</span>
                            <input type="number" name="tiket[vip][harga]" value="{{ old('tiket.vip.harga') }}" class="w-full pl-9 pr-2 py-2 border border-gray-400 rounded text-sm text-gray-800 focus:ring-1 focus:ring-[#7a4988] outline-none">
                        </div>
                        <div>
                            <input type="number" name="tiket[vip][kuota]" value="{{ old('tiket.vip.kuota', 1) }}" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-800 text-center focus:ring-1 focus:ring-[#7a4988] outline-none">
                        </div>
                    </div>

                    <div class="bg-gray-200 rounded-lg p-3 grid grid-cols-[40px_1.5fr_2.5fr_1.5fr_80px] gap-4 items-start border border-gray-300">
                        <div class="flex justify-center items-center h-10 transform -rotate-45">
                            <svg class="w-7 h-7 text-black" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/></svg>
                        </div>
                        <div>
                            <input type="text" name="tiket[normal][nama]" value="{{ old('tiket.normal.nama', 'Normal') }}" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-800 focus:ring-1 focus:ring-[#7a4988] outline-none">
                            <p class="text-[10px] mt-1 text-gray-600 font-medium">Tiket Reguler</p>
                        </div>
                        <div>
                            <input type="text" name="tiket[normal][deskripsi]" value="{{ old('tiket.normal.deskripsi') }}" placeholder="Contoh Akses semua sesi umum" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-500 focus:ring-1 focus:ring-[#7a4988] outline-none placeholder-gray-400">
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-sm text-gray-400">Rp</span>
                            <input type="number" name="tiket[normal][harga]" value="{{ old('tiket.normal.harga') }}" class="w-full pl-9 pr-2 py-2 border border-gray-400 rounded text-sm text-gray-800 focus:ring-1 focus:ring-[#7a4988] outline-none">
                        </div>
                        <div>
                            <input type="number" name="tiket[normal][kuota]" value="{{ old('tiket.normal.kuota', 1) }}" class="w-full p-2 border border-gray-400 rounded text-sm text-gray-800 text-center focus:ring-1 focus:ring-[#7a4988] outline-none">
                        </div>
                    </div>
                </div>
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
        TAMBAH
    </button>
</div>
        </form>
    </div>

    <script>
        function toggleTipe(isPaid) {
            const btnG = document.getElementById('btn_gratis');
            const btnB = document.getElementById('btn_berbayar');
            const infoG = document.getElementById('info_gratis');
            const infoB = document.getElementById('info_berbayar');
            const inputJenis = document.getElementById('input_jenis_tiket');

            if(isPaid) {
                btnB.classList.replace('bg-gray-300', 'bg-white');
                btnG.classList.replace('bg-white', 'bg-gray-300');
                infoG.classList.add('hidden');
                infoB.classList.remove('hidden');
                inputJenis.value = 'berbayar';
            } else {
                btnG.classList.replace('bg-gray-300', 'bg-white');
                btnB.classList.replace('bg-white', 'bg-gray-300');
                infoB.classList.add('hidden');
                infoG.classList.remove('hidden');
                inputJenis.value = 'gratis';
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById('image_preview');
                    const placeholder = document.getElementById('placeholder_view');
                    const overlay = document.getElementById('overlay_change');
                    
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    
                    overlay.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>