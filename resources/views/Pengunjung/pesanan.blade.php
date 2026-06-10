@extends('layouts.pengunjung')

@section('title', 'Pesanan Berhasil')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="card p-10 text-center">

        {{-- Icon Sukses --}}
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-circle-check text-green-500 text-5xl"></i>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-500 text-sm mb-8">
            Pesanan Anda sedang diproses. Silakan lakukan pembayaran sesuai metode yang dipilih.
        </p>

        {{-- Kode Pesanan --}}
        <div class="bg-purple-50 border-2 border-purple-200 border-dashed rounded-2xl p-5 mb-6">
            <p class="text-xs text-purple-500 font-medium uppercase tracking-widest mb-1">Kode Pesanan</p>
            <p class="text-3xl font-bold text-purple-800 font-mono tracking-wider">
                {{ $pesanan->kode_pesanan }}
            </p>
            <p class="text-xs text-gray-400 mt-2">Simpan kode ini sebagai bukti pemesanan</p>
        </div>

        {{-- Detail Pesanan --}}
        <div class="text-left bg-gray-50 rounded-xl p-5 space-y-3 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Event</span>
                <span class="font-semibold text-gray-800 text-right max-w-xs">{{ $pesanan->event->judul }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Tanggal</span>
                <span class="font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($pesanan->event->tanggal)->translatedFormat('d F Y') }}
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Lokasi</span>
                <span class="font-semibold text-gray-800 text-right max-w-xs">{{ $pesanan->event->lokasi }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Jenis Tiket</span>
                <span class="font-semibold text-gray-800">{{ $pesanan->tiket->jenis_tiket }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Jumlah Tiket</span>
                <span class="font-semibold text-gray-800">{{ $pesanan->jumlah_tiket }} tiket</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Metode Pembayaran</span>
                <span class="font-semibold text-gray-800">
                    {{ $pesanan->metode_pembayaran }}{{ $pesanan->bank_pilihan ? ' - ' . $pesanan->bank_pilihan : '' }}
                </span>
            </div>
            <div class="border-t border-gray-200 pt-3 flex justify-between">
                <span class="font-bold text-gray-900">Total Pembayaran</span>
                <span class="font-bold text-purple-700 text-lg">
                    Rp {{ number_format($pesanan->grand_total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Info Pembayaran --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-left mb-8">
            <div class="flex items-start gap-2">
                <i class="fa-solid fa-triangle-exclamation text-yellow-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-semibold text-yellow-800 mb-1">Selesaikan Pembayaran</p>
                    <p class="text-xs text-yellow-700">
                        Lakukan transfer sebesar <strong>Rp {{ number_format($pesanan->grand_total, 0, ',', '.') }}</strong>
                        ke {{ $pesanan->metode_pembayaran }}
                        @if($pesanan->bank_pilihan) {{ $pesanan->bank_pilihan }} @endif.
                        Pesanan akan dikonfirmasi setelah pembayaran diverifikasi admin.
                    </p>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('pengunjung.riwayat') }}"
                class="flex-1 bg-purple-800 hover:bg-purple-900 text-white font-bold py-3 rounded-xl text-sm transition-all">
                <i class="fa-solid fa-list-check mr-2"></i>Lihat Riwayat Pesanan
            </a>
            <a href="{{ route('pengunjung.acara') }}"
                class="flex-1 border-2 border-purple-800 text-purple-800 hover:bg-purple-50 font-bold py-3 rounded-xl text-sm transition-all">
                <i class="fa-solid fa-calendar-days mr-2"></i>Cari Event Lainnya
            </a>
        </div>

    </div>
</div>

@endsection