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
    </style>
</head>
<body style="background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="min-h-screen py-10 font-sans antialiased text-gray-900">

    <div class="bg-white w-full max-w-[1100px] rounded-[2.5rem] shadow-2xl overflow-hidden mb-10 mx-auto border border-gray-100">
        
        <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988] flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tighter">Tambah Event Baru</h1>
                <p class="text-[10px] text-[#be93d4] font-bold mt-1 uppercase tracking-[0.3em]">Detail Informasi & Media Acara</p>
            </div>
            <div class="hidden md:block bg-[#7a4988]/20 px-4 py-2 rounded-xl border border-[#7a4988]/30">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#be93d4]">* Wajib diisi</p>
            </div>
        </div>

        <form action="{{ route('admin.acara.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            <input type="hidden" name="kapasitas" value="0">
            <input type="hidden" name="kuota_tersedia" value="0">

            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-8 border-red-600 rounded-r-2xl shadow-sm">
                    <ul class="list-disc list-inside text-xs font-bold text-red-500">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-gray-400">Status Acara *</label>
                        <select name="status_event" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 focus:border-[#7a4988] outline-none">
                            <option value="draft">Draft</option>
                            <option value="open">Terbuka</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988]">Judul Event *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none">
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988]">Deskripsi *</label>
                        <textarea name="deskripsi" rows="5" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-medium text-gray-700 focus:border-[#7a4988] outline-none">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-gray-400">Tgl Mulai *</label>
                            <input type="date" name="tgl_mulai" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-gray-400">Tgl Selesai *</label>
                            <input type="date" name="tgl_selesai" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988]">Jam Mulai (WIB) *</label>
                            <input type="time" name="jam_mulai" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988]">Jam Selesai (WIB) *</label>
                            <input type="time" name="jam_selesai" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] text-center">Poster Event *</label>
                        <div class="group bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] h-[300px] flex items-center justify-center relative cursor-pointer hover:border-[#7a4988] transition-all overflow-hidden">
                            <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" onchange="previewImage(this)">
                            <div id="placeholder_view" class="text-center flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 group-hover:text-[#7a4988]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M7 4v16M17 4v16M3 8h18M3 16h18M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                                <span class="text-gray-400 text-xs font-bold uppercase">Pilih Poster</span>
                            </div>
                            <img id="image_preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover rounded-[2rem] z-30">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-gray-400">Kategori *</label>
                        <select name="id_kategori" required class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                             <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-gray-400">Lokasi *</label>
                        <input type="text" name="lokasi" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-8 border-t-2 border-gray-50">
                <a href="{{ route('admin.acara.index') }}" class="px-8 py-4 bg-white text-gray-400 rounded-2xl font-black text-[10px] uppercase tracking-widest border-2 border-gray-100">Batal</a>
                <button type="submit" class="px-12 py-4 bg-[#24112e] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl">Simpan Acara</button>
            </div>
        </form>
    </div>

    <script>
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