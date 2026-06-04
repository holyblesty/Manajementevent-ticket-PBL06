@extends('layouts.pengunjung')

@section('title', 'Pembelian Tiket - ' . $event->judul)

@push('styles')
<style>
    .tiket-card {
        @apply border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-200;
    }
    .tiket-card:hover {
        @apply border-purple-400 bg-purple-50;
    }
    .tiket-card.selected {
        @apply border-purple-700 bg-purple-50 ring-2 ring-purple-300;
    }
    .tiket-card.sold-out {
        @apply opacity-50 cursor-not-allowed border-gray-200 bg-gray-50;
    }
    .metode-card {
        @apply border border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:border-purple-400;
    }
    .metode-card.selected {
        @apply border-purple-700 bg-purple-50;
    }
    .bank-btn {
        @apply border border-gray-300 rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 hover:border-purple-500 hover:text-purple-700 transition-all cursor-pointer;
    }
    .bank-btn.selected {
        @apply border-purple-700 bg-purple-100 text-purple-800;
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('pengunjung.beranda') }}" class="hover:text-purple-700 transition-colors">Beranda</a>
    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
    <a href="{{ route('pengunjung.acara') }}" class="hover:text-purple-700 transition-colors">Acara</a>
    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
    <span class="text-purple-700 font-medium">Pembelian Tiket</span>
</nav>

