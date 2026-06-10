@extends('layouts.pengunjung')

@section('title', 'Dashboard Pengunjung')

@section('content')

{{-- HEADER --}}
<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-8 mb-8 text-white shadow-lg">

    <h1 class="text-4xl font-black">
        HALO, {{ strtoupper(Auth::user()->name ?? Auth::user()->username) }} 👋
    </h1>

    <p class="text-white/80 mt-2">
        Selamat datang kembali! Temukan event menarik dan dapatkan pengalaman terbaik.
    </p>

</div>

{{-- STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    <div class="bg-white rounded-2xl p-5 shadow-sm border">
        <p class="text-sm text-gray-500">
            Ticket Saya
        </p>

        <h2 class="text-4xl font-black text-[#24112e] mt-2">
            {{ $jumlahTiket }}
        </h2>

        <p class="text-xs text-gray-400">
            Ticket aktif
        </p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border">
        <p class="text-sm text-gray-500">
            Riwayat Pendaftaran
        </p>

        <h2 class="text-4xl font-black text-[#24112e] mt-2">
            {{ $riwayatPendaftaran }}
        </h2>

        <p class="text-xs text-gray-400">
            Event diikuti
        </p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border">
        <p class="text-sm text-gray-500">
            Event Mendatang
        </p>

        <h2 class="text-4xl font-black text-[#24112e] mt-2">
            {{ $eventMendatang }}
        </h2>

        <p class="text-xs text-gray-400">
            Event tersedia
        </p>
    </div>

</div>

{{-- FILTER --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">

    <form method="GET">

        <div class="grid md:grid-cols-3 gap-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari event atau lokasi..."
                class="border border-gray-200 rounded-xl px-4 py-3">

            <select
                name="kategori"
                class="border border-gray-200 rounded-xl px-4 py-3">

                <option value="">
                    Semua Kategori
                </option>

                <option value="Olahraga">
                    Olahraga
                </option>

                <option value="Seminar">
                    Seminar
                </option>

                <option value="Hiburan">
                    Hiburan
                </option>

            </select>

            <button
                type="submit"
                class="bg-[#7a4988] text-white rounded-xl font-bold">
                Cari Event
            </button>

        </div>

    </form>

</div>

{{-- EVENT --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($events as $event)

        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition">

            <img
                src="{{ asset('images/' . $event->poster) }}"
                class="h-56 w-full object-cover">

            <div class="p-5">

                <span class="bg-[#7a4988] text-white text-xs px-3 py-1 rounded-full">
                    {{ $event->kategori }}
                </span>

                <h3 class="text-xl font-bold mt-4 text-[#24112e]">
                    {{ strtoupper($event->judul) }}
                </h3>

                <p class="text-sm text-gray-500 mt-3">
                    📍 {{ $event->lokasi }}
                </p>

                <p class="text-sm text-gray-500">
                    📅 {{ date('d M Y', strtotime($event->tanggal)) }}
                </p>

                <p class="text-sm text-gray-500">
                    👥 {{ $event->kapasitas }} Orang
                </p>

                <div class="mt-5">

                    <a href="{{ route('pengunjung.event.show',$event->id_event) }}">
                       class="block text-center bg-gradient-to-r from-purple-600 to-pink-500 text-white py-3 rounded-xl font-bold">
                        LIHAT DETAIL
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div class="col-span-3">

            <div class="bg-white rounded-2xl p-10 text-center">

                <h3 class="text-xl font-bold text-gray-500">
                    Belum Ada Event
                </h3>

            </div>

        </div>

    @endforelse

</div>

<div class="mt-8">
    {{ $events->links() }}
</div>

@endsection