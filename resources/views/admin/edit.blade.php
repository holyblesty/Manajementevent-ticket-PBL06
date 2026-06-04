<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Event - {{ $event->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .no-underline { text-decoration: none !important; }
        .form-container { min-width: 650px; }
        .poster-container { min-width: 280px; max-width: 300px; }
    </style>
</head>
<body style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="flex flex-col items-center py-10 font-sans antialiased text-gray-900">

    <div class="bg-white w-full max-w-[1200px] rounded-[2.5rem] shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-white">Ubah Informasi Event</h1>
            <p class="text-xs text-[#be93d4] font-bold mt-1 uppercase tracking-widest">{{ $event->judul }}</p>
        </div>

        <form action="{{ route('admin.acara.update', $event->id_event) }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            @method('PUT')

            <div class="flex flex-row items-start gap-12">
                
                <div class="form-container flex-1 space-y-6">
                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Judul Event</label>
                        <input type="text" name="judul" value="{{ $event->judul }}" 
                               class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Deskripsi Event</label>
                        <textarea name="deskripsi" rows="6" 
                                  class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-medium text-gray-700 focus:border-[#7a4988] outline-none transition-all leading-relaxed">{{ $event->deskripsi }}</textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-gray-400 tracking-widest">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $event->tanggal }}" 
                                   class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-gray-400 tracking-widest">Kategori</label>
                            <select name="kategori" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none cursor-pointer">
                                <option value="Olahraga" {{ $event->kategori == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                <option value="Seminar" {{ $event->kategori == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Hiburan" {{ $event->kategori == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ $event->lokasi }}" 
                                   class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none">
                        </div>
                    </div>
                </div>

                <div class="poster-container space-y-4">
                    <label class="block text-[10px] font-black uppercase text-[#7a4988] tracking-widest text-center">Poster Event</label>
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] h-[400px] w-full flex flex-col items-center justify-center relative text-center group overflow-hidden cursor-pointer hover:border-[#7a4988] transition-all">
                        <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" onchange="previewImage(this, 'image_preview_poster')">
                        <img id="image_preview_poster" src="{{ asset('images/' . $event->poster) }}" 
                             class="absolute inset-0 w-full h-full object-cover z-30 group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center z-40 opacity-0 group-hover:opacity-100 transition-opacity">
                            <p class="text-[9px] font-black text-white uppercase tracking-widest">Ganti Poster</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-12 flex justify-end gap-3 pt-8 border-t-2 border-gray-50">
                <a href="{{ route('admin.dashboard') }}" class="px-8 py-4 bg-white text-gray-400 rounded-2xl font-black text-[10px] uppercase tracking-widest border-2 border-gray-100 hover:bg-gray-50 transition no-underline">Batal</a>
                <button type="submit" class="px-12 py-4 bg-[#24112e] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition shadow-xl hover:-translate-y-1 border-none cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input, imgId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById(imgId);
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>