@extends('layouts.pengunjung')

@section('title', 'Pembelian Tiket')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500 mb-4">
        Beranda >
        Acara >
        <span class="font-semibold text-[#7a4988]">
            Pembelian Tiket
        </span>
    </div>

    <h1 class="text-3xl font-bold text-[#24112e] mb-6">
        Pembelian Tiket
    </h1>

    <form action="{{ route('pengunjung.checkout.store') }}"
          method="POST">

        @csrf

        <div class="grid grid-cols-12 gap-6">

            {{-- ================= KIRI ================= --}}
            <div class="col-span-12 lg:col-span-8 space-y-5">

                {{-- Event --}}
                <div class="bg-white rounded-2xl border p-5">

                    <div class="flex flex-col md:flex-row gap-5">

                        <img src="{{ asset('storage/' . $event->gambar) }}"
                             class="w-64 h-40 object-cover rounded-xl">

                        <div class="flex-1">

                            <h2 class="text-2xl font-bold text-[#24112e]">
                                {{ $event->nama_event }}
                            </h2>

                            <div class="mt-3 space-y-2 text-gray-600">

                                <p>
                                    📅 {{ \Carbon\Carbon::parse($event->tanggal_event)->translatedFormat('l, d F Y') }}
                                </p>

                                <p>
                                    🕒 {{ $event->jam_mulai }}
                                    -
                                    {{ $event->jam_selesai }}
                                </p>

                                <p>
                                    📍 {{ $event->lokasi }}
                                </p>

                            </div>

                            <p class="mt-4 text-gray-700">
                                {{ $event->deskripsi }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Informasi Pembeli --}}
                <div class="grid md:grid-cols-2 gap-5">

                    <div class="bg-white border rounded-2xl p-5">

                        <h3 class="font-bold text-lg mb-4 text-[#7a4988]">
                            Informasi Pembeli
                        </h3>

                        <div class="space-y-3">

                            <div>

                                <label class="text-sm">
                                    Nama Lengkap
                                </label>

                                <input type="text"
                                       name="nama"
                                       value="{{ Auth::user()->name }}"
                                       class="w-full border rounded-lg px-3 py-2">

                            </div>

                            <div>

                                <label class="text-sm">
                                    No HP
                                </label>

                                <input type="text"
                                       name="no_hp"
                                       class="w-full border rounded-lg px-3 py-2">

                            </div>

                            <div>

                                <label class="text-sm">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       value="{{ Auth::user()->email }}"
                                       class="w-full border rounded-lg px-3 py-2">

                            </div>

                            <div>

                                <label class="text-sm">
                                    Alamat
                                </label>

                                <textarea name="alamat"
                                          rows="3"
                                          class="w-full border rounded-lg px-3 py-2"></textarea>

                            </div>

                        </div>

                    </div>

                    {{-- Pilihan Tiket --}}
                    <div class="bg-white border rounded-2xl p-5">

                        <h3 class="font-bold text-lg mb-4 text-[#7a4988]">
                            Pilihan Tiket
                        </h3>

                        <div class="space-y-3">

                            @foreach($event->tiket as $tiket)

                            <label
                                class="border rounded-xl p-4 flex gap-3 cursor-pointer hover:border-[#7a4988]">

                                <input type="radio"
                                       name="tiket_id"
                                       value="{{ $tiket->id }}"
                                       class="mt-1">

                                <div>

                                    <h4 class="font-semibold">
                                        {{ $tiket->nama_tiket }}
                                    </h4>

                                    <p class="text-[#7a4988] font-bold">
                                        Rp {{ number_format($tiket->harga,0,',','.') }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Sisa {{ $tiket->stok }}
                                    </p>

                                </div>

                            </label>

                            @endforeach

                        </div>

                        {{-- Jumlah --}}
                        <div class="mt-5">

                            <label class="font-semibold">
                                Jumlah Tiket
                            </label>

                            <input type="number"
                                   name="jumlah"
                                   min="1"
                                   value="1"
                                   class="w-28 mt-2 border rounded-lg px-3 py-2">

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================= KANAN ================= --}}
            <div class="col-span-12 lg:col-span-4 space-y-5">

                {{-- Metode Pembayaran --}}
                <div class="bg-white border rounded-2xl p-5">

                    <h3 class="font-bold text-lg mb-4 text-[#7a4988]">
                        Pilih Metode Pembayaran
                    </h3>

                    <div class="space-y-4">

                        <label class="flex items-center gap-3">

                            <input type="radio"
                                   name="metode_pembayaran"
                                   value="Transfer Bank">

                            Transfer Bank

                        </label>

                        <label class="flex items-center gap-3">

                            <input type="radio"
                                   name="metode_pembayaran"
                                   value="Virtual Account">

                            Virtual Account

                        </label>

                        <label class="flex items-center gap-3">

                            <input type="radio"
                                   name="metode_pembayaran"
                                   value="E-Wallet">

                            E-Wallet

                        </label>

                    </div>

                </div>

                {{-- Ringkasan --}}
                <div class="bg-white border rounded-2xl p-5">

                    <h3 class="font-bold text-lg mb-4 text-[#7a4988]">
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">

                            <span>Harga Tiket</span>

                            <span id="harga-tiket">
                                Rp 0
                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span>Biaya Layanan</span>

                            <span>
                                Rp 5.000
                            </span>

                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between font-bold text-xl text-[#7a4988]">

                        <span>Total</span>

                        <span id="total">
                            Rp 0
                        </span>

                    </div>

                    <button type="submit"
                            class="w-full mt-5 bg-[#7a4988] text-white py-3 rounded-xl font-semibold hover:bg-[#693b76]">

                        Bayar Sekarang

                    </button>

                    <a href="{{ route('pengunjung.event.show',$event->id) }}"
                       class="block text-center mt-3 border border-gray-300 py-3 rounded-xl text-gray-700 no-underline">

                        Batal

                    </a>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection