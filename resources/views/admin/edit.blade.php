<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Event - {{ $event->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .form-container { flex: 2; }
        .poster-container { flex: 1; min-width: 300px; }
    </style>
</head>
<body style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="flex flex-col items-center py-10 font-sans antialiased text-gray-900">

    <div class="bg-white w-full max-w-[1200px] rounded-[2.5rem] shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-white">Ubah Informasi Event</h1>
            <p class="text-xs text-[#be93d4] font-bold mt-1 uppercase tracking-widest">{{ $event->judul }}</p>
        </div>

        @if ($errors->any())
            <div class="m-10 p-6 bg-red-50 border-2 border-red-200 rounded-2xl">
                <ul class="list-disc list-inside text-xs font-bold text-red-600">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.acara.update', $event->id_event) }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            @method('PUT')

            <div class="flex flex-wrap items-start gap-12">
                
                <div class="form-container space-y-6">
                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Judul Event</label>
                        <input type="text" name="judul" value="{{ old('judul', $event->judul) }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 outline-none">
                    </div>

                    <div>
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Deskripsi Event</label>
                        <textarea name="deskripsi" rows="4" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-medium text-gray-700 outline-none">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai', $event->tgl_mulai ? $event->tgl_mulai->format('Y-m-d') : '') }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>

                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Tanggal Selesai</label>
                            <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai', $event->tgl_selesai ? $event->tgl_selesai->format('Y-m-d') : '') }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>
                        
                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', substr($event->jam_mulai ?? '', 0, 5)) }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>

                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Jam Selesai</label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', substr($event->jam_selesai ?? '', 0, 5)) }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none">
                        </div>

                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Status Event</label>
                            <select name="status_event" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none cursor-pointer">
                                <option value="draft" {{ $event->status_event == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="open" {{ $event->status_event == 'open' ? 'selected' : '' }}>Open</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Kategori</label>
                            <select name="id_kategori" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-500 outline-none cursor-pointer">
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ $event->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block mb-2 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $event->lokasi) }}" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 outline-none">
                    </div>
                </div>

                <div class="poster-container space-y-4">
                    <label class="block text-[10px] font-black uppercase text-[#7a4988] tracking-widest text-center">Poster Event</label>
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] h-[400px] w-full flex items-center justify-center relative overflow-hidden group cursor-pointer">
                        <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 z-50" onchange="previewImage(this, 'poster_preview')">
                        <img id="poster_preview" src="{{ asset('images/' . $event->poster) }}" class="absolute inset-0 w-full h-full object-cover z-30">
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-3 pt-8 border-t-2 border-gray-50">
                <a href="{{ route('admin.dashboard') }}" class="px-8 py-4 bg-white text-gray-400 rounded-2xl font-black text-[10px] uppercase tracking-widest border-2 border-gray-100 hover:bg-gray-50 transition no-underline">Batal</a>
                <button type="submit" class="px-12 py-4 bg-[#24112e] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition shadow-xl border-none cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input, id) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => { document.getElementById(id).src = e.target.result; }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>