<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event Baru - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Kita definisikan keyframes-nya di sini */
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

    <div class="w-full max-w-[950px] mb-4 px-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm hover:opacity-80 transition no-underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white w-full max-w-[950px] rounded-xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#8b418b] p-6 text-white border-b-4 border-[#732e73]">
            <h1 class="text-xl font-bold uppercase tracking-tight text-white">Tambah Event Baru</h1>
            <p class="text-[11px] opacity-90 font-medium text-white">Lengkapi detail acara dan pengaturan tiket sekaligus</p>
        </div>

        <form action="{{ route('admin.acara.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
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
                        <textarea name="deskripsi" rows="5" placeholder="Ceritakan tentang event ini..." 
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
                                <option @if(old('kategori') == 'Hiburan') selected @endif>Hiburan</option>
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Lokasi *</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Aula Gedung Utama..." 
                                class="w-full p-2.5 border border-gray-400 rounded text-sm focus:ring-1 focus:ring-[#8b418b] outline-none font-medium text-gray-700">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kapasitas Maksimal *</label>
                            <div class="relative">
                                <input type="number" id="total_kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="0" 
                                    class="w-full p-2.5 border border-gray-400 rounded text-sm pr-10 outline-none focus:ring-1 focus:ring-[#8b418b] text-gray-700 font-medium">
                                <span class="absolute right-3 top-2.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-[250px] flex-shrink-0">
                    <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider">Poster Event *</label>
                    <div class="bg-gray-200 border border-gray-300 rounded-lg h-[300px] flex flex-col items-center justify-center p-6 relative text-center group shadow-inner overflow-hidden">
                        <input type="file" name="poster" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this)">
                        <div id="placeholder_view" class="z-10 transition group-hover:scale-105">
                            <div class="bg-[#8b418b] w-12 h-12 rounded-lg mx-auto flex items-center justify-center text-white mb-4 shadow-md">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-800 mb-1">Upload Poster</p>
                        </div>
                        <img id="image_preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover rounded-lg z-10">
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="px-10 py-2.5 bg-gray-100 text-gray-500 rounded font-bold text-sm uppercase tracking-widest border border-gray-200 no-underline">Batal</a>
                <button type="submit" class="px-10 py-2.5 bg-[#24112e] text-white rounded font-bold text-sm hover:bg-black transition shadow-md uppercase tracking-widest">Simpan Acara</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById('image_preview');
                    const placeholder = document.getElementById('placeholder_view');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>