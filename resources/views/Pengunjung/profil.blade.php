@extends('layouts.pengunjung')

@section('title', 'Profil Saya')

@section('content')

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-xl text-xs font-bold">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-xl text-xs font-bold">
    {{ session('error') }}
</div>
@endif

<div class="mb-6">
    <h1 class="text-2xl font-black text-[#24112e]">Profil Saya</h1>
    <p class="text-xs text-gray-400">Kelola informasi profil dan akun Anda.</p>
</div>

<!-- NAVIGASI TAB SESUAI MOCKUP -->
<div class="flex border-b border-gray-200 mb-6">
    <button class="border-b-2 border-[#7a4988] text-[#7a4988] py-2 px-4 text-xs font-bold">Informasi Profil</button>
    <a href="{{ route('pengunjung.profil.password') }}" class="text-gray-400 hover:text-gray-600 py-2 px-4 text-xs font-medium">Keamanan Akun</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- KOLOM KIRI: INFORMASI PRIBADI -->
    <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
        <h3 class="text-xs font-bold text-[#7a4988] uppercase mb-4">Informasi Pribadi</h3>
        
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex flex-col items-center gap-2">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-50 border">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=7a4988&color=fff" class="w-full h-full object-cover" alt="Foto">
                </div>
                <button class="text-[10px] font-bold text-[#7a4988] border border-gray-200 px-3 py-1 rounded hover:bg-gray-50">Ubah Foto</button>
            </div>

            <div class="flex-1 space-y-3 text-xs">
                <div>
                    <label class="block text-gray-400 font-semibold mb-1">Nama Lengkap</label>
                    <p class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-700 font-medium">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <label class="block text-gray-400 font-semibold mb-1">Email</label>
                    <p class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-400 font-medium">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <label class="block text-gray-400 font-semibold mb-1">No. Telepon</label>
                    <p class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-700 font-medium">{{ Auth::user()->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-gray-400 font-semibold mb-1">Alamat</label>
                    <p class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-gray-700 font-medium whitespace-pre-line">{{ Auth::user()->alamat ?? '-' }}</p>
                </div>
                
                <div class="pt-2">
                    <a href="{{ route('pengunjung.profil.edit') }}" class="inline-block bg-[#7a4988] hover:bg-[#63376f] text-white font-bold px-4 py-2 rounded-lg transition text-xs shadow-sm">
                        Ubah Informasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: INFORMASI AKUN & PASSWORD -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm text-xs">
            <h3 class="text-xs font-bold text-[#7a4988] uppercase mb-4">Informasi Akun</h3>
            <div class="space-y-2 font-medium text-gray-600">
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Username</span>
                    <span>{{ Str::slug(Auth::user()->name, '') }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400">Metode Login</span>
                    <span>Email</span>
                </div>
                <div class="flex justify-between py-1 items-center">
                    <span class="text-gray-400">Status Akun</span>
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">Aktif</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm text-xs">
            <h3 class="text-xs font-bold text-[#7a4988] uppercase mb-2">Password</h3>
            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                <span class="text-gray-400 font-black tracking-widest">••••••••••••</span>
                <a href="{{ route('pengunjung.profil.password') }}" class="text-[11px] font-bold text-[#7a4988] hover:underline">Ubah Password</a>
            </div>
        </div>
    </div>
</div>

@endsection