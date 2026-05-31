{{-- resources/views/Pengunjung/riwayat-pendaftaran.blade.php --}}
@extends('layouts.pengunjung')

@section('title', 'Riwayat Pendaftaran')

@section('content')

<div class="min-h-screen bg-gray-50 flex">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="w-56 bg-white border-r border-gray-200 flex flex-col py-8 px-4 fixed left-0 z-10 shadow-sm"
           style="top: 64px; height: calc(100vh - 64px);">

        {{-- Avatar + Nama --}}
        <div class="flex flex-col items-center mb-8">
            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-purple-200 mb-3 shadow bg-purple-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <p class="font-bold text-gray-800 text-sm text-center">Jesina Holy</p>
            <p class="text-xs text-purple-600 mt-0.5">Pengunjung</p>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="flex flex-col gap-1">
            <a href="{{ route('pengunjung.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-700 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                </svg>
                Beranda
            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-700 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Tiket Saya
            </a>

            {{-- Riwayat Pendaftaran - AKTIF --}}
            <a href="{{ route('pengunjung.riwayat') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-purple-50 text-purple-700 text-sm font-semibold border-l-4 border-purple-600">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Pendaftaran
            </a>

            <a href="{{ route('pengunjung.profil') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-700 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition text-sm font-medium text-left">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </nav>
    </aside>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <main class="flex-1 ml-56 px-8 py-8">

        {{-- Judul Halaman --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Pendaftaran</h1>
            <p class="text-sm text-gray-500 mt-1">Berikut adalah riwayat event yang telah Anda ikuti.</p>
        </div>

        {{-- Daftar Riwayat --}}
        <div class="flex flex-col gap-4">

            @forelse($riwayat as $item)

            @php
                // Parse tanggal dengan aman (support string maupun Carbon)
                $tgl       = \Carbon\Carbon::parse($item->event->tanggal);
                $hari      = $tgl->translatedFormat('l');   // Senin, Selasa, dst
                $tglFormat = $tgl->translatedFormat('j F Y'); // 29 Mei 2024

                $statusColor = match(strtolower($item->status)) {
                    'selesai' => 'bg-purple-100 text-purple-700',
                    'aktif'   => 'bg-green-100 text-green-700',
                    'batal'   => 'bg-red-100 text-red-700',
                    default   => 'bg-gray-100 text-gray-600',
                };
            @endphp

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex items-start gap-5 p-5 hover:shadow-md transition">

                {{-- Thumbnail --}}
                <div class="w-28 h-24 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center text-center text-white text-xs font-bold leading-tight p-2"
                     style="background: linear-gradient(135deg, #2b1238, #7a4988);">
                    @if($item->event->thumbnail)
                        <img src="{{ $item->event->thumbnail }}"
                             alt="{{ $item->event->nama }}"
                             class="w-full h-full object-cover">
                    @else
                        {{ $item->event->nama }}
                    @endif
                </div>

                {{-- Info Event --}}
                <div class="flex-1 min-w-0">
                    <h2 class="font-bold text-gray-900 text-base leading-tight mb-2">
                        {{ $item->event->nama }}
                    </h2>

                    {{-- Tanggal & Jam --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>
                            {{ $hari }}, {{ $tglFormat }}
                            &nbsp;&bull;&nbsp;
                            {{ $item->event->jam_mulai }} - {{ $item->event->jam_selesai }} WIB
                        </span>
                    </div>

                    {{-- Lokasi --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $item->event->lokasi }}</span>
                    </div>

                    <p class="text-sm text-gray-600">
                        Tiket: <span class="font-medium">{{ $item->jumlah }} x {{ $item->jenis_tiket }}</span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Kode Order:
                        <span class="font-semibold" style="color: #7c2f84;">{{ $item->kode_order }}</span>
                    </p>
                </div>

                {{-- Status & Tombol Aksi --}}
                <div class="flex flex-col items-end gap-3 flex-shrink-0" style="min-width: 180px;">

                    {{-- Badge Status --}}
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="px-3 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>

                    {{-- Tanggal ringkas --}}
                    <div class="text-right">
                        <div class="flex items-center justify-end gap-1.5 text-sm text-gray-600 mb-0.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $tglFormat }}
                        </div>
                        <div class="flex items-center justify-end gap-1.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $item->event->jam_mulai }} - {{ $item->event->jam_selesai }} WIB
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex flex-col gap-2 w-full">
                        <a href="{{ route('pengunjung.riwayat.detail', $item->id) }}"
                           class="w-full text-center text-sm font-semibold px-4 py-2 rounded-lg border transition hover:bg-purple-50"
                           style="border-color: #7c2f84; color: #7c2f84;">
                            Lihat Detail
                        </a>
                        <a href="{{ route('pengunjung.etiket', $item->id) }}"
                           class="w-full flex items-center justify-center gap-2 text-sm font-semibold px-4 py-2 rounded-lg border transition hover:bg-purple-50"
                           style="border-color: #7c2f84; color: #7c2f84;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.243m-4.243 0H7.757M12 12V7.757M12 12l-4.243 4.243"/>
                            </svg>
                            Lihat E-Tiket
                        </a>
                    </div>

                </div>
            </div>

            @empty
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-gray-500 text-sm">Belum ada riwayat pendaftaran event.</p>
            </div>
            @endforelse

        </div>

        {{-- ===================== PAGINATION ===================== --}}
        @if($riwayat->hasPages())
        <div class="flex justify-center items-center gap-2 mt-8">

            {{-- Prev --}}
            @if($riwayat->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed text-sm select-none">
                    &lt;
                </span>
            @else
                <a href="{{ $riwayat->previousPageUrl() }}"
                   class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-purple-50 transition text-sm">
                    &lt;
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                @if($page == $riwayat->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-bold text-white"
                          style="background-color: #7c2f84;">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-purple-50 transition text-sm font-medium">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($riwayat->hasMorePages())
                <a href="{{ $riwayat->nextPageUrl() }}"
                   class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-purple-50 transition text-sm">
                    &gt;
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed text-sm select-none">
                    &gt;
                </span>
            @endif

        </div>
        @endif

    </main>
</div>

@endsection