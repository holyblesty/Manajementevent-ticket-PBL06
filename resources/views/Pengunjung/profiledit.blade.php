@extends('layouts.pengunjung')

@section('title', 'Ubah Informasi Profil')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black text-[#24112e]">Form Edit Profil</h1>
    <p class="text-xs text-gray-400">Ubah informasi kelengkapan data pembeli Anda di bawah ini.</p>
</div>

<div class="max-w-2xl bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
    
    @if(!$bisaUpdate)
        <div class="mb-5 p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-800 rounded-r-xl text-xs font-semibold leading-relaxed">
            ⚠️ Sistem mengunci pengubahan data profil Anda untuk sementara. Sesuai dengan aturan, Anda hanya bisa merubah informasi profil sekali dalam seminggu. Silakan coba kembali dalam <strong>{{ $sisaHari }} hari lagi</strong>.
        </div>
    @endif

    <form action="{{ route('pengunjung.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4 text-xs">
            <div>
                <label class="block text-gray-400 font-bold mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border border-gray-200 focus:border-[#7a4988] rounded-lg px-3 py-2.5 font-medium focus:outline-none focus:bg-white transition" required {{ !$bisaUpdate ? 'disabled' : '' }}>
            </div>

            <div>
                <label class="block text-gray-400 font-bold mb-1.5 uppercase tracking-wider">Nomor Handphone</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 0812345678" class="w-full bg-gray-50 border border-gray-200 focus:border-[#7a4988] rounded-lg px-3 py-2.5 font-medium focus:outline-none focus:bg-white transition" {{ !$bisaUpdate ? 'disabled' : '' }}>
            </div>

            <div>
                <label class="block text-gray-400 font-bold mb-1.5 uppercase tracking-wider">Alamat Tempat Tinggal</label>
                <textarea name="alamat" rows="4" placeholder="Tuliskan alamat rumah lengkap Anda..." class="w-full bg-gray-50 border border-gray-200 focus:border-[#7a4988] rounded-lg px-3 py-2.5 font-medium focus:outline-none focus:bg-white transition" {{ !$bisaUpdate ? 'disabled' : '' }}>{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100 justify-end font-bold">
                <a href="{{ route('pengunjung.profil') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-center transition">
                    Batal
                </a>
                <button type="submit" class="bg-[#7a4988] hover:bg-[#63376f] text-white px-5 py-2.5 rounded-lg transition shadow-md disabled:opacity-40 disabled:cursor-not-allowed transform active:scale-95" {{ !$bisaUpdate ? 'disabled' : '' }}>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

@endsection