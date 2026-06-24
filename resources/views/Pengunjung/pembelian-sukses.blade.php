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
            Tiket berhasil dipesan.

            Silakan lakukan pembayaran secara cash kepada panitia pada hari pelaksanaan event.
        </p>

        <p class="text-gray-500 mb-8">
            Detail tiket dapat dilihat pada menu
            <strong>Ticket Saya</strong>.
        </p>

        <a href="{{ route('pengunjung.tiket') }}"
           class="bg-[#7a4988] text-white px-8 py-3 rounded-xl">
            Lihat Tiket Saya
        </a>

    </div>

</div>

@endsection