@extends('layouts.pengunjung')

@section('title','Data Kelompok')

@section('content')

<div class="container mx-auto">

    <h1 class="text-3xl font-bold text-[#7a4988] mb-6">
        Input Data Kelompok
    </h1>

    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">

            {{ session('success') }}

        </div>

    @endif

    <div class="bg-white shadow rounded-xl p-6 mb-8">

        <form method="POST"
              action="{{ route('kelompok.simpan') }}">

            @csrf

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Nama Kelompok
                </label>

                <input
                    type="text"
                    name="nama_kelompok"
                    class="w-full border rounded-lg p-3">

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Jumlah Anggota
                </label>

                <input
                    type="number"
                    name="jumlah_anggota"
                    class="w-full border rounded-lg p-3">

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Event ID
                </label>

                <input
                    type="number"
                    name="event_id"
                    class="w-full border rounded-lg p-3">

            </div>

            <button
                type="submit"
                class="bg-[#7a4988] text-white px-6 py-3 rounded-lg">

                Simpan

            </button>

        </form>

    </div>

    <div class="bg-white shadow rounded-xl p-6">

        <h2 class="text-2xl font-bold mb-5">
            Data Kelompok
        </h2>

        <table class="table-auto w-full border">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border p-3">No</th>
                    <th class="border p-3">Nama Kelompok</th>
                    <th class="border p-3">Jumlah Anggota</th>
                    <th class="border p-3">Event ID</th>

                </tr>

            </thead>

            <tbody>

                @forelse($kelompoks as $index => $kelompok)

                <tr>

                    <td class="border p-3">
                        {{ $index + 1 }}
                    </td>

                    <td class="border p-3">
                        {{ $kelompok->nama_kelompok }}
                    </td>

                    <td class="border p-3">
                        {{ $kelompok->jumlah_anggota }}
                    </td>

                    <td class="border p-3">
                        {{ $kelompok->event_id }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4"
                        class="border p-4 text-center">

                        Belum ada data kelompok

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection