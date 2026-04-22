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
            
            <div class="flex flex-row items-start gap-10">
                
                <div class="flex-grow space-y-5">
                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Event *</label>
                        <input type="text" name="judul" placeholder="Contoh: Seminar Teknologi Kampus 2026" 
                            class="w-full p-2.5 border border-gray-400 rounded focus:ring-1 focus:ring-[#8b418b] outline-none text-sm font-medium transition text-gray-700">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi *</label>
                        <textarea name="deskripsi" rows="6" placeholder="Ceritakan tentang event ini..." 
                            class="w-full p-2.5 border border-gray-400 rounded focus:ring-1 focus:ring-[#8b418b] outline-none text-sm leading-relaxed text-gray-700"></textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal *</label>
                            <input type="date" name="tanggal" class="w-full p-2.5 border border-gray-400 rounded text-xs text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori *</label>
                            <select name="kategori" class="w-full p-2.5 border border-gray-400 rounded text-xs text-gray-500 outline-none font-medium">
                                <option value="">Pilih Kategori</option>
                                <option>Olahraga</option>
                                <option>Seminar</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Event *</label>
                            <div class="flex border border-gray-400 rounded overflow-hidden h-[38px]">
                                <label class="flex-1 flex items-center justify-center cursor-pointer">
                                    <input type="radio" name="jenis" value="tim" class="hidden peer">
                                    <span class="w-full h-full flex items-center justify-center text-[10px] font-bold peer-checked:bg-gray-200 text-gray-700">Tim</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center cursor-pointer border-l border-gray-400">
                                    <input type="radio" name="jenis" value="individu" class="hidden peer" checked>
                                    <span class="w-full h-full flex items-center justify-center text-[10px] font-bold peer-checked:bg-gray-200 text-gray-700">Individu</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Lokasi *</label>
                        <input type="text" name="lokasi" placeholder="Contoh: Aula Gedung Utama..." 
                            class="w-full p-2.5 border border-gray-400 rounded text-sm focus:ring-1 focus:ring-[#8b418b] outline-none font-medium text-gray-700">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700 uppercase tracking-wider">Kapasitas Peserta *</label>
                        <div class="relative max-w-[200px]">
                            <input type="number" name="kapasitas" placeholder="50" 
                                class="w-full p-2.5 border border-gray-400 rounded text-sm pr-10 outline-none text-gray-700 font-medium">
                            <span class="absolute right-3 top-2.5 text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="w-[250px] flex-shrink-0">
                    <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider">Poster Event</label>
                    <div class="bg-gray-200 border border-gray-300 rounded-lg h-[350px] flex flex-col items-center justify-center p-6 relative text-center group shadow-inner">
                        <input type="file" name="poster" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this)">
                        
                        <div id="placeholder_view" class="z-10 transition group-hover:scale-105">
                            <div class="bg-[#8b418b] w-12 h-12 rounded-lg mx-auto flex items-center justify-center text-white mb-4 shadow-md text-white">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-800 mb-1">Klik untuk upload poster</p>
                            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest">JPG, PNG : MAKS 5 MB</p>
                        </div>
                        <img id="image_preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover rounded-lg z-30">
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-widest whitespace-nowrap">Jenis tiket</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <div class="flex space-x-3 mb-6">
                    <button type="button" onclick="toggleTipe(false)" id="btn_gratis" class="px-10 py-2 border border-gray-400 rounded font-bold text-xs bg-gray-300 text-gray-700 transition shadow-sm uppercase tracking-widest">Gratis</button>
                    <button type="button" onclick="toggleTipe(true)" id="btn_berbayar" class="px-10 py-2 border border-gray-400 rounded font-bold text-xs bg-white text-gray-700 transition shadow-sm uppercase tracking-widest">Berbayar</button>
                </div>

                <div id="info_gratis" class="border border-gray-300 rounded-lg p-5 bg-white shadow-inner">
                    <h3 class="text-[#8b418b] font-bold text-sm mb-1">Tiket gratis</h3>
                    <p class="text-red-700 text-[11px] leading-relaxed font-medium">Peserta dapat mendaftar tanpa biaya. Kuota diatur dari field kapasitas di atas.</p>
                </div>

                <div id="info_berbayar" class="hidden border border-gray-300 rounded-lg p-5">
                    <p class="text-xs text-gray-500 italic font-medium">Silakan atur harga tiket.</p>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="px-10 py-2.5 bg-gray-500 text-white rounded font-bold text-xs hover:bg-gray-600 transition shadow uppercase tracking-widest text-white">Batal</a>
                <button type="submit" class="px-10 py-2.5 bg-gray-200 text-gray-700 border border-gray-400 rounded font-bold text-xs hover:bg-gray-300 transition shadow uppercase tracking-widest">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        function toggleTipe(isPaid) {
            const btnG = document.getElementById('btn_gratis');
            const btnB = document.getElementById('btn_berbayar');
            const infoG = document.getElementById('info_gratis');
            const infoB = document.getElementById('info_berbayar');

            if(isPaid) {
                btnB.classList.replace('bg-white', 'bg-gray-300');
                btnG.classList.replace('bg-gray-300', 'bg-white');
                infoG.classList.add('hidden');
                infoB.classList.remove('hidden');
            } else {
                btnG.classList.replace('bg-white', 'bg-gray-300');
                btnB.classList.replace('bg-gray-300', 'bg-white');
                infoB.classList.add('hidden');
                infoG.classList.remove('hidden');
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById('image_preview');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    document.getElementById('placeholder_view').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>