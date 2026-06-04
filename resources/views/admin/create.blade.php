<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event Baru - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .no-underline { text-decoration: none !important; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
    </style>
</head>
<body style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="flex flex-col items-center py-10 font-sans antialiased text-gray-900">

    <div class="bg-white w-full max-w-[1100px] rounded-[2.5rem] shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988] flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tighter">Tambah Event Baru</h1>
                <p class="text-[10px] text-[#be93d4] font-bold mt-1 uppercase tracking-[0.3em]">Detail Informasi & Media Acara</p>
            </div>
            <div class="hidden md:block bg-[#7a4988]/20 px-4 py-2 rounded-xl border border-[#7a4988]/30">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#be93d4]">
                    <span class="text-white text-lg leading-none mr-1">*</span> Wajib diisi
                </p>
            </div>
        </div>

        <form action="{{ route('admin.acara.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf

            <div class="flex flex-row items-start gap-12">
                
                <div class="flex-[2.5] space-y-6">
                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Judul Event <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan nama event..." 
                               class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all shadow-sm">
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="6" placeholder="Jelaskan detail acaranya..." 
                                  class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-medium text-gray-700 focus:border-[#7a4988] outline-none transition-all leading-relaxed shadow-sm">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-gray-400 tracking-widest">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" 
                                   class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none shadow-sm">
                        </div>
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-gray-400 tracking-widest">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none cursor-pointer shadow-sm">
                                <option value="">Pilih Kategori</option>
                                <option value="Olahraga" {{ old('kategori') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                <option value="Seminar" {{ old('kategori') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Hiburan" {{ old('kategori') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Tempat acara..." 
                               class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none shadow-sm">
                    </div>
                </div>

                <div class="flex-1 min-w-[280px] space-y-6">
                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest text-center">Poster Event <span class="text-red-500">*</span></label>
                        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] h-[400px] flex flex-col items-center justify-center relative text-center group overflow-hidden cursor-pointer hover:border-[#7a4988] transition-all shadow-inner">
                            <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" onchange="previewImage(this)">
                            
                            <div id="placeholder_view" class="z-10 flex flex-col items-center group-hover:scale-110 transition-transform duration-300">
                                <div class="bg-purple-100 p-5 rounded-2xl mb-4 text-[#7a4988] shadow-sm">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-[10px] font-black text-[#24112e] uppercase tracking-widest px-4">Upload Poster</p>
                            </div>

                            <img id="image_preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover z-30">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-3 pt-8 border-t-2 border-gray-50">
                <a href="{{ route('admin.acara.index') }}" class="px-8 py-4 bg-white text-gray-400 rounded-2xl font-black text-[10px] uppercase tracking-widest border-2 border-gray-100 hover:bg-gray-50 transition no-underline">Batal</a>
                <button type="submit" class="px-12 py-4 bg-[#24112e] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition shadow-xl hover:-translate-y-1 border-none cursor-pointer">Simpan Acara</button>
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