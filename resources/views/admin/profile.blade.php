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
                             src="{{ asset('images/' . (session('admin_foto') ?? 'profile_default.jpg')) }}" 
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('admin_name', 'Admin')) }}&color=ffffff&background=7a4988';"
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
                {{-- NAMA LENGKAP (Value dikunci dinamis mengambil data session login admin) --}}
                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ session('admin_name', 'Vivian') }}" required
                        class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
                </div>

                {{-- EMAIL (Value dikunci dinamis mengambil data session login admin) --}}
                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Email Admin</label>
                    <input type="email" name="email" value="{{ session('admin_email', 'admin@event.com') }}" required
                        class="w-full p-3 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
                </div>

                <hr class="border-gray-100 my-4">

                {{-- PASSWORD LAMA (Diset "admin123" sesuai request agar tidak capek mengetik ulang) --}}
                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Password Lama</label>
                    <div class="relative">
                        <input type="password" id="password_lama" name="password_lama" value="admin123" placeholder="Wajib diisi jika ingin ganti password" 
                            class="w-full p-3 pr-12 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
                        <button type="button" onclick="togglePassword('password_lama', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7a4988] focus:outline-none">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- PASSWORD BARU --}}
                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Password Baru <span class="text-gray-400 font-normal lowercase tracking-normal">(Opsional)</span></label>
                    <div class="relative">
                        <input type="password" id="password_baru" name="password_baru" placeholder="Kosongkan jika tidak ingin diubah" 
                            class="w-full p-3 pr-12 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
                        <button type="button" onclick="togglePassword('password_baru', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7a4988] focus:outline-none">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div>
                    <label class="block mb-1 text-[10px] font-black uppercase text-[#7a4988] tracking-widest">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" placeholder="Ketik ulang password baru..." 
                            class="w-full p-3 pr-12 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-700 focus:border-[#7a4988] outline-none transition-all">
                        <button type="button" onclick="togglePassword('password_baru_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7a4988] focus:outline-none">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
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

        // SHOW / HIDE PASSWORD TOGGLE
        function togglePassword(inputId, button) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = button.querySelector('.eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        // VALIDASI FORM SEBELUM SUBMIT
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const nameInput = document.querySelector('input[name="name"]').value;
            const emailInput = document.querySelector('input[name="email"]').value;
            const passwordLamaInput = document.getElementById('password_lama').value;
            const passwordBaruInput = document.getElementById('password_baru').value;
            const passwordKonfirmasiInput = document.getElementById('password_baru_confirmation').value;
            
            const DUMMY_PASSWORD_LAMA = 'admin123';

            // 1. Validasi Nama Lengkap wajib ada isinya
            if (nameInput.trim() === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama Lengkap Kosong!',
                    text: 'Silakan isi Nama Lengkap terlebih dahulu.',
                    confirmButtonColor: '#24112e'
                });
                return;
            }

            // 2. Validasi Email wajib ada isinya
            if (emailInput.trim() === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Email Admin Kosong!',
                    text: 'Silakan isi Email Admin terlebih dahulu.',
                    confirmButtonColor: '#24112e'
                });
                return;
            }

            // 3. JIKA BERUSAHA GANTI PASSWORD (KOLOM PASSWORD BARU DIISI)
            if (passwordBaruInput.trim() !== '') {
                
                // Verifikasi kecocokan password lama
                if (passwordLamaInput !== DUMMY_PASSWORD_LAMA) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Lama Salah!',
                        text: 'Verifikasi gagal. Pastikan password lama Anda adalah "admin123".',
                        confirmButtonColor: '#24112e'
                    });
                    return;
                }

                // Verifikasi kecocokan password baru dan konfirmasinya
                if (passwordBaruInput !== passwordKonfirmasiInput) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok!',
                        text: 'Konfirmasi password baru tidak sesuai dengan password baru Anda.',
                        confirmButtonColor: '#24112e'
                    });
                    return;
                }
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Profil Diperbarui!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#24112e',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
</body>
</html>