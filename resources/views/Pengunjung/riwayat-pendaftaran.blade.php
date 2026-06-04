@extends('layouts.pengunjung')

@section('title', 'Riwayat Pendaftaran')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-purple-800">Riwayat Pendaftaran</h1>
    <p class="text-sm text-gray-500 mt-1">Semua pesanan tiket Anda</p>
</div>

@if($pesanans->count() > 0)
    <div class="space-y-4">
        @foreach($pesanans as $pesanan)
            @php
                $statusColor = match($pesanan->status) {
                    'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                    default     => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                };
                $statusLabel = match($pesanan->status) {
                    'confirmed' => 'Dikonfirmasi',
                    'cancelled' => 'Dibatalkan',
                    default     => 'Menunggu Konfirmasi',
                };
                $statusIcon = match($pesanan->status) {
                    'confirmed' => 'fa-circle-check',
                    'cancelled' => 'fa-circle-xmark',
                    default     => 'fa-clock',
                };
            @endphp

            <div class="card p-5 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:items-start gap-4">

                    {{-- Poster --}}
                    <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-purple-900">
                        @if($pesanan->event->poster)
                            <img src="{{ asset('storage/' . $pesanan->event->poster) }}"
                                alt="{{ $pesanan->event->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa-solid fa-calendar text-purple-300 text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">{{ $pesanan->event->judul }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Kode: <span class="font-mono font-semibold text-purple-700">{{ $pesanan->kode_pesanan }}</span></p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 border text-xs font-semibold px-3 py-1.5 rounded-full {{ $statusColor }}">
                                <i class="fa-solid {{ $statusIcon }} text-xs"></i>
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <p class="text-xs text-gray-400">Tanggal Event</p>
                                <p class="text-sm font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($pesanan->event->tanggal)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Jenis Tiket</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $pesanan->tiket->jenis_tiket }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Jumlah</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $pesanan->jumlah_tiket }} tiket</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Total Bayar</p>
                                <p class="text-sm font-bold text-purple-700">Rp {{ number_format($pesanan->grand_total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center gap-2 text-xs text-gray-400">
                            <i class="fa-regular fa-clock"></i>
                            <span>Dipesan {{ \Carbon\Carbon::parse($pesanan->created_at)->diffForHumans() }}</span>
                            <span class="mx-1">•</span>
                            <i class="fa-solid fa-credit-card"></i>
                            <span>{{ $pesanan->metode_pembayaran }}{{ $pesanan->bank_pilihan ? ' - ' . $pesanan->bank_pilihan : '' }}</span>
                        </div>
                    </div>

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2 justify-end">

                    @if($pesanan->status === 'pending')
                        {{-- Edit --}}
                        <a href="{{ route('pengunjung.pesanan.edit', $pesanan->id_pesanan) }}"
                            class="flex items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit Pesanan
                        </a>

                        {{-- Batalkan --}}
                        <form action="{{ route('pengunjung.pesanan.cancel', $pesanan->id_pesanan) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan pesanan {{ $pesanan->kode_pesanan }}?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="flex items-center gap-2 bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                                <i class="fa-solid fa-ban"></i>
                                Batalkan
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'cancelled')
                        {{-- Hapus permanen --}}
                        <form action="{{ route('pengunjung.pesanan.destroy', $pesanan->id_pesanan) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus riwayat pesanan ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                                <i class="fa-solid fa-trash"></i>
                                Hapus
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'confirmed')
                        {{-- Lihat Tiket --}}
                        <a href="{{ route('pengunjung.tiket-saya') }}"
                            class="flex items-center gap-2 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                            <i class="fa-solid fa-ticket"></i>
                            Lihat Tiket
                        </a>
                    @endif

                    {{-- Detail Event --}}
                    <a href="{{ route('pengunjung.acara.detail', $pesanan->event->id_event) }}"
                        class="flex items-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                        <i class="fa-solid fa-eye"></i>
                        Detail Event
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $pesanans->links() }}
    </div>

@else
    {{-- Empty state --}}
    <div class="card p-16 text-center">
        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-ticket text-purple-400 text-3xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat Pendaftaran</h3>
        <p class="text-sm text-gray-500 mb-6">Anda belum pernah memesan tiket. Mulai jelajahi event sekarang!</p>
        <a href="{{ route('pengunjung.acara') }}"
            class="inline-flex items-center gap-2 bg-purple-800 hover:bg-purple-900 text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all">
            <i class="fa-solid fa-calendar-days"></i>
            Jelajahi Event
        </a>
    </div>
@endif

@endsection