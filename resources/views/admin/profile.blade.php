<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body 
    style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;"
    class="flex flex-col items-center py-20 font-sans antialiased text-gray-900"
>

    <div class="bg-white w-full max-w-[500px] rounded-3xl shadow-2xl overflow-hidden mx-4 border border-gray-100">
        <div class="bg-[#24112e] p-10 text-center text-white border-b-4 border-[#7a4988]">
            <h1 class="text-xl font-black uppercase tracking-tighter">Profil Admin</h1>
            <p class="text-xs text-[#be93d4] font-bold mt-1 uppercase tracking-widest">Kelola Informasi Akun Anda</p>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-10 -mt-12">
            @csrf
            @method('PUT')

            <div class="flex justify-center mb-8">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gray-200">
                        <img id="profile_preview" src="{{ asset('images/' . $user->foto) }}" class="w-full h-full object-cover">
                    </div>
                    
                    <label class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-full cursor-pointer">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="file" name="foto" class="hidden" onchange="previewProfile(this)">
                    </label>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition">
                </div>

                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-gray-400 tracking-widest">Email (Terkunci)</label>
                    <input type="email" value="{{ $user->email }}" readonly class="w-full p-3 bg-gray-100 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-400 cursor-not-allowed outline-none">
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-3">
                <button type="submit" class="w-full py-3 bg-[#24112e] text-white rounded-xl font-black text-xs uppercase tracking-[0.2em] hover:bg-black transition shadow-lg border-none">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.dashboard') }}" class="w-full py-3 text-center text-gray-400 font-bold text-[10px] uppercase tracking-widest hover:text-gray-600 transition no-underline">
                    Kembali ke Dashboard
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewProfile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('profile_preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>