<h1 class="text-2xl font-bold text-purple-800 mb-6">Pembelian Tiket</h1>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center gap-2 mb-2">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            <p class="font-semibold text-red-700 text-sm">Mohon perbaiki kesalahan berikut:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1 ml-4">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengunjung.tiket.store', $event->id_event) }}" method="POST" id="formPembelian">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KOLOM KIRI: Info Event + Form Pembeli + Pilihan Tiket --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- INFO EVENT --}}
        <div class="card p-5">
            <div class="flex gap-4">
                {{-- Poster --}}
                <div class="w-28 h-28 rounded-xl overflow-hidden flex-shrink-0 bg-purple-900">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->judul }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-calendar-star text-purple-300 text-3xl"></i>
                        </div>
                    @endif
                </div>
                {{-- Detail --}}
                <div class="flex-1">
                    <h2 class="font-bold text-gray-900 text-lg leading-tight">{{ $event->judul }}</h2>
                    <div class="mt-2 space-y-1.5">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fa-regular fa-calendar text-purple-600 w-4 text-center"></i>
                            <span>
                                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                                &bull;
                                {{ substr($event->jam_mulai, 0, 5) }} - {{ substr($event->jam_selesai, 0, 5) }} WIB
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fa-solid fa-location-dot text-purple-600 w-4 text-center"></i>
                            <span>{{ $event->lokasi }}</span>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500 leading-relaxed line-clamp-2">{{ $event->deskripsi }}</p>
                </div>
            </div>
        </div>

        {{-- INFORMASI PEMBELI --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Informasi Pembeli</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" value="{{ $user->name }}" readonly
                        class="input-field bg-gray-50 text-gray-700 cursor-not-allowed">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. HP</label>
                        <input type="text" value="{{ $user->no_hp ?? '-' }}" readonly
                            class="input-field bg-gray-50 text-gray-700 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" value="{{ $user->email }}" readonly
                            class="input-field bg-gray-50 text-gray-700 cursor-not-allowed">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <textarea rows="2" readonly
                        class="input-field bg-gray-50 text-gray-700 cursor-not-allowed resize-none">{{ $user->alamat ?? '-' }}</textarea>
                </div>

                <p class="text-xs text-gray-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-purple-400"></i>
                    Data diambil dari profil Anda.
                    <a href="{{ route('pengunjung.profil') }}" class="text-purple-600 hover:underline font-medium">Edit profil</a>
                </p>
            </div>
        </div>

        {{-- PILIHAN TIKET --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Pilihan Tiket</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3" id="tiketContainer">
                @foreach($event->tikets as $tiket)
                    @php
                        $sisa       = $tiket->kuota - $tiket->terjual;
                        $isSoldOut  = $sisa <= 0;
                        $isDefault  = isset($defaultTiket) && $tiket->id_tiket == $defaultTiket->id_tiket;
                    @endphp

                    <label class="tiket-card {{ $isSoldOut ? 'sold-out' : '' }} {{ $isDefault && !$isSoldOut ? 'selected' : '' }}"
                        id="label-tiket-{{ $tiket->id_tiket }}">

                        <input type="radio" name="id_tiket" value="{{ $tiket->id_tiket }}"
                            class="hidden"
                            {{ $isDefault && !$isSoldOut ? 'checked' : '' }}
                            {{ $isSoldOut ? 'disabled' : '' }}
                            onchange="piliTiket(this, {{ $tiket->harga }}, '{{ $tiket->jenis_tiket }}')">

                        {{-- Radio indicator --}}
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded-full border-2 border-gray-400 flex items-center justify-center tiket-radio-{{ $tiket->id_tiket }}">
                                @if($isDefault && !$isSoldOut)
                                    <div class="w-2 h-2 rounded-full bg-purple-700"></div>
                                @endif
                            </div>
                            <span class="font-bold text-gray-800 text-sm">{{ $tiket->jenis_tiket }}</span>
                            @if($isSoldOut)
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-medium ml-auto">Habis</span>
                            @endif
                        </div>

                        <p class="font-bold text-purple-700 text-lg">
                            Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Sisa {{ $sisa }} tiket
                        </p>

                        {{-- VIP benefits --}}
                        @if($tiket->jenis_tiket === 'VIP')
                            <div class="mt-2 space-y-1">
                                <p class="text-xs text-gray-600 flex items-center gap-1">
                                    <i class="fa-solid fa-check text-purple-600 text-xs"></i> Akses area khusus
                                </p>
                                <p class="text-xs text-gray-600 flex items-center gap-1">
                                    <i class="fa-solid fa-check text-purple-600 text-xs"></i> Tempat duduk prioritas
                                </p>
                                <p class="text-xs text-gray-600 flex items-center gap-1">
                                    <i class="fa-solid fa-check text-purple-600 text-xs"></i> Merchandise eksklusif
                                </p>
                            </div>
                        @endif
                    </label>
                @endforeach
            </div>

            {{-- Jumlah Tiket --}}
            <div class="mt-5 pt-5 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-semibold text-gray-700">Jumlah Tiket</label>
                    <div class="flex items-center gap-0">
                        <button type="button" onclick="ubahJumlah(-1)"
                            class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-l-xl bg-white hover:bg-gray-50 text-gray-700 font-bold transition-all">
                            <i class="fa-solid fa-minus text-xs"></i>
                        </button>
                        <input type="number" id="jumlahTiket" name="jumlah_tiket" value="1" min="1" max="10" readonly
                            class="w-14 h-9 text-center border-t border-b border-gray-300 text-sm font-bold text-gray-800 bg-white focus:outline-none">
                        <button type="button" onclick="ubahJumlah(1)"
                            class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-r-xl bg-white hover:bg-gray-50 text-gray-700 font-bold transition-all">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN: Metode Pembayaran + Ringkasan --}}
    <div class="space-y-5">

        {{-- PILIH METODE PEMBAYARAN --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Pilih Metode Pembayaran</h3>

            <div class="space-y-3">

                {{-- Transfer Bank --}}
                <div class="metode-card selected" id="metode-transfer" onclick="pilihMetode('Transfer Bank', this)">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full border-2 border-purple-700 flex items-center justify-center" id="radio-transfer">
                            <div class="w-2 h-2 rounded-full bg-purple-700"></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Transfer Bank</span>
                    </div>
                    <div class="flex gap-2 ml-7">
                        <button type="button" onclick="pilihBank('BCA', event)"
                            class="bank-btn selected" id="bank-BCA">BCA</button>
                        <button type="button" onclick="pilihBank('Mandiri', event)"
                            class="bank-btn" id="bank-Mandiri">Mandiri</button>
                    </div>
                </div>

                {{-- Virtual Account --}}
                <div class="metode-card" id="metode-va" onclick="pilihMetode('Virtual Account', this)">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full border-2 border-gray-400 flex items-center justify-center" id="radio-va">
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Virtual Account</span>
                    </div>
                    <div class="flex gap-2 ml-7 hidden" id="bankGroup-va">
                        <button type="button" onclick="pilihBank('BNI', event)"
                            class="bank-btn" id="bank-BNI">BNI</button>
                        <button type="button" onclick="pilihBank('BRI', event)"
                            class="bank-btn" id="bank-BRI">BRI</button>
                    </div>
                </div>

                {{-- E-Wallet --}}
                <div class="metode-card" id="metode-ewallet" onclick="pilihMetode('E-Wallet', this)">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full border-2 border-gray-400 flex items-center justify-center" id="radio-ewallet">
                        </div>
                        <span class="text-sm font-semibold text-gray-700">E-Wallet</span>
                    </div>
                    <div class="flex gap-2 ml-7 hidden" id="bankGroup-ewallet">
                        <button type="button" onclick="pilihBank('GoPay', event)"
                            class="bank-btn" id="bank-GoPay">GoPay</button>
                        <button type="button" onclick="pilihBank('OVO', event)"
                            class="bank-btn" id="bank-OVO">OVO</button>
                    </div>
                </div>

            </div>

            {{-- Hidden inputs --}}
            <input type="hidden" name="metode_pembayaran" id="inputMetode" value="Transfer Bank">
            <input type="hidden" name="bank_pilihan"      id="inputBank"   value="BCA">
        </div>

        {{-- RINGKASAN PESANAN --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Ringkasan Pesanan</h3>

            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600" id="labelTiketRingkasan">
                        Tiket {{ $defaultTiket ? $defaultTiket->jenis_tiket : '' }} x1
                    </span>
                    <span class="font-medium text-gray-800" id="hargaTiketRingkasan">
                        Rp {{ $defaultTiket ? number_format($defaultTiket->harga, 0, ',', '.') : '0' }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Biaya layanan</span>
                    <span class="font-medium text-gray-800">Rp 5.000</span>
                </div>

                <div class="border-t border-gray-200 pt-3 mt-2">
                    <div class="flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-purple-700 text-lg" id="totalRingkasan">
                            Rp {{ $defaultTiket ? number_format($defaultTiket->harga + 5000, 0, ',', '.') : '5.000' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-5 space-y-3">
                <button type="submit" class="btn-primary text-center py-3 rounded-xl font-bold">
                    Bayar Sekarang
                </button>
                <a href="{{ route('pengunjung.acara.detail', $event->id_event) }}" class="btn-outline text-center py-3 rounded-xl font-bold">
                    Batal
                </a>
            </div>
        </div>

    </div>
</div>
</form>

@endsection

@push('scripts')
<script>
    // ============================
    // DATA TIKET
    // ============================
    const tiketData = {
        @foreach($event->tikets as $tiket)
        {{ $tiket->id_tiket }}: {
            id: {{ $tiket->id_tiket }},
            jenis: '{{ $tiket->jenis_tiket }}',
            harga: {{ $tiket->harga }},
            sisa: {{ $tiket->kuota - $tiket->terjual }},
        },
        @endforeach
    };

    let hargaPerTiket = {{ $defaultTiket ? $defaultTiket->harga : 0 }};
    let jenisTiket    = '{{ $defaultTiket ? $defaultTiket->jenis_tiket : '' }}';
    let jumlah        = 1;

    // ============================
    // PILIH TIKET
    // ============================
    function piliTiket(input, harga, jenis) {
        hargaPerTiket = harga;
        jenisTiket    = jenis;

        // Reset semua label
        document.querySelectorAll('.tiket-card:not(.sold-out)').forEach(el => {
            el.classList.remove('selected');
            const dot = el.querySelector('[class*="tiket-radio"]');
            if (dot) dot.innerHTML = '';
        });

        // Aktifkan yang dipilih
        input.closest('.tiket-card').classList.add('selected');
        const radioEl = input.closest('.tiket-card').querySelector('[class*="tiket-radio"]');
        if (radioEl) radioEl.innerHTML = '<div class="w-2 h-2 rounded-full bg-purple-700"></div>';

        updateRingkasan();
    }

    // ============================
    // JUMLAH TIKET
    // ============================
    function ubahJumlah(delta) {
        const input = document.getElementById('jumlahTiket');
        jumlah = Math.min(10, Math.max(1, parseInt(input.value) + delta));
        input.value = jumlah;
        updateRingkasan();
    }

    document.getElementById('jumlahTiket').addEventListener('change', function() {
        jumlah = parseInt(this.value) || 1;
        updateRingkasan();
    });

    // ============================
    // UPDATE RINGKASAN
    // ============================
    function updateRingkasan() {
        const total    = hargaPerTiket * jumlah + 5000;
        const subtotal = hargaPerTiket * jumlah;

        document.getElementById('labelTiketRingkasan').textContent =
            'Tiket ' + jenisTiket + ' x' + jumlah;
        document.getElementById('hargaTiketRingkasan').textContent =
            'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('totalRingkasan').textContent =
            'Rp ' + total.toLocaleString('id-ID');
    }

    // ============================
    // PILIH METODE PEMBAYARAN
    // ============================
    const metodeMap = {
        'Transfer Bank': { id: 'transfer', banks: ['BCA','Mandiri'] },
        'Virtual Account':{ id: 'va',       banks: ['BNI','BRI']    },
        'E-Wallet':      { id: 'ewallet',   banks: ['GoPay','OVO']  },
    };

    let selectedBank = 'BCA';

    function pilihMetode(metode, el) {
        // Reset semua kartu
        Object.values(metodeMap).forEach(m => {
            const card = document.getElementById('metode-' + m.id);
            const radio = document.getElementById('radio-' + m.id);
            const bankGroup = document.getElementById('bankGroup-' + m.id);
            if (card)  card.classList.remove('selected');
            if (radio) radio.innerHTML = '';
            if (bankGroup) bankGroup.classList.add('hidden');
        });

        // Aktifkan metode dipilih
        const aktif = metodeMap[metode];
        const card  = document.getElementById('metode-' + aktif.id);
        const radio = document.getElementById('radio-' + aktif.id);
        const bankGroup = document.getElementById('bankGroup-' + aktif.id);

        card.classList.add('selected');
        radio.innerHTML = '<div class="w-2 h-2 rounded-full bg-purple-700"></div>';
        if (bankGroup) bankGroup.classList.remove('hidden');

        // Set input tersembunyi
        document.getElementById('inputMetode').value = metode;

        // Pilih bank default
        selectedBank = aktif.banks[0];
        document.getElementById('inputBank').value = selectedBank;
        aktif.banks.forEach(b => {
            const btn = document.getElementById('bank-' + b);
            if (btn) btn.classList.toggle('selected', b === selectedBank);
        });
    }

    function pilihBank(bank, e) {
        e.stopPropagation(); // jangan trigger pilihMetode

        const metode = document.getElementById('inputMetode').value;
        const aktif  = metodeMap[metode];

        aktif.banks.forEach(b => {
            const btn = document.getElementById('bank-' + b);
            if (btn) btn.classList.remove('selected');
        });

        const btn = document.getElementById('bank-' + bank);
        if (btn) btn.classList.add('selected');

        selectedBank = bank;
        document.getElementById('inputBank').value = bank;
    }

    // Init: pastikan BCA selected di awal
    document.getElementById('bank-BCA').classList.add('selected');
</script>
@endpush