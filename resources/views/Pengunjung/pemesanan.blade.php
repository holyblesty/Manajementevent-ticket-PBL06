@extends('layouts.pengunjung')

@section('title', isset($success) ? 'Pesanan Berhasil' : 'Pembelian Tiket')

@section('content')

@if(isset($success))

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
             {{ $pemesanan->kode_registrasi }}
            </p>
            <p class="text-xs text-gray-400 mt-2">Simpan kode ini sebagai bukti pemesanan</p>
        </div>

        {{-- Detail Pesanan --}}
        <div class="text-left bg-gray-50 rounded-xl p-5 space-y-3 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Event</span>
                <span class="font-semibold text-gray-800 text-right max-w-xs">
                    {{ $pemesanan->event->judul }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Tanggal</span>
                <span class="font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($pemesanan->event->tgl_mulai)->translatedFormat('d F Y') }}
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Lokasi</span>
                <span class="font-semibold text-gray-800 text-right max-w-xs">{{ $pemesanan->event->lokasi }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Jenis Tiket</span>
                <span class="font-semibold text-gray-800">{{ $pemesanan->tiket->jenis_tiket }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Jumlah Tiket</span>
                <span class="font-semibold text-gray-800">{{ $pemesanan->jumlah_tiket }} tiket</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Metode Pembayaran</span>
                <span class="font-semibold text-gray-800">
                    {{ $pemesanan->metode_pembayaran }}

@if($pemesanan->bank_tujuan)
    - {{ $pemesanan->bank_tujuan }}
@endif
                </span>
            </div>
            <div class="border-t border-gray-200 pt-3 flex justify-between">
                <span class="font-bold text-gray-900">Total Pembayaran</span>
                <span class="font-bold text-purple-700 text-lg">
                   Rp {{ number_format($pemesanan->total_harga,0,',','.') }}
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
                        Lakukan transfer sebesar <strong>
                            Rp {{ number_format($pemesanan->total_harga,0,',','.') }}

                        </strong>
                        ke ke {{ $pemesanan->metode_pembayaran }}

@if($pemesanan->bank_tujuan)
    {{ $pemesanan->bank_tujuan }}
@endif
                        @if($pemesanan->bank_pilihan) {{ $pemesanan->bank_pilihan }} @endif.
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
            <a href="{{ route('pengunjung.dashboard') }}"
                class="flex-1 border-2 border-purple-800 text-purple-800 hover:bg-purple-50 font-bold py-3 rounded-xl text-sm transition-all">
                <i class="fa-solid fa-calendar-days mr-2"></i>Cari Event Lainnya
            </a>
        </div>

    </div>
</div>
@else
<div class="mb-6">
    <h1 class="text-3xl font-bold text-[#7a4988]">
        Pembelian Tiket
    </h1>

    <p class="text-gray-500 mt-2">
        Lengkapi data pemesanan tiket event.
    </p>
</div>

@if(session('error'))
<div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
    <ul>
        @foreach($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form
    action="{{ route('pengunjung.pembelian.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf

    <input type="hidden"
        name="id_event"
        value="{{ $event->id_event }}">

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Informasi Event --}}
        <div class="lg:col-span-1">

            <div class="bg-white rounded-3xl shadow p-6">

                <img
                    src="{{ asset('images/'.$event->poster) }}"
                    class="w-full rounded-2xl mb-5">

                <h2 class="text-2xl font-bold text-[#7a4988]">
                    {{ $event->judul }}
                </h2>

                <p class="text-gray-500 mt-3">
                    {{ $event->deskripsi }}
                </p>

                <div class="mt-5 space-y-3">

                    <div>
                        <span class="font-semibold">
                            Lokasi:
                        </span>

                        {{ $event->lokasi }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Tanggal:
                        </span>

                        {{ $event->tgl_mulai }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Jam:
                        </span>

                        {{ $event->jam_mulai }}
                    </div>

                </div>

            </div>

        </div>

        {{-- Form --}}
        <div class="lg:col-span-2">

            <div class="bg-white rounded-3xl shadow p-8">

                <h2 class="text-2xl font-bold mb-6 text-[#7a4988]">
                    Data Pemesan
                </h2>

                <div class="grid md:grid-cols-2 gap-5">

                    <div>
                        <label class="font-semibold">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ $pengunjung->name }}"
                            class="w-full mt-2 border rounded-xl p-3">
                    </div>

                    <div>
                        <label class="font-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ $pengunjung->email }}"
                            class="w-full mt-2 border rounded-xl p-3">
                    </div>

                    <div>
                        <label class="font-semibold">
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ $pengunjung->no_hp }}"
                            class="w-full mt-2 border rounded-xl p-3">
                    </div>

                    <div>
                        <label class="font-semibold">
                            Alamat
                        </label>

                        <input
                            type="text"
                            name="alamat"
                            value="{{ $pengunjung->alamat }}"
                            class="w-full mt-2 border rounded-xl p-3">
                    </div>

                </div>

                <hr class="my-8">

                <h2 class="text-2xl font-bold mb-6 text-[#7a4988]">
                    Tiket
                </h2>

                <div class="space-y-5">

                    <div>

                        <label class="font-semibold">
                            Jenis Tiket
                        </label>

                        <select
                            name="id_tiket"
                            id="id_tiket"
                            class="w-full mt-2 border rounded-xl p-3">

                            <option value="">
                                Pilih Tiket
                            </option>

                            @foreach($tiket as $item)

                            <option
                                value="{{ $item->id_tiket }}"
                                data-harga="{{ $item->harga }}">

                                {{ $item->jenis_tiket }}
                                -
                                Rp {{ number_format($item->harga,0,',','.') }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="font-semibold">
                            Harga Tiket
                        </label>

                        <input
                            type="text"
                            id="harga"
                            readonly
                            class="w-full mt-2 border rounded-xl p-3 bg-gray-100">

                    </div>

                    <div>

                        <label class="font-semibold">
                            Jumlah Tiket
                        </label>

                        <input
                            type="number"
                            name="jumlah_tiket"
                            id="jumlah_tiket"
                            min="1"
                            value="1"
                            class="w-full mt-2 border rounded-xl p-3">

                    </div>

                   <div>
    <label class="block mb-2 font-semibold">
        Metode Pembayaran
    </label>

    <select
        name="metode_pembayaran"
        id="metode_pembayaran"
        class="w-full border rounded-xl p-3">

        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>

    </select>
</div>
<div id="bankSection" style="display:none;">

    <label class="block mb-2 font-semibold">
        Pilih Bank
    </label>

    <select
        name="bank_tujuan"
        id="bank_tujuan"
        class="w-full border rounded-xl p-3">

        <option value="">Pilih Bank</option>

        <option value="BCA">
            BCA
        </option>

        <option value="BRI">
            BRI
        </option>

        <option value="BNI">
            BNI
        </option>

        <option value="Mandiri">
            Mandiri
        </option>

    </select>

</div>
<div
    id="vaSection"
    style="display:none;"
    class="mt-4">

    <label class="block mb-2 font-semibold">

        Nomor Virtual Account

    </label>

    <input
        type="text"
        id="nomorVA"
        readonly
        class="w-full border rounded-xl p-3 bg-gray-100">

</div>
<div
    id="uploadSection"
    class="mt-4">

    <label class="block mb-2 font-semibold">

        Upload Bukti Transfer

    </label>

    <input
        type="file"
        name="bukti_transfer"
        class="w-full border rounded-xl p-3">

</div>
<div
    id="cashSection"
    class="mt-4 bg-yellow-100 rounded-xl p-4">

    <p class="font-semibold">

        Pembayaran Cash

    </p>

    <p>

        Silakan melakukan pembayaran
        langsung kepada panitia sebelum
        batas pembayaran.

    </p>

</div>
                    <div>

                        <label class="font-semibold">
                            Total Harga
                        </label>

                        <input
                            type="text"
                            id="total"
                            readonly
                            class="w-full mt-2 border rounded-xl p-3 bg-purple-100 font-bold text-[#7a4988]">

                    </div>

                </div>

                <button
                    type="submit"
                    class="mt-8 w-full bg-[#7a4988] hover:bg-[#693b76] text-white py-4 rounded-xl font-semibold">

                    Pesan Tiket

                </button>

            </div>

        </div>
    </div>

</form>

<script>

    const tiket = document.getElementById('id_tiket');
    const jumlah = document.getElementById('jumlah_tiket');
    const harga = document.getElementById('harga');
    const total = document.getElementById('total');

    function hitungTotal()
    {
        let selected =
            tiket.options[tiket.selectedIndex];

        let hrg =
            selected.getAttribute('data-harga') || 0;

        harga.value =
            'Rp ' +
            Number(hrg).toLocaleString('id-ID');

        total.value =
            'Rp ' +
            (hrg * jumlah.value)
            .toLocaleString('id-ID');
    }

    tiket.addEventListener(
        'change',
        hitungTotal
    );

    jumlah.addEventListener(
        'input',
        hitungTotal
    );

    // ============================
    // METODE PEMBAYARAN
    // ============================

    const metode = document.getElementById('metode_pembayaran');
    const bank = document.getElementById('bank_tujuan');

    const bankSection = document.getElementById('bankSection');
    const vaSection = document.getElementById('vaSection');
    const uploadSection = document.getElementById('uploadSection');
    const cashSection = document.getElementById('cashSection');

    metode.addEventListener('change', function () {

        if (this.value == 'Transfer') {

            bankSection.style.display = 'block';
            uploadSection.style.display = 'block';
            cashSection.style.display = 'none';

        } else {

            bankSection.style.display = 'none';
            uploadSection.style.display = 'none';
            vaSection.style.display = 'none';
            cashSection.style.display = 'block';

        }

    });

    bank.addEventListener('change', function () {

        let nomor = '';

        if (this.value == 'BCA')
            nomor = '88001122334455';

        if (this.value == 'BRI')
            nomor = '99001122334455';

        if (this.value == 'BNI')
            nomor = '77001122334455';

        if (this.value == 'Mandiri')
            nomor = '66001122334455';

        document.getElementById('nomorVA').value = nomor;

        vaSection.style.display = 'block';

    });

</script>

@endif

@endsection

