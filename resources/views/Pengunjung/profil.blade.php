{{-- resources/views/pengunjung/profil/profil.blade.php --}}

@extends('layouts.pengunjung')

@section('title', 'Profil Saya')

@section('content')

{{-- ── Flash Notifikasi ─────────────────────────────────────────────────── --}}
@if (session('success'))
    <div id="alert-success"
         class="mx-auto max-w-6xl px-4 pt-4">
        <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

{{-- ── Wrapper Utama ────────────────────────────────────────────────────── --}}
<div class="mx-auto max-w-6xl px-4 py-8">

    {{-- Header --}}
    <div class="mb-1">
        <h1 class="text-2xl font-bold text-[#6B21B0]">Profil Saya</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola informasi profil dan akun Anda.</p>
    </div>

    {{-- ── Tab Navigasi ─────────────────────────────────────────────────── --}}
    <div class="border-b border-gray-200 mb-6 mt-4">
        <nav class="-mb-px flex gap-6">
            <button id="tab-profil"
                    onclick="switchTab('profil')"
                    class="border-b-2 border-[#6B21B0] pb-3 text-sm font-semibold text-[#6B21B0]">
                Informasi Profil
            </button>
            <button id="tab-keamanan"
                    onclick="switchTab('keamanan')"
                    class="border-b-2 border-transparent pb-3 text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                Keamanan Akun
            </button>
        </nav>
    </div>

    {{-- ── Grid Konten ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- ════════════════════════════════════════════════════════════════
             KOLOM KIRI — Informasi Pribadi
        ════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <h2 class="mb-5 text-base font-semibold text-[#6B21B0]">Informasi Pribadi</h2>

                <div class="flex flex-col gap-6 sm:flex-row">

                    {{-- Avatar + Ubah Foto --}}
                    <div class="flex flex-col items-center gap-3">
                        <img id="preview-foto"
                             src="{{ $pengunjung->foto ? asset('storage/' . $pengunjung->foto) : asset('images/avatar-default.png') }}"
                             alt="Foto {{ $pengunjung->nama_lengkap }}"
                             class="h-24 w-24 rounded-full object-cover ring-2 ring-[#6B21B0]/20"/>

                        <form action="{{ route('pengunjung.profil.foto') }}" method="POST"
                              enctype="multipart/form-data" id="form-foto">
                            @csrf
                            <input type="file" id="input-foto" name="foto"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="hidden"
                                   onchange="previewFoto(this); document.getElementById('form-foto').submit()"/>
                            <button type="button"
                                    onclick="document.getElementById('input-foto').click()"
                                    class="rounded-lg border border-[#6B21B0] px-4 py-1.5 text-sm font-medium
                                           text-[#6B21B0] hover:bg-[#6B21B0]/5 transition">
                                Ubah Foto
                            </button>
                        </form>
                    </div>

                    {{-- Form Data Pribadi --}}
                    <form action="{{ route('pengunjung.profil.update') }}" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4">

                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="nama_lengkap" class="mb-1 block text-xs font-medium text-gray-600">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap"
                                       value="{{ old('nama_lengkap', $pengunjung->nama_lengkap) }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                              focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]
                                              @error('nama_lengkap') border-red-400 @enderror"/>
                                @error('nama_lengkap')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-1 block text-xs font-medium text-gray-600">
                                    Email
                                </label>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $pengunjung->email) }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                              focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]
                                              @error('email') border-red-400 @enderror"/>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No. Telepon --}}
                            <div>
                                <label for="no_telepon" class="mb-1 block text-xs font-medium text-gray-600">
                                    No. Telepon
                                </label>
                                <input type="text" id="no_telepon" name="no_telepon"
                                       value="{{ old('no_telepon', $pengunjung->no_telepon) }}"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                              focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]"/>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir" class="mb-1 block text-xs font-medium text-gray-600">
                                    Tanggal Lahir
                                </label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                           value="{{ old('tanggal_lahir', $pengunjung->tanggal_lahir?->format('Y-m-d')) }}"
                                           class="w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm
                                                  focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]"/>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label for="jenis_kelamin" class="mb-1 block text-xs font-medium text-gray-600">
                                    Jenis Kelamin
                                </label>
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                               focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $pengunjung->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $pengunjung->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label for="alamat" class="mb-1 block text-xs font-medium text-gray-600">
                                    Alamat
                                </label>
                                <textarea id="alamat" name="alamat" rows="3"
                                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                                                 focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]">{{ old('alamat', $pengunjung->alamat) }}</textarea>
                            </div>

                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="mt-5">
                            <button type="submit"
                                    class="rounded-lg bg-[#6B21B0] px-6 py-2 text-sm font-semibold text-white
                                           hover:bg-[#5a1a95] transition focus:outline-none focus:ring-2
                                           focus:ring-[#6B21B0] focus:ring-offset-2">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════
             KOLOM KANAN — Informasi Akun + Password
        ════════════════════════════════════════════════════════════════ --}}
        <div class="flex flex-col gap-6">

            {{-- Card: Informasi Akun --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-base font-semibold text-[#6B21B0]">Informasi Akun</h2>

                <dl class="space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-2">
                        <dt class="w-36 shrink-0 text-gray-500">Username</dt>
                        <dd class="text-right font-medium text-gray-800 break-all">{{ $pengunjung->username }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-2">
                        <dt class="w-36 shrink-0 text-gray-500">Bergabung Sejak</dt>
                        <dd class="text-right font-medium text-gray-800">
                            {{ $pengunjung->created_at->translatedFormat('d F Y') }}
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-2">
                        <dt class="w-36 shrink-0 text-gray-500">Metode Login</dt>
                        <dd class="text-right font-medium text-gray-800">{{ $pengunjung->metode_login }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-2">
                        <dt class="w-36 shrink-0 text-gray-500">Status Akun</dt>
                        <dd>
                            @php
                                $badgeColor = match($pengunjung->status_akun) {
                                    'Aktif'    => 'bg-green-100 text-green-700',
                                    'Nonaktif' => 'bg-red-100 text-red-700',
                                    default    => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="rounded-full px-3 py-0.5 text-xs font-semibold {{ $badgeColor }}">
                                {{ $pengunjung->status_akun }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Card: Password --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-base font-semibold text-[#6B21B0]">Password</h2>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-2xl tracking-widest text-gray-400" aria-label="Password disembunyikan">
                        ••••••••••••
                    </span>
                    <button type="button"
                            onclick="openModalPassword()"
                            class="rounded-lg border border-[#6B21B0] px-4 py-1.5 text-sm font-medium
                                   text-[#6B21B0] hover:bg-[#6B21B0]/5 transition whitespace-nowrap">
                        Ubah Password
                    </button>
                </div>
            </div>

        </div>
        {{-- akhir kolom kanan --}}

    </div>
    {{-- akhir grid --}}

</div>
{{-- akhir wrapper utama --}}


{{-- ══════════════════════════════════════════════════════════════════════════
     MODAL UBAH PASSWORD
══════════════════════════════════════════════════════════════════════════ --}}
<div id="modal-password"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-password-title">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

        {{-- Header Modal --}}
        <div class="mb-5 flex items-center justify-between">
            <h3 id="modal-password-title" class="text-base font-semibold text-[#6B21B0]">
                Ubah Password
            </h3>
            <button type="button" onclick="closeModalPassword()" aria-label="Tutup modal"
                    class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Error validasi password --}}
        @if ($errors->has('password_baru') || $errors->has('password_baru_confirmation'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                <ul class="list-inside list-disc space-y-1">
                    @error('password_baru') <li>{{ $message }}</li> @enderror
                    @error('password_baru_confirmation') <li>{{ $message }}</li> @enderror
                </ul>
            </div>
        @endif

        {{-- Form Password --}}
        <form action="{{ route('pengunjung.profil.password') }}" method="POST" id="form-password">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                {{-- Password Baru --}}
                <div>
                    <label for="password_baru" class="mb-1 block text-xs font-medium text-gray-600">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" id="password_baru" name="password_baru"
                               placeholder="Minimal 8 karakter"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 text-sm
                                      focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]
                                      @error('password_baru') border-red-400 @enderror"/>
                        <button type="button" onclick="togglePassword('password_baru', 'icon-pw1')"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg id="icon-pw1" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                                         9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div>
                    <label for="password_baru_confirmation" class="mb-1 block text-xs font-medium text-gray-600">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" id="password_baru_confirmation"
                               name="password_baru_confirmation"
                               placeholder="Ulangi password baru"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 text-sm
                                      focus:border-[#6B21B0] focus:outline-none focus:ring-1 focus:ring-[#6B21B0]
                                      @error('password_baru_confirmation') border-red-400 @enderror"/>
                        <button type="button" onclick="togglePassword('password_baru_confirmation', 'icon-pw2')"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg id="icon-pw2" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                                         9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModalPassword()"
                        class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium
                               text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-lg bg-[#6B21B0] px-5 py-2 text-sm font-semibold text-white
                               hover:bg-[#5a1a95] transition focus:outline-none focus:ring-2
                               focus:ring-[#6B21B0] focus:ring-offset-2">
                    Ubah
                </button>
            </div>

        </form>
    </div>
</div>
{{-- akhir modal --}}

@endsection


{{-- ══════════════════════════════════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>

// ── Tab ────────────────────────────────────────────────────────────────────
function switchTab(tab) {
    ['profil', 'keamanan'].forEach(t => {
        const btn = document.getElementById('tab-' + t);
        if (!btn) return;
        const active = t === tab;
        btn.classList.toggle('border-[#6B21B0]', active);
        btn.classList.toggle('text-[#6B21B0]', active);
        btn.classList.toggle('font-semibold', active);
        btn.classList.toggle('border-transparent', !active);
        btn.classList.toggle('text-gray-500', !active);
        btn.classList.toggle('font-medium', !active);
    });
}

// ── Modal Password ─────────────────────────────────────────────────────────
function openModalPassword() {
    const modal = document.getElementById('modal-password');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    document.getElementById('password_baru').focus();
}

function closeModalPassword() {
    const modal = document.getElementById('modal-password');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    document.getElementById('form-password').reset();
}

// Klik di luar modal → tutup
document.getElementById('modal-password').addEventListener('click', function (e) {
    if (e.target === this) closeModalPassword();
});

// Tekan Escape → tutup
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModalPassword();
});

// Buka otomatis jika ada error validasi dari server
@if ($errors->has('password_baru') || $errors->has('password_baru_confirmation'))
    document.addEventListener('DOMContentLoaded', openModalPassword);
@endif

// Auto-hide alert sukses setelah 4 detik
document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('alert-success');
    if (alert) setTimeout(() => alert.remove(), 4000);
});

// ── Toggle Show/Hide Password ──────────────────────────────────────────────
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                     a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243
                     M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29
                     M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7
                     a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                     9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}

// ── Preview Foto Sebelum Upload ────────────────────────────────────────────
function previewFoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        const preview = document.getElementById('preview-foto');
        if (preview) preview.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

</script>
@endpush