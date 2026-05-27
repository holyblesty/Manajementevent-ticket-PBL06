@extends('layouts.pengunjung')

@section('title', 'Pendaftaran Event Kelompok')

@section('content')

{{-- BREADCRUMB --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">

    <span>Beranda</span>
    <span>›</span>

    <span>Acara</span>
    <span>›</span>

    <span class="text-[#7a4988] font-semibold">
        Pendaftaran Event Kelompok
    </span>

</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    {{-- LEFT CONTENT --}}
    <div class="xl:col-span-2">

        {{-- TITLE --}}
        <div class="mb-6">

            <h1 class="text-4xl font-bold text-[#7a4988]">
                Pendaftaran Event (Kelompok)
            </h1>

            <p class="text-gray-500 mt-2">
                Lengkapi data di bawah ini untuk mendaftar pada event yang dipilih sebagai kelompok.
            </p>

        </div>

        {{-- EVENT CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col lg:flex-row gap-6">

            {{-- IMAGE --}}
            <div class="w-full lg:w-60">

                <img src="{{ asset('images/events/basket.jpg') }}"
                     class="w-full h-56 object-cover rounded-xl">

            </div>

            {{-- INFO --}}
            <div class="flex-1">

                <h2 class="text-2xl font-bold text-[#24112e]">
                    TURNAMEN BASKET 2026
                </h2>

                <p class="text-gray-500 mt-3 leading-relaxed">

                    Turnamen olahraga antar tim untuk menjunjung sportivitas,
                    kebersamaan, dan semangat kompetisi yang sehat.

                </p>

                <div class="mt-5 space-y-3 text-gray-600">

                    <p>📅 Sabtu, 15 Maret 2026</p>

                    <p>🕒 08.00 - 17.00 WIB</p>

                    <p>📍 Gelanggang Olahraga (GOR) Bandung</p>

                    <p>👥 Turnamen Kelompok (Minimal 5 Orang)</p>

                </div>

            </div>

        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mt-8">

            <h3 class="text-2xl font-bold text-[#24112e] mb-6">
                Data Kelompok (Penanggung Jawab)
            </h3>

            {{-- INPUT --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 text-sm font-semibold">
                        Nama Lengkap *
                    </label>

                    <input type="text"
                           placeholder="Masukkan nama lengkap"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#7a4988] focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold">
                        Email *
                    </label>

                    <input type="email"
                           placeholder="Masukkan email aktif"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#7a4988] focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold">
                        No. Telepon *
                    </label>

                    <input type="text"
                           placeholder="Masukkan nomor telepon"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#7a4988] focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold">
                        Nama Tim / Instansi *
                    </label>

                    <input type="text"
                           placeholder="Masukkan nama tim atau instansi"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#7a4988] focus:outline-none">
                </div>

            </div>

            {{-- TABLE MEMBER --}}
            <div class="mt-10">

                <h4 class="text-xl font-bold text-[#7a4988] mb-5">
                    Anggota Kelompok Minimal 5 Orang
                </h4>

                <div class="overflow-x-auto">

                    <table class="w-full border border-gray-200 rounded-xl overflow-hidden">

                        <thead class="bg-[#f9f5fc]">

                            <tr class="text-left text-sm text-[#24112e]">

                                <th class="px-4 py-3">No.</th>
                                <th class="px-4 py-3">Nama Lengkap</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">No. Telepon</th>

                            </tr>

                        </thead>

                        <tbody>

                            @for($i = 1; $i <= 5; $i++)

                            <tr class="border-t border-gray-100">

                                <td class="px-4 py-3 font-semibold">
                                    {{ $i }}
                                </td>

                                <td class="px-4 py-3">

                                    <input type="text"
                                           placeholder="Masukkan nama lengkap"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">

                                </td>

                                <td class="px-4 py-3">

                                    <input type="email"
                                           placeholder="Masukkan email aktif"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">

                                </td>

                                <td class="px-4 py-3">

                                    <input type="text"
                                           placeholder="Masukkan nomor telepon"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">

                                </td>

                            </tr>

                            @endfor

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- INSTANSI --}}
            <div class="mt-8">

                <label class="block mb-2 text-sm font-semibold">
                    Instansi / Perusahaan (Opsional)
                </label>

                <input type="text"
                       placeholder="Masukkan instansi atau perusahaan"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3">

            </div>

            {{-- ALASAN --}}
            <div class="mt-8">

                <label class="block mb-2 text-sm font-semibold">
                    Alasan Mengikuti Event *
                </label>

                <textarea rows="5"
                          placeholder="Ceritakan alasan kelompok Anda mengikuti event ini"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3"></textarea>

            </div>

        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

            <h2 class="text-2xl font-bold text-[#24112e] mb-6">
                Pilih Tiket
            </h2>

            {{-- TICKET 1 --}}
            <div class="border-2 border-[#7a4988] rounded-2xl p-5 mb-4">

                <div class="flex justify-between">

                    <div>

                        <div class="flex items-center gap-3">

                            <input type="radio" checked>

                            <span class="font-bold text-[#24112e]">
                                Turnamen Basket (Kelompok)
                            </span>

                        </div>

                        <h3 class="text-2xl font-bold text-[#7a4988] mt-3">
                            Rp 150.000 / Tim
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            Minimal 5 orang per tim
                        </p>

                        <p class="text-sm text-gray-500">
                            Akses semua sesi pertandingan
                        </p>

                    </div>

                    <span class="text-sm text-gray-400">
                        Sisa 50
                    </span>

                </div>

            </div>

            {{-- TICKET 2 --}}
            <div class="border border-gray-200 rounded-2xl p-5 mb-4">

                <div class="flex justify-between">

                    <div>

                        <div class="flex items-center gap-3">

                            <input type="radio">

                            <span class="font-bold text-[#24112e]">
                                Normal (Kelompok)
                            </span>

                        </div>

                        <h3 class="text-2xl font-bold text-[#24112e] mt-3">
                            Rp 200.000 / Tim
                        </h3>

                    </div>

                    <span class="text-sm text-gray-400">
                        Sisa 120
                    </span>

                </div>

            </div>

            {{-- TICKET 3 --}}
            <div class="border border-gray-200 rounded-2xl p-5">

                <div class="flex justify-between">

                    <div>

                        <div class="flex items-center gap-3">

                            <input type="radio">

                            <span class="font-bold text-[#24112e]">
                                VIP (Kelompok)
                            </span>

                        </div>

                        <h3 class="text-2xl font-bold text-[#24112e] mt-3">
                            Rp 300.000 / Tim
                        </h3>

                    </div>

                    <span class="text-sm text-gray-400">
                        Sisa 30
                    </span>

                </div>

            </div>

            {{-- JUMLAH --}}
            <div class="mt-8">

                <label class="block mb-2 text-sm font-semibold">
                    Jumlah Tiket
                </label>

                <input type="number"
                       placeholder="Masukkan jumlah tiket"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3">

            </div>

            {{-- TOTAL --}}
            <div class="flex items-center justify-between mt-8">

                <span class="font-semibold text-gray-600">
                    Total Pembayaran
                </span>

                <span class="text-2xl font-bold text-[#7a4988]">
                    Rp 0
                </span>

            </div>

            {{-- BUTTON --}}
            <button class="w-full mt-6 bg-[#7a4988] text-white py-4 rounded-xl font-bold hover:bg-[#693b76] transition">

                Daftar Sekarang

            </button>

            {{-- INFO --}}
            <div class="mt-6 bg-[#f9f5fc] border border-[#eadcf2] rounded-xl p-4 text-sm text-gray-600">

                ℹ️ Setelah pendaftaran berhasil, Anda akan mendapatkan
                konfirmasi melalui email dan tiket dapat dilihat di menu
                <span class="font-semibold text-[#7a4988]">
                    Ticket Saya
                </span>

            </div>

        </div>

    </div>

</div>

@endsection