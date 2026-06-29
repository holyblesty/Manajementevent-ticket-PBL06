@extends('layouts.pengunjung')

@section('title','Pembelian Tiket')

@section('content')

<div class="max-w-6xl mx-auto p-6">

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        <div class="p-6 border-b">

            <h1 class="text-3xl font-bold">
                {{ $event->judul }}
            </h1>

            <p class="mt-2 text-gray-600">
                {{ $event->lokasi }}
            </p>

            <p class="text-gray-600">
                {{ $event->tgl_mulai }}
            </p>

        </div>

        <form
            action="{{ route('pengunjung.pembelian.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="id_event"
                value="{{ $event->id_event }}">

            <div class="p-6">

                <h3 class="text-xl font-semibold mb-4">
                    Pilih Jenis Tiket
                </h3>

                @foreach($event->tiket as $tiket)

                <label
                    class="flex justify-between border rounded-lg p-4 mb-3 cursor-pointer hover:bg-purple-50">

                    <div>

                        <input
                            type="radio"
                            name="id_tiket"
                            value="{{ $tiket->id_tiket }}"
                            data-harga="{{ $tiket->harga }}"
                            class="ticket-radio"
                            required>

                        <span class="ml-2 font-semibold">
                            {{ $tiket->jenis_tiket }}
                        </span>

                    </div>

                    <div>

                        Rp
                        {{ number_format($tiket->harga,0,',','.') }}

                        <br>

                        <small>
                            Kuota:
                            {{ $tiket->kuota_tersedia }}
                        </small>

                    </div>

                </label>

                @endforeach

                <div class="mt-6">

                    <label class="block mb-2">
                        Jumlah Tiket
                    </label>

                    <input
                        type="number"
                        id="jumlah"
                        name="jumlah_tiket"
                        value="1"
                        min="1"
                        class="w-full border rounded-lg">

                </div>

                <div class="mt-6 bg-gray-100 p-4 rounded-lg">

                    <div class="flex justify-between">

                        <span>Total Harga</span>

                        <span
                            id="totalHarga"
                            class="font-bold">

                            Rp 0

                        </span>

                    </div>

                </div>

                <div
                    class="mt-6 bg-yellow-50 border border-yellow-300 p-4 rounded-lg">

                    <strong>Pembayaran:</strong>

                    <p>
                        Pembayaran dilakukan secara
                        tunai (cash) kepada admin.
                    </p>

                </div>

                <button
                    type="submit"
                    class="mt-6 w-full bg-purple-700 hover:bg-purple-800 text-white py-3 rounded-lg">

                    Pesan Tiket

                </button>

            </div>

        </form>

    </div>

</div>

<script>

let harga = 0;

const radios =
    document.querySelectorAll('.ticket-radio');

const jumlah =
    document.getElementById('jumlah');

const total =
    document.getElementById('totalHarga');

function hitung()
{
    const qty =
        parseInt(jumlah.value || 1);

    const subtotal =
        harga * qty;

    total.innerHTML =
        'Rp ' +
        subtotal.toLocaleString('id-ID');
}

radios.forEach(radio => {

    radio.addEventListener('change', function(){

        harga =
            parseInt(
                this.dataset.harga
            );

        hitung();

    });

});

jumlah.addEventListener(
    'input',
    hitung
);

</script>

@endsection