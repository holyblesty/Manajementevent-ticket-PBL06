<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .no-underline { text-decoration: none !important; }
    </style>
</head>
<body 
    style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;"
    class="flex flex-col items-center py-10 font-sans antialiased text-gray-900"
>

    <div class="bg-white w-full max-w-[500px] rounded-3xl shadow-2xl overflow-hidden mx-4 border border-gray-100 mb-10">
        
        <div class="bg-[#24112e] p-10 text-center text-white border-b-4 border-[#7a4988]">
            <h1 class="text-xl font-black uppercase tracking-tighter">Profil Admin</h1>
            <p class="text-xs text-[#be93d4] font-bold mt-1 uppercase tracking-widest">Kelola Informasi & Keamanan Akun</p>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-10 -mt-12">
            @csrf
            @method('PUT')

            {{-- FOTO PROFIL --}}
            <div class="flex justify-center mb-8">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gray-200">
                        <img id="profile_preview" 
                             src="{{ $admin->foto ? asset('images/' . $admin->foto) : asset('images/profile_default.jpg') }}" 
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($admin->username) }}&color=ffffff&background=7a4988';"
                             class="w-full h-full object-cover">
                    </div>
                    
                    <label class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-full cursor-pointer text-white">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-[8px] font-black uppercase tracking-widest">Ganti Foto</span>
                        <input type="file" name="foto" class="hidden" onchange="previewProfile(this)">
                    </label>
                </div>
            </div>

            <div class="space-y-5">
                {{-- USERNAME (Identitas Utama) --}}
   <div>
    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">
        Username
    </label>

    <input type="text" name="username" value="{{ $admin->username }}"
        class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
</div>

                <hr class="border-gray-100 my-4">

                {{-- PASSWORD AREA --}}
<div>
    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Password Lama</label>

    <div class="relative">
        <input type="password" name="password_lama" id="password_lama"
            placeholder="Wajib diisi untuk keamanan"
            class="w-full p-3 pr-12 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">

        <button type="button" onclick="togglePassword('password_lama', this)"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-[#7a4988]">
            👁
        </button>
    </div>
</div>

<div>
    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">
        Password Baru 
        <span class="text-gray-400 font-normal lowercase tracking-normal">(Opsional)</span>
    </label>

    <div class="relative">
        <input type="password" name="password_baru" id="password_baru"
            placeholder="Kosongkan jika tidak diubah"
            class="w-full p-3 pr-12 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">

        <button type="button" onclick="togglePassword('password_baru', this)"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-[#7a4988]">
            👁
        </button>
    </div>
</div>
            </div>

            <div class="mt-10 flex flex-col gap-3">
                <button type="submit" class="w-full py-3 bg-[#24112e] text-white rounded-xl font-black text-xs uppercase tracking-[0.2em] hover:bg-black transition shadow-lg hover:-translate-y-1 border-none cursor-pointer">
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

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#24112e'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#24112e'
            });
        @endif

        function togglePassword(id, btn) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        btn.innerHTML = "🙈";
    } else {
        input.type = "password";
        btn.innerHTML = "👁";
    }
}
    </script>
</body>
</html>