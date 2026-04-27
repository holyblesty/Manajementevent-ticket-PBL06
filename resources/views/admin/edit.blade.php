<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Event - {{ $event->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Definisi gerakan "angin" ungu swush-swush */
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Memastikan link tidak punya garis bawah */
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

    <div class="w-full max-w-[950px] mb-4 px-4 text-left">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm hover:opacity-80 transition no-underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white w-full max-w-[950px] rounded-xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
      <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-white">Ubah Informasi Event</h1>
            <p class="text-sm text-[#be93d4] font-bold mt-1 uppercase tracking-widest">Pastikan data acara dan media sudah benar</p>
        </div>

        <form action="{{ route('admin.acara.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <div class="flex flex-row items-start gap-10">
                
                <div class="flex-grow space-y-5">
                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Event *</label>
                        <input type="text" name="judul" value="{{ $event->judul }}" placeholder="Contoh: Seminar Teknologi Kampus 2026" 
                            class="w-full p-2.5 border border-gray-400 rounded focus:ring-1 focus:ring-[#8b418b] outline-none text-sm font-medium transition text-gray-700">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi *</label>
                        <textarea name="deskripsi" rows="6" placeholder="Ceritakan tentang event ini..." 
                            class="w-full p-2.5 border border-gray-400 rounded focus:ring-1 focus:ring-[#8b418b] outline-none text-sm leading-relaxed text-gray-700">{{ $event->deskripsi }}</textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal *</label>
                            <input type="date" name="tanggal" value="{{ $event->tanggal }}" class="w-full p-2.5 border border-gray-400 rounded text-xs text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori *</label>
                            <select name="kategori" class="w-full p-2.5 border border-gray-400 rounded text-xs text-gray-500 outline-none font-medium">
                                <option value="Olahraga" {{ $event->kategori == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                <option value="Seminar" {{ $event->kategori == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Hiburan" {{ $event->kategori == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Event *</label>
                            <div class="flex border border-gray-400 rounded overflow-hidden h-[38px]">
                                <label class="flex-1 flex items-center justify-center cursor-pointer">
                                    <input type="radio" name="jenis" value="tim" class="hidden peer" {{ $event->jenis == 'tim' ? 'checked' : '' }}>
                                    <span class="w-full h-full flex items-center justify-center text-[10px] font-bold peer-checked:bg-gray-200 text-gray-700 transition-all">Tim</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center cursor-pointer border-l border-gray-400">
                                    <input type="radio" name="jenis" value="individu" class="hidden peer" {{ $event->jenis == 'individu' ? 'checked' : '' }}>
                                    <span class="w-full h-full flex items-center justify-center text-[10px] font-bold peer-checked:bg-gray-200 text-gray-700 transition-all">Individu</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Lokasi *</label>
                            <input type="text" name="lokasi" value="{{ $event->lokasi }}" placeholder="Contoh: Aula Gedung Utama..." 
                                class="w-full p-2.5 border border-gray-400 rounded text-sm focus:ring-1 focus:ring-[#8b418b] outline-none font-medium text-gray-700">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kapasitas Maksimal *</label>
                            <div class="relative">
                                <input type="number" 
                                    id="total_kapasitas" 
                                    name="kapasitas" 
                                    value="{{ $event->kapasitas }}" 
                                    placeholder="0" 
                                    readonly
                                    class="w-full p-2.5 border border-gray-300 rounded text-sm pr-10 outline-none bg-gray-100 cursor-not-allowed text-gray-500 font-bold">
                                <span class="absolute right-3 top-2.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                                </span>
                            </div>
                            <p class="text-[9px] text-[#7a4988] mt-1 font-bold italic uppercase tracking-tighter">* Otomatis dihitung berdasarkan total kuota tiket</p>
                        </div>
                    </div>
                </div>

                <div class="w-[250px] flex-shrink-0">
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider">Poster Event *</label>
                        <div class="bg-gray-200 border border-gray-300 rounded-lg h-[300px] flex flex-col items-center justify-center p-6 relative text-center group shadow-inner overflow-hidden cursor-pointer">
                            
                            <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" onchange="previewImage(this, 'image_preview_poster', 'placeholder_view_poster')">
                            
                            <img id="image_preview_poster" src="{{ asset('images/' . $event->poster) }}" class="absolute inset-0 w-full h-full object-cover z-30 group-hover:opacity-40 transition-opacity duration-300">
                            
                            <div class="absolute inset-0 flex flex-col items-center justify-center z-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                <div class="bg-black/60 text-white px-4 py-2 rounded-lg backdrop-blur-sm">
                                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <p class="text-[10px] font-black uppercase tracking-widest">Ganti Poster</p>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-[9px] text-gray-500 font-medium uppercase text-center italic">* Klik poster untuk mengganti gambar</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center justify-center px-10 py-2.5 bg-gray-100 text-gray-500 rounded font-black text-sm hover:bg-gray-200 transition uppercase tracking-widest no-underline border border-gray-200">
                   Batal
                </a>
                
                <button type="submit" 
                    class="inline-flex items-center justify-center px-10 py-2.5 bg-[#24112e] text-white rounded font-black text-sm hover:bg-black transition shadow-md uppercase tracking-widest border-none">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
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