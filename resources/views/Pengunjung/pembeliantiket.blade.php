@extends('layouts.pengunjung')

@section('title', 'Pembelian Tiket')

@section('content')

{{-- SweetAlert Notifikasi jika kuota habis atau ada error --}}
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
    });
</script>
@endif

<div class="mb-4">
    <p class="text-xs text-gray-400">Beranda > Acara > <span class="text-gray-600 font-medium">Pembelian Tiket</span></p>
    <h1 class="text-2xl font-black text-[#24112e] mt-1 uppercase">Pembelian Tiket</h1>
</div>

{{-- Form diarahkan ke nama route store milik admin/kelompok --}}
<form action="{{ route('pengunjung.event.daftar.store', $event->id_event) }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- SISI KIRI: DETAIL EVENT & DATA DIRI PENGUNJUNG --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Detail Event --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-48 h-48 rounded-xl overflow-hidden shadow-inner bg-gray-100 flex-shrink-0">
                    <img src="{{ asset('images/' . $event->poster) }}" class="w-full h-full object-cover" alt="Poster Event">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-black text-[#24112e]">{{ strtoupper($event->judul) }}</h2>
                        <div class="mt-3 space-y-1.5 text-sm text-gray-500 font-medium">
                            <p class="flex items-center gap-2">📅 {{ date('D, d M Y', strtotime($event->tanggal)) }} &bull; {{ date('H.i', strtotime($event->waktu_acara)) }} WIB</p>
                            <p class="flex items-center gap-2">📍 {{ $event->lokasi }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 leading-relaxed line-clamp-3">
                        {{ $event->deskripsi ?? 'Tidak ada deskripsi event.' }}
                    </p>
                </div>
            </div>

            {{-- Informasi Pembeli (Otomatis terisi dari akun login) --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-[#7a4988] uppercase mb-4">Informasi Pembeli</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 font-semibold focus:outline-none" readonly>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">No. HP</label>
                            <input type="text" value="{{ $user->no_hp ?? '-' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Alamat</label>
                        <textarea rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none" readonly>{{ $user->alamat ?? '-' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kartu Pilihan Jenis Tiket Dinamis --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-[#7a4988] uppercase mb-4">Pilihan Tiket</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($event->tiket as $index => $tkt)
                    <label class="relative border-2 rounded-2xl p-4 flex flex-col justify-between cursor-pointer transition select-none hover:bg-purple-50/30 ticket-card border-gray-200" id="card-{{ $tkt->id_tiket }}">
                        <input type="radio" name="id_tiket" value="{{ $tkt->id_tiket }}" data-harga="{{ $tkt->harga }}" data-nama="{{ $tkt->jenis_tiket }}" class="absolute top-4 right-4 text-[#7a4988] focus:ring-[#7a4988] ticket-radio" {{ $index == 0 ? 'checked' : '' }}>
                        
                        <div>
                            <span class="block font-black text-gray-800 text-base mb-1">{{ $tkt->jenis_tiket }}</span>
                            <span class="block text-[#7a4988] font-extrabold text-sm">Rp {{ number_format($tkt->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-4 pt-2 border-t border-dashed border-gray-100 text-[11px] text-gray-400 font-medium">
                            Sisa kuota: <span class="text-red-500 font-bold">{{ $tkt->kuota_tersedia }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Counter Jumlah Tiket --}}
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                    <span class="text-sm font-bold text-gray-700">Jumlah Tiket</span>
                    <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                        <button type="button" onclick="ubahJumlah(-1)" class="px-4 py-2 text-gray-500 font-bold hover:bg-gray-100 transition">-</button>
                        <input type="number" name="jumlah_tiket" id="jumlah_tiket" value="1" min="1" class="w-12 text-center bg-transparent border-none text-sm font-bold text-gray-800 focus:outline-none" readonly>
                        <button type="button" onclick="ubahJumlah(1)" class="px-4 py-2 text-gray-500 font-bold hover:bg-gray-100 transition">+</button>
                    </div>
                </div>
            </div>

        </div>

        {{-- SISI KANAN: METODE PEMBAYARAN & TOTAL RINGKASAN --}}
        <div class="space-y-6">
            
            {{-- Pilihan Metode Pembayaran --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-[#7a4988] uppercase mb-4">Pilih Metode Pembayaran</h3>
                <div class="space-y-3">
                    <label class="flex items-center justify-between p-3 border border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50 bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="metode_pembayaran" value="Transfer Bank" class="text-[#7a4988] focus:ring-[#7a4988]" checked>
                            <span class="text-xs font-bold text-gray-700">Transfer Bank</span>
                        </div>
                        <div class="flex gap-1">
                            <span class="text-[9px] font-black border px-1.5 py-0.5 rounded bg-white text-gray-400">BCA</span>
                            <span class="text-[9px] font-black border px-1.5 py-0.5 rounded bg-white text-gray-400">Mandiri</span>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3 border border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="metode_pembayaran" value="Virtual Account" class="text-[#7a4988] focus:ring-[#7a4988]">
                            <span class="text-xs font-bold text-gray-700">Virtual Account</span>
                        </div>
                        <div class="flex gap-1">
                            <span class="text-[9px] font-black border px-1.5 py-0.5 rounded bg-white text-gray-400">BNI</span>
                            <span class="text-[9px] font-black border px-1.5 py-0.5 rounded bg-white text-gray-400">BRI</span>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3 border border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="metode_pembayaran" value="E-Wallet" class="text-[#7a4988] focus:ring-[#7a4988]">
                            <span class="text-xs font-bold text-gray-700">E-Wallet</span>
                        </div>
                        <div class="flex gap-1">
                            <span class="text-[9px] font-black border px-1.5 py-0.5 rounded bg-white text-[#7a4988] font-bold">GoPay</span>
                            <span class="text-[9px] font-black border px-1.5 py-0.5 rounded bg-white text-red-500 font-bold">OVO</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Ringkasan Perhitungan Pembayaran --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-[#7a4988] uppercase mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-3 text-sm text-gray-600 font-medium pb-4 border-b border-gray-100">
                    <div class="flex justify-between">
                        <span id="lbl_nama_tiket">Tiket -</span>
                        <span id="lbl_subtotal_tiket">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Layanan</span>
                        <span>Rp 5.000</span>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-base font-black text-[#24112e]">Total</span>
                    <span class="text-lg font-black text-[#7a4988]" id="lbl_total_harga">Rp 5.000</span>
                </div>

                <div class="mt-6 space-y-2">
                    <button type="submit" class="w-full bg-[#7a4988] hover:bg-[#63376f] text-white py-3 rounded-xl font-bold text-sm tracking-wide shadow-md transition">
                        Bayar Sekarang
                    </button>
                    <a href="{{ route('pengunjung.dashboard') }}" class="block text-center w-full bg-white hover:bg-gray-50 text-gray-500 border border-gray-200 py-3 rounded-xl font-bold text-sm transition">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>

{{-- Perhitungan Real-Time Otomatis lewat JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const radios = document.querySelectorAll('.ticket-radio');
        const inputJumlah = document.getElementById('jumlah_tiket');
        
        function kalkulasiTotal() {
            let radioTerpilih = document.querySelector('.ticket-radio:checked');
            if(!radioTerpilih) return;

            let harga = parseInt(radioTerpilih.getAttribute('data-harga'));
            let nama = radioTerpilih.getAttribute('data-nama');
            let qty = parseInt(inputJumlah.value);
            
            let subtotalTiket = harga * qty;
            let biayaLayanan = 5000;
            let totalSemua = subtotalTiket + biayaLayanan;

            document.querySelectorAll('.ticket-card').forEach(card => {
                card.classList.remove('border-[#7a4988]', 'bg-purple-50/20');
                card.classList.add('border-gray-200');
            });

            let kartuAktif = document.getElementById('card-' + radioTerpilih.value);
            if(kartuAktif) {
                kartuAktif.classList.remove('border-gray-200');
                kartuAktif.classList.add('border-[#7a4988]', 'bg-purple-50/20');
            }

            document.getElementById('lbl_nama_tiket').innerText = `${nama} x${qty}`;
            document.getElementById('lbl_subtotal_tiket').innerText = 'Rp ' + subtotalTiket.toLocaleString('id-ID');
            document.getElementById('lbl_total_harga').innerText = 'Rp ' + totalSemua.toLocaleString('id-ID');
        }

        radios.forEach(radio => {
            radio.addEventListener('change', kalkulasiTotal);
        });

        kalkulasiTotal();

        window.ubahJumlah = function(nilai) {
            let currentVal = parseInt(inputJumlah.value);
            let newVal = currentVal + nilai;
            if(newVal >= 1) {
                inputJumlah.value = newVal;
                kalkulasiTotal();
            }
        }
    });
</script>

@endsection