@extends('layouts.pengunjung')

@section('title','Pemesanan Berhasil')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-3xl shadow-lg p-10 text-center">

        <div class="w-24 h-24 mx-auto rounded-full bg-green-100 flex items-center justify-center mb-6">
            ✓
        </div>

        <h1 class="text-4xl font-bold text-[#7a4988] mb-4">
            Pemesanan Berhasil
        </h1>

       <p class="text-gray-600 mb-8">
    Pemesanan tiket berhasil dibuat.
    Silakan lakukan pembayaran sesuai metode yang dipilih dan tunggu proses verifikasi dari admin.
</p>

<p class="text-gray-500 mb-8">
    Status pemesanan dapat dipantau melalui menu
    <strong>Riwayat Pendaftaran</strong>.

    Setelah pembayaran diverifikasi dan dinyatakan <strong>Lunas</strong>,
    tiket akan otomatis muncul pada menu
    <strong>Tiket Saya</strong>.
</p>

<a href="{{ route('pengunjung.riwayat') }}"
   class="bg-[#7a4988] text-white px-8 py-3 rounded-xl">
    Lihat Riwayat Pendaftaran
</a>

    </div>

</div>

@endsection