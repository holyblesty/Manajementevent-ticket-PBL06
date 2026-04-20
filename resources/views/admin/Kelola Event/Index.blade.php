@extends('admin.layouts.app')

@section('title', 'Dashboard Admin - Kelola Acara')

@push('styles')
<style>
    /* Animasi row hover */
    .table-row-hover:hover { background-color: #faf5ff; transition: background 0.2s; }

    /* Badge kategori */
    .badge-olahraga  { background: #dbeafe; color: #1d4ed8; }
    .badge-seminar   { background: #dcfce7; color: #15803d; }
    .badge-hiburan   { background: #fef9c3; color: #a16207; }
    .badge-teknologi { background: #ede9fe; color: #6d28d9; }
    .badge-default   { background: #f3f4f6; color: #374151; }

    /* Tambah Acara Button */
    .btn-tambah {
        background: linear-gradient(135deg, #7C3AED, #9333EA);
        transition: all 0.2s;
    }
    .btn-tambah:hover {
        background: linear-gradient(135deg, #5B21B6, #7C3AED);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
    }

    /* Flash message */
    .flash-success { animation: slideDown 0.3s ease; }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

{{-- ===== HEADER BANNER ===== --}}
<div class="admin-header-bg px-8 py-6 flex items-center justify-between">
    <div>
        <h1 class="text-white font-extrabold text-2xl tracking-wide">DASHBOARD ADMIN</h1>
        <span class="inline-block mt-1 bg-white/20 text-white/90 text-xs font-semibold px-3 py-1 rounded-full">
            KELOLA ACARA
        </span>
    </div>
</div>

{{-- ===== MAIN CONTENT ===== --}}
<div class="px-8 py-6">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-success mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl" role="alert">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== TOMBOL TAMBAH ACARA ===== --}}
    <div class="mb-5">
        <a href="{{ route('admin.acara.create') }}"
           class="btn-tambah inline-flex items-center gap-2 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            TAMBAH ACARA
        </a>
    </div>

    {{-- ===== TABEL ACARA ===== --}}
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-purple-100">

        {{-- Table Header --}}
        <div class="table-header grid grid-cols-6 px-5 py-3 text-white font-bold text-sm">
            <div class="text-center">Poster</div>
            <div class="col-span-1">Judul Acara</div>
            <div class="text-center">Tanggal Acara</div>
            <div>Lokasi</div>
            <div class="text-center">Kategori</div>
            <div class="text-center">Aksi</div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
            {{-- Search --}}
            <form method="GET" action="{{ route('admin.acara.index') }}" class="flex-1 flex items-center gap-3">
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari otomatis nama event"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition"
                    >
                </div>

                {{-- Filter Kategori --}}
                <select name="kategori"
                        onchange="this.form.submit()"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-purple-300 outline-none text-gray-600 cursor-pointer">
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ $kategori === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Rows --}}
        @forelse($acaraList as $index => $acara)
        <div class="table-row-hover grid grid-cols-6 items-center px-5 py-3.5 border-b border-gray-50 last:border-0">
            {{-- No + Poster --}}
            <div class="flex items-center gap-3">
                <span class="text-gray-400 text-sm font-medium w-4">{{ $index + 1 }}</span>
                <img src="{{ $acara['poster'] }}"
                     alt="poster"
                     class="w-14 h-10 object-cover rounded-lg shadow-sm border border-gray-200">
            </div>

            {{-- Judul --}}
            <div class="col-span-1 pr-3">
                <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $acara['judul'] }}</p>
            </div>

            {{-- Tanggal --}}
            <div class="text-center">
                <span class="text-sm text-gray-600">{{ $acara['tanggal'] }}</span>
            </div>

            {{-- Lokasi --}}
            <div>
                <p class="text-sm text-gray-600 leading-tight">{{ $acara['lokasi'] }}</p>
            </div>

            {{-- Kategori Badge --}}
            <div class="flex justify-center">
                @php
                    $badgeClass = match(strtolower($acara['kategori'])) {
                        'olahraga'  => 'badge-olahraga',
                        'seminar'   => 'badge-seminar',
                        'hiburan'   => 'badge-hiburan',
                        'teknologi' => 'badge-teknologi',
                        default     => 'badge-default',
                    };
                @endphp
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                    {{ $acara['kategori'] }}
                </span>
            </div>

            {{-- Aksi --}}
            <div class="flex items-center justify-center gap-2">
                {{-- Ubah --}}
                <a href="{{ route('admin.acara.edit', $acara['id']) }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg transition shadow-sm">
                    UBAH
                </a>

                {{-- Hapus --}}
                <button onclick="openDeleteModal({{ $acara['id'] }})"
                        class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg transition shadow-sm">
                    HAPUS
                </button>
            </div>
        </div>
        @empty
        <div class="py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-sm font-medium">Belum ada acara yang ditambahkan</p>
        </div>
        @endforelse

        {{-- ===== PAGINATION ===== --}}
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-center gap-1">
            {{-- Previous --}}
            <button class="px-2.5 py-1.5 text-xs text-gray-500 hover:bg-purple-50 rounded-lg transition border border-gray-200">
                &laquo; terima
            </button>

            @for($p = 1; $p <= 7; $p++)
                <button class="w-8 h-8 text-xs rounded-lg transition
                    {{ $p === 1
                        ? 'bg-purple-600 text-white font-bold shadow-md'
                        : 'text-gray-600 hover:bg-purple-50 border border-gray-200' }}">
                    {{ $p }}
                </button>
            @endfor

            {{-- Next --}}
            <button class="px-2.5 py-1.5 text-xs text-gray-500 hover:bg-purple-50 rounded-lg transition border border-gray-200">
                terima &raquo;
            </button>
        </div>
    </div>
</div>

{{-- ===== MODAL DELETE CONFIRMATION ===== --}}
<div id="deleteModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-8 text-center animate-modal">
        <p class="text-gray-800 font-bold text-lg mb-6">YAKIN INGIN MENGHAPUS DATA INI?</p>
        <div class="flex justify-center gap-4">
            {{-- Konfirmasi Hapus --}}
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold px-8 py-2.5 rounded-xl transition shadow-md">
                    Ya
                </button>
            </form>

            {{-- Batal --}}
            <button onclick="closeDeleteModal()"
                    class="bg-blue-400 hover:bg-blue-500 text-white font-bold px-8 py-2.5 rounded-xl transition shadow-md">
                Tidak
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ===== DELETE MODAL =====
    function openDeleteModal(id) {
        const modal = document.getElementById('deleteModal');
        const form  = document.getElementById('deleteForm');
        // Set action URL
        form.action = `/admin/acara/${id}`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Klik luar modal untuk tutup
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // ===== LIVE SEARCH (opsional, debounce) =====
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.closest('form').submit();
            }, 400);
        });
    }
</script>

<style>
    .animate-modal { animation: popIn 0.2s cubic-bezier(0.34,1.56,0.64,1); }
    @keyframes popIn {
        from { opacity: 0; transform: scale(0.85); }
        to   { opacity: 1; transform: scale(1); }
    }
</style>
@endpush