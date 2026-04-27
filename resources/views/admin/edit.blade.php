<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Event - {{ $event->judul }}</title>
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
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white font-bold text-sm hover:opacity-80 transition no-underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white w-full max-w-[950px] rounded-xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#8b418b] p-6 text-white border-b-4 border-[#732e73]">
            <h1 class="text-xl font-bold uppercase tracking-tight text-white">Ubah Informasi Event</h1>
            <p class="text-[11px] opacity-90 font-medium text-white">Pastikan data acara dan media (poster/tiket) sudah benar.</p>
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
                                <input type="number" name="kapasitas" value="{{ $event->kapasitas }}" placeholder="50" 
                                    class="w-full p-2.5 border border-gray-400 rounded text-sm pr-10 outline-none focus:ring-1 focus:ring-[#8b418b] text-gray-700 font-medium">
                                <span class="absolute right-3 top-2.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                                </span>
                            </div>
                            <p class="text-[9px] text-red-500 mt-1 font-bold italic">*Mengubah ini wajib mengatur ulang kuota di menu TIKET.</p>
                        </div>
                    </div>
                </div>

                <div class="w-[250px] flex-shrink-0 space-y-6">
                    
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider">Poster Event *</label>
                        <div class="bg-gray-200 border border-gray-300 rounded-lg h-[300px] flex flex-col items-center justify-center p-6 relative text-center group shadow-inner">
                            <input type="file" name="poster" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this, 'image_preview_poster', 'placeholder_view_poster')">
                            
                            <img id="image_preview_poster" src="{{ asset('images/' . $event->poster) }}" class="absolute inset-0 w-full h-full object-cover rounded-lg z-30">
                            
                            <div id="placeholder_view_poster" class="hidden z-10 transition group-hover:scale-105">
                                <div class="bg-[#8b418b] w-12 h-12 rounded-lg mx-auto flex items-center justify-center text-white mb-4 shadow-md text-white">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <p class="text-xs font-bold text-gray-800 mb-1">Klik untuk ganti poster</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center justify-between">
                            Desain E-Ticket
                            <span class="bg-[#be93d4]/20 text-[#7a4988] px-1.5 py-0.5 rounded text-[8px] font-black tracking-widest">OPSIONAL</span>
                        </label>
                        <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg h-[130px] flex flex-col items-center justify-center p-4 relative text-center group hover:bg-gray-200 hover:border-[#8b418b] transition-all duration-300">
                            <input type="file" name="desain_tiket" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this, 'image_preview_tiket', 'placeholder_view_tiket')">
                            
                            <img id="image_preview_tiket" src="#" class="hidden absolute inset-0 w-full h-full object-cover rounded-lg z-30">
                            
                            <div id="placeholder_view_tiket" class="z-10 transition group-hover:scale-105">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-[#8b418b] transition-colors mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-[#8b418b]">Upload Desain</p>
                            </div>
                        </div>
                        <p class="mt-2 text-[9px] text-gray-500 font-medium uppercase text-center italic">* Rasio 16:9 (Landscape)</p>
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