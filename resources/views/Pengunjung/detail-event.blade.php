@extends('layouts.pengunjung')

@section('title', $event->judul)

@section('content')

{{-- Breadcrumb --}}
<div class="flex flex-wrap items-center gap-2 text-sm text-gray-400 mb-6">
    <span>Beranda</span> <span>›</span> <span>Event</span> <span>›</span>
    <span class="font-semibold text-[#7a4988]">Detail Event</span>
</div>

<div class="grid grid-cols-1 gap-8">
    {{-- HERO SECTION --}}
    <div class="bg-white rounded-3xl shadow-sm border p-6">
        <div class="grid lg:grid-cols-2 gap-8">
            {{-- Poster --}}
            <div>
                <img src="{{ asset('images/'.$event->poster) }}" alt="{{ $event->judul }}"
                    class="w-full rounded-2xl object-cover shadow">
            </div>

            {{-- Informasi --}}
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900">
                        {{ strtoupper($event->judul) }}
                    </h1>
                    <p class="mt-4 text-gray-500 leading-relaxed">{{ $event->deskripsi }}</p>

                    <div class="grid sm:grid-cols-2 gap-4 mt-8">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Tanggal</div>
                            <div class="font-semibold">
                                {{ \Carbon\Carbon::parse($event->tgl_mulai)->translatedFormat('l, d F Y') }}
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Waktu</div>
                            <div class="font-semibold">{{ $event->jam_mulai }} WIB</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Lokasi</div>
                            <div class="font-semibold">{{ $event->lokasi }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Total Sisa Kuota</div>
                            {{-- Menghitung total sisa kuota dari relasi tiket --}}
                            <div class="font-semibold">
                                {{ $event->tiket->sum('kuota_tersedia') }} Peserta
                            </div>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-8">
                        {{-- Cek apakah ada tiket yang tersedia --}}
                        @if($event->tiket->sum('kuota_tersedia') > 0)
                            <a href="{{ route('pengunjung.pendaftaran.create', $event->id_event) }}"
                                class="px-6 py-3 bg-[#7a4988] text-white rounded-xl text-sm font-semibold hover:bg-[#693b76]">
                                Beli Sekarang
                            </a>
                        @else
                            <button disabled class="px-8 py-3 rounded-xl bg-gray-300 text-white">
                                Kuota Penuh
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMASI TIKET DETAIL --}}
    <div class="bg-white rounded-3xl border shadow-sm p-8">
        <h2 class="text-2xl font-bold mb-5">Daftar Tiket</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($event->tiket as $t)
                <div class="p-4 border rounded-xl {{ $t->kuota_tersedia <= 0 ? 'bg-red-50' : 'bg-gray-50' }}">
                    <h3 class="font-bold text-lg">{{ $t->jenis_tiket }}</h3>
                    <p class="text-sm text-gray-500">Harga: Rp{{ number_format($t->harga) }}</p>
                    <p class="font-semibold mt-2">
                        Sisa: {{ $t->kuota_tersedia > 0 ? $t->kuota_tersedia : 'Habis' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection