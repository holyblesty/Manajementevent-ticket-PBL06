@extends('layouts.pengunjung')

@section('title', 'Edit Pesanan - ' . $event->judul)

@push('styles')
<style>
    .tiket-card { @apply border-2 border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-200; }
    .tiket-card:hover { @apply border-purple-400 bg-purple-50; }
    .tiket-card.selected { @apply border-purple-700 bg-purple-50 ring-2 ring-purple-300; }
    .tiket-card.sold-out { @apply opacity-50 cursor-not-allowed; }
    .metode-card { @apply border border-gray-200 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:border-purple-400; }
    .metode-card.selected { @apply border-purple-700 bg-purple-50; }
    .bank-btn { @apply border border-gray-300 rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 hover:border-purple-500 hover:text-purple-700 transition-all cursor-pointer; }
    .bank-btn.selected { @apply border-purple-700 bg-purple-100 text-purple-800; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('pengunjung.beranda') }}" class="hover:text-purple-700">Beranda</a>
    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
    <a href="{{ route('pengunjung.riwayat') }}" class="hover:text-purple-700">Riwayat Pendaftaran</a>
    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
    <span class="text-purple-700 font-medium">Edit Pesanan</span>
</nav>

<div class="flex items-center gap-3 mb-6">
    <h1 class="text-2xl font-bold text-purple-800">Edit Pesanan</h1>
    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
        #{{ $pesanan->kode_pesanan }}
    </span>
</div>

{{-- Info: hanya pending yang bisa diedit --}}
<div class="mb-5 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
    <i class="fa-solid fa-circle-info text-blue-500 mt-0.5"></i>
    <p class="text-sm text-blue-700">
        Anda dapat mengubah <strong>jenis tiket</strong>, <strong>jumlah tiket</strong>, dan <strong>metode pembayaran</strong>.
        Perubahan hanya bisa dilakukan selama pesanan masih berstatus <strong>Menunggu Konfirmasi</strong>.
    </p>
</div>

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

<form action="{{ route('pengunjung.pesanan.update', $pesanan->id_pesanan) }}" method="POST" id="formEdit">
@csrf
@method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-5">

        {{-- INFO EVENT --}}
        <div class="card p-5">
            <div class="flex gap-4">
                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-purple-900">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-calendar text-purple-300 text-2xl"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="font-bold text-gray-900 text-base">{{ $event->judul }}</h2>
                    <div class="mt-2 space-y-1.5">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fa-regular fa-calendar text-purple-600 w-4"></i>
                            {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-purple-600 w-4"></i>
                            {{ $event->lokasi }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFORMASI PEMBELI (readonly) --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Informasi Pembeli</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" value="{{ $user->name }}" readonly class="input-field bg-gray-50 cursor-not-allowed">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. HP</label>
                        <input type="text" value="{{ $user->no_hp ?? '-' }}" readonly class="input-field bg-gray-50 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" value="{{ $user->email }}" readonly class="input-field bg-gray-50 cursor-not-allowed">
                    </div>
                </div>
            </div>
        </div>

        {{-- PILIHAN TIKET (bisa diubah) --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Ubah Jenis Tiket</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach($event->tikets as $tiket)
                    @php
                        $sisa      = $tiket->kuota - $tiket->terjual;
                        $isSoldOut = $sisa <= 0 && $tiket->id_tiket != $pesanan->id_tiket;
                        $isActive  = $tiket->id_tiket == $pesanan->id_tiket;
                    @endphp

                    <label class="tiket-card {{ $isSoldOut ? 'sold-out' : '' }} {{ $isActive ? 'selected' : '' }}">
                        <input type="radio" name="id_tiket" value="{{ $tiket->id_tiket }}"
                            class="hidden"
                            {{ $isActive ? 'checked' : '' }}
                            {{ $isSoldOut ? 'disabled' : '' }}
                            onchange="piliTiket(this, {{ $tiket->harga }}, '{{ $tiket->jenis_tiket }}')">

                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-4 h-4 rounded-full border-2 {{ $isActive ? 'border-purple-700' : 'border-gray-400' }} flex items-center justify-center tiket-radio">
                                @if($isActive)
                                    <div class="w-2 h-2 rounded-full bg-purple-700"></div>
                                @endif
                            </div>
                            <span class="font-bold text-gray-800 text-sm">{{ $tiket->jenis_tiket }}</span>
                        </div>

                        <p class="font-bold text-purple-700 text-lg">
                            Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Sisa {{ $sisa }} tiket</p>
                    </label>
                @endforeach
            </div>

            {{-- Jumlah Tiket --}}
            <div class="mt-5 pt-5 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-semibold text-gray-700">Jumlah Tiket</label>
                    <div class="flex items-center gap-0">
                        <button type="button" onclick="ubahJumlah(-1)"
                            class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-l-xl bg-white hover:bg-gray-50 font-bold transition-all">
                            <i class="fa-solid fa-minus text-xs"></i>
                        </button>
                        <input type="number" id="jumlahTiket" name="jumlah_tiket"
                            value="{{ $pesanan->jumlah_tiket }}" min="1" max="10" readonly
                            class="w-14 h-9 text-center border-t border-b border-gray-300 text-sm font-bold text-gray-800 bg-white focus:outline-none">
                        <button type="button" onclick="ubahJumlah(1)"
                            class="w-9 h-9 flex items-center justify-center border border-gray-300 rounded-r-xl bg-white hover:bg-gray-50 font-bold transition-all">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN --}}
    <div class="space-y-5">

        {{-- METODE PEMBAYARAN --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Metode Pembayaran</h3>
            <div class="space-y-3">
                @php
                    $metodeSaat = $pesanan->metode_pembayaran;
                    $bankSaat   = $pesanan->bank_pilihan;
                @endphp

                {{-- Transfer Bank --}}
                <div class="metode-card {{ $metodeSaat === 'Transfer Bank' ? 'selected' : '' }}"
                    id="metode-transfer" onclick="pilihMetode('Transfer Bank', this)">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full border-2 {{ $metodeSaat === 'Transfer Bank' ? 'border-purple-700' : 'border-gray-400' }} flex items-center justify-center" id="radio-transfer">
                            @if($metodeSaat === 'Transfer Bank')
                                <div class="w-2 h-2 rounded-full bg-purple-700"></div>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Transfer Bank</span>
                    </div>
                    <div class="flex gap-2 ml-7 {{ $metodeSaat !== 'Transfer Bank' ? 'hidden' : '' }}" id="bankGroup-transfer">
                        @foreach(['BCA','Mandiri'] as $bank)
                            <button type="button" onclick="pilihBank('{{ $bank }}', event)"
                                class="bank-btn {{ $bankSaat === $bank && $metodeSaat === 'Transfer Bank' ? 'selected' : '' }}"
                                id="bank-{{ $bank }}">{{ $bank }}</button>
                        @endforeach
                    </div>
                </div>

                {{-- Virtual Account --}}
                <div class="metode-card {{ $metodeSaat === 'Virtual Account' ? 'selected' : '' }}"
                    id="metode-va" onclick="pilihMetode('Virtual Account', this)">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full border-2 {{ $metodeSaat === 'Virtual Account' ? 'border-purple-700' : 'border-gray-400' }} flex items-center justify-center" id="radio-va">
                            @if($metodeSaat === 'Virtual Account')
                                <div class="w-2 h-2 rounded-full bg-purple-700"></div>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Virtual Account</span>
                    </div>
                    <div class="flex gap-2 ml-7 {{ $metodeSaat !== 'Virtual Account' ? 'hidden' : '' }}" id="bankGroup-va">
                        @foreach(['BNI','BRI'] as $bank)
                            <button type="button" onclick="pilihBank('{{ $bank }}', event)"
                                class="bank-btn {{ $bankSaat === $bank && $metodeSaat === 'Virtual Account' ? 'selected' : '' }}"
                                id="bank-{{ $bank }}">{{ $bank }}</button>
                        @endforeach
                    </div>
                </div>

                {{-- E-Wallet --}}
                <div class="metode-card {{ $metodeSaat === 'E-Wallet' ? 'selected' : '' }}"
                    id="metode-ewallet" onclick="pilihMetode('E-Wallet', this)">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full border-2 {{ $metodeSaat === 'E-Wallet' ? 'border-purple-700' : 'border-gray-400' }} flex items-center justify-center" id="radio-ewallet">
                            @if($metodeSaat === 'E-Wallet')
                                <div class="w-2 h-2 rounded-full bg-purple-700"></div>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-gray-700">E-Wallet</span>
                    </div>
                    <div class="flex gap-2 ml-7 {{ $metodeSaat !== 'E-Wallet' ? 'hidden' : '' }}" id="bankGroup-ewallet">
                        @foreach(['GoPay','OVO'] as $bank)
                            <button type="button" onclick="pilihBank('{{ $bank }}', event)"
                                class="bank-btn {{ $bankSaat === $bank && $metodeSaat === 'E-Wallet' ? 'selected' : '' }}"
                                id="bank-{{ $bank }}">{{ $bank }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <input type="hidden" name="metode_pembayaran" id="inputMetode" value="{{ $metodeSaat }}">
            <input type="hidden" name="bank_pilihan" id="inputBank" value="{{ $bankSaat }}">
        </div>

        {{-- RINGKASAN --}}
        <div class="card p-5">
            <h3 class="font-bold text-purple-700 text-base mb-4">Ringkasan Pesanan</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600" id="labelTiketRingkasan">
                        Tiket {{ $pesanan->tiket->jenis_tiket }} x{{ $pesanan->jumlah_tiket }}
                    </span>
                    <span class="font-medium text-gray-800" id="hargaTiketRingkasan">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Biaya layanan</span>
                    <span class="font-medium text-gray-800">Rp 5.000</span>
                </div>
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-purple-700 text-lg" id="totalRingkasan">
                            Rp {{ number_format($pesanan->grand_total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('pengunjung.riwayat') }}" class="btn-outline">
                    Kembali
                </a>
            </div>
        </div>

        {{-- TOMBOL BATALKAN --}}
        <div class="card p-5 border-red-200">
            <h3 class="font-semibold text-red-600 text-sm mb-2">Zona Berbahaya</h3>
            <p class="text-xs text-gray-500 mb-3">Membatalkan pesanan akan mengembalikan stok tiket dan tidak dapat dibatalkan.</p>
            <form action="{{ route('pengunjung.pesanan.cancel', $pesanan->id_pesanan) }}" method="POST"
                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="w-full border-2 border-red-400 text-red-600 hover:bg-red-50 font-semibold py-2.5 rounded-xl text-sm transition-all">
                    <i class="fa-solid fa-xmark mr-2"></i>Batalkan Pesanan
                </button>
            </form>
        </div>

    </div>
</div>
</form>

@endsection

@push('scripts')
<script>
    let hargaPerTiket = {{ $pesanan->tiket->harga }};
    let jenisTiket    = '{{ $pesanan->tiket->jenis_tiket }}';
    let jumlah        = {{ $pesanan->jumlah_tiket }};

    function piliTiket(input, harga, jenis) {
        hargaPerTiket = harga;
        jenisTiket    = jenis;

        document.querySelectorAll('.tiket-card:not(.sold-out)').forEach(el => {
            el.classList.remove('selected');
            const dot = el.querySelector('.tiket-radio');
            if (dot) { dot.className = 'w-4 h-4 rounded-full border-2 border-gray-400 flex items-center justify-center tiket-radio'; dot.innerHTML = ''; }
        });

        input.closest('.tiket-card').classList.add('selected');
        const radioEl = input.closest('.tiket-card').querySelector('.tiket-radio');
        if (radioEl) {
            radioEl.className = 'w-4 h-4 rounded-full border-2 border-purple-700 flex items-center justify-center tiket-radio';
            radioEl.innerHTML = '<div class="w-2 h-2 rounded-full bg-purple-700"></div>';
        }
        updateRingkasan();
    }

    function ubahJumlah(delta) {
        const input = document.getElementById('jumlahTiket');
        jumlah = Math.min(10, Math.max(1, parseInt(input.value) + delta));
        input.value = jumlah;
        updateRingkasan();
    }

    function updateRingkasan() {
        const subtotal = hargaPerTiket * jumlah;
        const total    = subtotal + 5000;
        document.getElementById('labelTiketRingkasan').textContent = 'Tiket ' + jenisTiket + ' x' + jumlah;
        document.getElementById('hargaTiketRingkasan').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('totalRingkasan').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    const metodeMap = {
        'Transfer Bank':  { id: 'transfer', banks: ['BCA','Mandiri'] },
        'Virtual Account':{ id: 'va',       banks: ['BNI','BRI']    },
        'E-Wallet':       { id: 'ewallet',  banks: ['GoPay','OVO']  },
    };

    function pilihMetode(metode, el) {
        Object.values(metodeMap).forEach(m => {
            const card   = document.getElementById('metode-' + m.id);
            const radio  = document.getElementById('radio-' + m.id);
            const grp    = document.getElementById('bankGroup-' + m.id);
            if (card)  card.classList.remove('selected');
            if (radio) { radio.className = 'w-4 h-4 rounded-full border-2 border-gray-400 flex items-center justify-center'; radio.innerHTML = ''; }
            if (grp)   grp.classList.add('hidden');
        });

        const aktif = metodeMap[metode];
        const card  = document.getElementById('metode-' + aktif.id);
        const radio = document.getElementById('radio-' + aktif.id);
        const grp   = document.getElementById('bankGroup-' + aktif.id);

        card.classList.add('selected');
        radio.className = 'w-4 h-4 rounded-full border-2 border-purple-700 flex items-center justify-center';
        radio.innerHTML = '<div class="w-2 h-2 rounded-full bg-purple-700"></div>';
        if (grp) grp.classList.remove('hidden');

        document.getElementById('inputMetode').value = metode;
        const defaultBank = aktif.banks[0];
        pilihBank(defaultBank, { stopPropagation: () => {} });
    }

    function pilihBank(bank, e) {
        e.stopPropagation();
        const metode = document.getElementById('inputMetode').value;
        const aktif  = metodeMap[metode];
        aktif.banks.forEach(b => {
            const btn = document.getElementById('bank-' + b);
            if (btn) btn.classList.remove('selected');
        });
        const btn = document.getElementById('bank-' + bank);
        if (btn) btn.classList.add('selected');
        document.getElementById('inputBank').value = bank;
    }
</script>
@endpush