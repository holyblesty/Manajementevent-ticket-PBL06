@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-[#7a4988]">
        Verifikasi Pembayaran
    </h1>

    <p class="text-gray-500 mt-2">
        Daftar pembayaran transfer yang menunggu persetujuan admin.
    </p>
</div>

<div class="bg-white rounded-3xl shadow-lg overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#7a4988] text-white">

                <tr>

                    <th class="px-6 py-4 text-left">
                        Kode
                    </th>

                    <th class="px-6 py-4 text-left">
                        Pengunjung
                    </th>

                    <th class="px-6 py-4 text-left">
                        Event
                    </th>

                    <th class="px-6 py-4 text-left">
                        Bank
                    </th>

                    <th class="px-6 py-4 text-left">
                        Total
                    </th>
                    <th class="px-6 py-4 text-left">
                        Batas Bayar
                    </th>

                    <th class="px-6 py-4 text-center">
                        Bukti
                    </th>

                    <th class="px-6 py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($pemesanan as $item)

                <tr class="border-b hover:bg-purple-50">

                    <td class="px-6 py-4 font-semibold">
                        {{ $item->kode_registrasi }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->pengunjung->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->event->judul }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->bank_tujuan }}
                    </td>

                    <td class="px-6 py-4 font-semibold text-[#7a4988]">

                        Rp {{ number_format($item->total_harga,0,',','.') }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        @if($item->bukti_transfer)

                            <a
                                href="{{ asset('storage/'.$item->bukti_transfer) }}"
                                target="_blank"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">

                                Lihat

                            </a>

                        @else

                            <span class="text-red-500">
                                Tidak Ada
                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex justify-center gap-2">

                            <form
                                action="{{ route('admin.verifikasi.acc',$item->id_pesanan) }}"
                                method="POST">

                                @csrf
                                @method('PUT')

                                <button
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">

                                    ACC

                                </button>

                            </form>

                            <form
                                action="{{ route('admin.verifikasi.tolak',$item->id_pesanan) }}"
                                method="POST">

                                @csrf
                                @method('PUT')

                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                                    Tolak

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="7"
                        class="text-center py-10 text-gray-500">

                        Belum ada pembayaran yang menunggu verifikasi.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection