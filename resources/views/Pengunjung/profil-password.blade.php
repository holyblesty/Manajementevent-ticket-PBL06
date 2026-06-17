@extends('layouts.pengunjung')

@section('title', 'Ubah Password Keamanan')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black text-[#24112e]">Keamanan Akun</h1>
    <p class="text-xs text-gray-400">Perbarui kata sandi akun pendaftaran Anda secara berkala demi keamanan data.</p>
</div>

<div class="flex border-b border-gray-200 mb-6">
    <a href="{{ route('pengunjung.profil') }}" class="text-gray-400 hover:text-gray-600 py-2 px-4 text-xs font-medium">Informasi Profil</a>
    <button class="border-b-2 border-[#7a4988] text-[#7a4988] py-2 px-4 text-xs font-bold">Keamanan Akun</button>
</div>

<div class="max-w-md bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
    <h3 class="text-xs font-bold text-[#7a4988] uppercase mb-4 pb-2 border-b tracking-wider">Ubah Password Akun</h3>

    <form action="{{ route('pengunjung.profil.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4 text-xs">
            <div>
                <label class="block text-gray-400 font-bold mb-1.5 uppercase tracking-wider">Password Baru</label>
                <input type="password" name="password" placeholder="Masukkan minimal 8 karakter" class="w-full bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror focus:border-[#7a4988] rounded-lg px-3 py-2.5 font-medium focus:outline-none focus:bg-white transition" required>
                @error('password')
                    <span class="text-red-500 text-[10px] mt-1 block font-semibold">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-400 font-bold mb-1.5 uppercase tracking-wider">Konfirmasi Ulang Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi pengetikan password baru di atas" class="w-full bg-gray-50 border border-gray-200 focus:border-[#7a4988] rounded-lg px-3 py-2.5 font-medium focus:outline-none focus:bg-white transition" required>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100 justify-end font-bold">
                <a href="{{ route('pengunjung.profil') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-center transition">
                    Batal
                </a>
                <button type="submit" class="bg-[#7a4988] hover:bg-[#63376f] text-white px-5 py-2.5 rounded-lg transition shadow-md transform active:scale-95">
                    Ubah Password
                </button>
            </div>
        </div>
    </form>
</div>

@endsection