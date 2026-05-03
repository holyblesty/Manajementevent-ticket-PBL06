@extends('layouts.admin')

@section('content')

{{-- HEADER UTAMA --}}
<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-8 mb-8 text-white shadow-lg">
    <h1 class="text-4xl font-black uppercase tracking-tighter">DASHBOARD ADMIN</h1>
<p class="bg-white/20 inline-block px-4 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">Kelola Peserta</p>
</div>

<div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

    {{-- HEADER CARD --}}
    <div class="bg-[#673076] px-6 py-6 text-white">
        <h2 class="text-2xl font-black leading-none">Kelola Peserta</h2>
        <p class="text-sm mt-2 opacity-90 font-medium">
            Pilih salah satu event untuk melihat daftar peserta serta check in tiket
        </p>
    </div>

    {{-- SEARCH BAR --}}
    <div class="px-6 py-5 bg-white border-b border-gray-100">
        <div class="relative">
            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" 
                   id="eventSearch"
                   placeholder="Cari nama event atau kategori (Contoh: Olahraga)..." 
                   class="w-full h-12 pl-12 pr-4 rounded-full border border-gray-300 bg-gray-50 text-gray-700 text-sm focus:ring-2 focus:ring-[#7a4988] focus:outline-none shadow-sm">
        </div>
    </div>

    {{-- LIST EVENT --}}
    <div class="bg-white pb-5">
        @foreach($events as $event)
        <a href="{{ route('admin.peserta.detail', $event->id) }}"
           data-kategori="{{ strtolower($event->kategori) }}"
           class="event-link flex items-center justify-between px-6 py-4 border-b border-gray-100 hover:bg-gray-50 transition no-underline group">

            {{-- LEFT: IMAGE & INFO --}}
            <div class="flex items-center gap-4">
                <div class="w-20 h-16 rounded-lg overflow-hidden bg-gray-200 shrink-0 border border-gray-100">
                    <img src="{{ asset('images/' . $event->poster) }}"
                         onerror="this.src='https://placehold.co/100x80?text=Event'"
                         class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#7a4988] transition">
                        {{ $event->judul }}
                    </h3>
                    <p class="text-gray-500 text-xs mt-1 font-medium flex items-center gap-2">
                        {{ $event->tanggal }} 
                        <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-gray-200">
                            {{ $event->kategori }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- RIGHT: PILL BADGE --}}
            <div class="shrink-0">
                <span class="inline-flex items-center justify-center px-6 py-2 rounded-full border text-sm font-bold shadow-sm
                    {{ $event->is_full ? 'bg-red-100 text-red-700 border-red-200' : 'bg-blue-100 text-blue-700 border-blue-200' }}">
                    {{ $event->total_pendaftar }}/{{ $event->kuota }} {{ $event->label }}
                </span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="bg-white px-6 py-5 flex justify-center">
        @include('components.pagination')
    </div>
</div>

<script>
    document.getElementById('eventSearch').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let events = document.querySelectorAll('.event-link');
        
        events.forEach(event => {
            let title = event.querySelector('h3').innerText.toLowerCase();
            let category = event.getAttribute('data-kategori'); // Mengambil data kategori
            
            // Cek apakah filter cocok dengan Judul ATAU Kategori
            if (title.includes(filter) || category.includes(filter)) {
                event.style.display = 'flex';
            } else {
                event.style.display = 'none';
            }
        });
    });
</script>

@endsection