@extends('layouts.admin')

@section('content')

{{-- HEADER UTAMA --}}
<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-12 mb-10 text-white shadow-lg">
    <h1 class="text-6xl font-black uppercase tracking-tighter mb-4">DASHBOARD ADMIN</h1>
    <p class="bg-white/20 inline-block px-5 py-2 rounded-md text-xl font-bold uppercase tracking-widest text-white">Kelola Peserta</p>
</div>

<div class="max-w-[1400px] mx-auto bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">

    {{-- HEADER CARD --}}
    <div class="bg-[#673076] px-10 py-10 text-white">
        <h2 class="text-4xl font-black leading-none mb-3">Kelola Peserta</h2>
        <p class="text-xl opacity-90 font-medium">Pilih salah satu event untuk melihat daftar peserta serta check in tiket</p>
    </div>

    {{-- SEARCH BAR --}}
    <div class="px-10 py-8 bg-white border-b border-gray-100">
        <div class="relative">
            <svg class="w-8 h-8 absolute left-6 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="eventSearch" placeholder="Cari nama event atau kategori..." 
                   class="w-full h-20 pl-20 pr-8 rounded-2xl border-2 border-gray-300 bg-gray-50 text-gray-700 text-2xl font-bold focus:ring-4 focus:ring-[#7a4988]/30 focus:border-[#7a4988] focus:outline-none shadow-sm transition-all">
        </div>
    </div>

    {{-- LIST EVENT --}}
    <div class="bg-white pb-8" id="eventList">
        @forelse($events as $event)
            @php
                $namaTampil = $event->kategori ? $event->kategori->nama_kategori : 'UMUM';
            @endphp

            <a href="{{ route('admin.peserta.detail', $event->id_event) }}"
               data-kategori="{{ strtolower($namaTampil) }}"
               class="event-link flex items-center justify-between px-10 py-8 border-b border-gray-100 hover:bg-gray-50 transition no-underline group">
                
                <div class="flex items-center gap-8">
                    <div class="w-40 h-28 rounded-xl overflow-hidden bg-gray-200 shrink-0 border border-gray-100 shadow-sm">
                        <img src="{{ asset('images/' . $event->poster) }}" onerror="this.src='https://placehold.co/160x112?text=Event'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-gray-800 group-hover:text-[#7a4988] transition mb-3 uppercase">{{ $event->judul }}</h3>
                        <p class="text-gray-500 text-lg font-bold flex items-center gap-4">
                            {{ $event->tanggal ? \Carbon\Carbon::parse($event->tanggal)->format('d M Y') : '-' }} 
                            <span class="bg-gray-100 text-gray-600 px-4 py-1.5 rounded-lg text-sm font-black uppercase tracking-wider border border-gray-200">{{ $namaTampil }}</span>
                        </p>
                    </div>
                </div>

                {{-- BADGE STATUS DINAMIS --}}
                <div class="shrink-0">
                    <span class="inline-flex items-center justify-center px-8 py-4 rounded-xl border-2 text-2xl font-black shadow-sm {{ $event->warna_badge }}">
                        {{ $event->total_pendaftar ?? 0 }} 
                        <span class="mx-2 text-gray-400 font-bold">/</span> 
                        {{ $event->kapasitas }} 
                        <span class="ml-2 text-sm uppercase tracking-widest">
                            {{ $event->status_kuota }}
                        </span>
                    </span>
                </div>
            </a>
        @empty
            <div class="text-center py-24 text-gray-400 font-bold text-3xl">Belum ada event yang tersedia.</div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="bg-white px-10 py-8 flex justify-center border-t border-gray-100">
        {{ $events->links() }}
    </div>
</div>

<script>
    document.getElementById('eventSearch').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('.event-link').forEach(event => {
            let title = event.querySelector('h3').innerText.toLowerCase();
            let category = event.getAttribute('data-kategori');
            event.style.display = (title.includes(filter) || category.includes(filter)) ? 'flex' : 'none';
        });
    });
</script>

@endsection