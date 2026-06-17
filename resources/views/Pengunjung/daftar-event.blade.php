@extends('layouts.pengunjung')

@section('title','Pendaftaran Event')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white p-8 rounded-3xl shadow">

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- POSTER --}}
            <div>

                <img
                    src="{{ asset('images/'.$event->poster) }}"
                    class="rounded-2xl w-full">

            </div>

            {{-- FORM --}}
            <div>

                <h1
                    class="text-3xl font-bold text-[#24112e]">

                    Pendaftaran Event

                </h1>

                <p class="mt-2 text-gray-500">

                    {{ $event->judul }}

                </p>

                <form
                    action="{{ route('event.daftar.store',$event->id_event) }}"
                    method="POST"
                    class="space-y-5 mt-8">

                    @csrf

                    <div>

                        <label>
                            Nama Peserta
                        </label>

                        <input
                            type="text"
                            name="nama_peserta"
                            value="{{ auth()->user()->name }}"
                            class="w-full border rounded-xl p-3">

                    </div>

                    <div>

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            value="{{ auth()->user()->email }}"
                            class="w-full border rounded-xl p-3">

                    </div>

                    <div>

                        <label>No HP</label>

                        <input
                            type="text"
                            name="no_hp"
                            class="w-full border rounded-xl p-3">

                    </div>

                    <div>

                        <label>Pilih Tiket</label>

                        <select
                            name="id_tiket"
                            class="w-full border rounded-xl p-3">

                            @foreach($event->tiket as $tiket)

                                <option
                                    value="{{ $tiket->id_tiket }}">

                                    {{ $tiket->nama_tiket }}
                                    -
                                    Rp {{ number_format($tiket->harga,0,',','.') }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label>Jumlah Tiket</label>

                        <input
                            type="number"
                            name="jumlah_tiket"
                            value="1"
                            min="1"
                            class="w-full border rounded-xl p-3">

                    </div>

                    <button
                        class="w-full bg-[#7a4988]
                               text-white
                               py-4
                               rounded-xl
                               font-semibold">

                        Konfirmasi Pendaftaran

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection