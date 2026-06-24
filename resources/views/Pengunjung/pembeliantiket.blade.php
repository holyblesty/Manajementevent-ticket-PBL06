@extends('layouts.app') {{-- Sesuaikan dengan nama file master layout Anda --}}

@section('title', 'Pembelian Tiket - ' . $event->nama_event)

@section('content')
<div class="mb-4 text-sm text-gray-500">
    <a href="#" class="hover:text-purple-800">Beranda</a> &gt; 
    <a href="#" class="hover:text-purple-800">Acara</a> &gt; 
    <span class="text-gray-800 font-medium">Pembelian Tiket</span>
</div>

<h1 class="text-2xl font-bold text-purple-900 mb-6">Pembelian Tiket</h1>

<form action="{{ route('pengunjung.pembelian.store') }}" method="POST" id="form-beli-tiket">
    @csrf
    <input type="hidden" name="id_event" value="{{ $event->id_event }}">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- LEFT & CENTER COLUMN: Info Event, Pembeli, Pilihan Tiket --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Detail Event Card --}}
            <div class="card p-5 flex flex-col md:flex-row gap-5">
                <img src="{{ asset('storage/' . $event->foto) }}" alt="Banner Event" class="w-full md:w-48 h-48 object-cover rounded-xl">
                <div class="flex-1 space-y-3">
                    <h2 class="text-xl font-bold text-gray-900">{{ $event->nama_event }}</h2>
                    <p class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-purple-700"></i> {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }} • {{ $event->waktu }}
                    </p>
                    <p class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-purple-700"></i> {{ $event->lokasi }}
                    </p>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $event->deskripsi }}</p>
                </div>
            </div>

            {{-- Informasi Pembeli --}}
            <div class="card p-5 space-y-4">
                <h3 class="font-bold text-purple-900 text-base border-b pb-2">Informasi Pembeli</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" class="input-field bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">No. HP</label>
                        <input type="text" value="{{ $user->no_hp ?? '081234567890' }}" class="input-field bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Email</label>
                        <input type="text" value="{{ $user->email }}" class="input-field bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Alamat</label>
                        <textarea class="input-field bg-gray-50 resize-none h-20" readonly>{{ $user->alamat ?? 'Jl. Malaka No. 12, Bandung, Jawa Barat' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Pilihan Tiket --}}
            <div class="card p-5 space-y-4">
                <h3 class="font-bold text-purple-900 text-base border-b pb-2">Pilihan Tiket</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <label class="border-2 border-gray-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-purple-300 transition-all option-tiket">
                        <input type="radio" name="id_tiket" value="1" data-nama="Early Bird" data-harga="30000" class="mt-1 accent-purple-800" required>
                        <div>
                            <span class="font-bold text-gray-800 block text-sm">Early Bird</span>
                            <span class="text-purple-700 font-bold text-sm">Rp 30.000</span>
                            <span class="text-xs text-gray-400 block mt-1">Sisa 10</span>
                        </div>
                    </label>

                    <label class="border-2 border-gray-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-purple-300 transition-all option-tiket">
                        <input type="radio" name="id_tiket" value="2" data-nama="Normal" data-harga="50000" class="mt-1 accent-purple-800">
                        <div>
                            <span class="font-bold text-gray-800 block text-sm">Normal</span>
                            <span class="text-purple-700 font-bold text-sm">Rp 50.000</span>
                            <span class="text-xs text-gray-400 block mt-1">Sisa 32</span>
                        </div>
                    </label>

                    <label class="border-2 border-gray-200 rounded-xl p-4 flex items-start gap-3 cursor-pointer hover:border-purple-300 transition-all option-tiket col-span-1 md:col-span-2">
                        <input type="radio" name="id_tiket" value="3" data-nama="VIP" data-harga="150000" class="mt-1 accent-purple-800">
                        <div class="w-full">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 text-sm">VIP</span>
                                <span class="text-purple-700 font-bold text-sm">Rp 150.000</span>
                            </div>
                            <ul class="text-xs text-gray-500 mt-2 space-y-1 list-disc list-inside">
                                <li>Akses area khusus</li>
                                <li>Tempat duduk prioritas</li>
                                <li>Merchandise eksklusif</li>
                            </ul>
                        </div>
                    </label>
                </div>

                {{-- Jumlah Tiket --}}
                <div class="flex items-center justify-between pt-4 border-t">
                    <span class="font-semibold text-sm text-gray-700">Jumlah Tiket</span>
                    <div class="flex items-center border rounded-xl overflow-hidden bg-gray-50">
                        <button type="button" id="btn-minus" class="px-3 py-2 hover:bg-gray-200 text-gray-600 font-bold">-</button>
                        <input type="number" name="jumlah_tiket" id="jumlah-tiket" value="1" min="1" class="w-12 text-center bg-transparent border-none text-sm font-bold focus:outline-none" readonly>
                        <button type="button" id="btn-plus" class="px-3 py-2 hover:bg-gray-200 text-gray-600 font-bold">+</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Metode Pembayaran & Ringkasan --}}
        <div class="space-y-6">
            
            {{-- Metode Pembayaran --}}
            <div class="card p-5 space-y-4">
                <h3 class="font-bold text-purple-900 text-base border-b pb-2">Pilih Metode Pembayaran</h3>
                <div class="space-y-3">
                    <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="metode_pembayaran" value="Transfer Bank" class="accent-purple-800" required>
                            <span class="text-sm font-medium text-gray-700">Transfer Bank</span>
                        </div>
                        <div class="flex gap-1 text-[10px] font-bold text-gray-500">
                            <span class="border px-1.5 py-0.5 rounded bg-white">BCA</span>
                            <span class="border px-1.5 py-0.5 rounded bg-white">Mandiri</span>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="metode_pembayaran" value="Virtual Account" class="accent-purple-800">
                            <span class="text-sm font-medium text-gray-700">Virtual Account</span>
                        </div>
                        <div class="flex gap-1 text-[10px] font-bold text-gray-500">
                            <span class="border px-1.5 py-0.5 rounded bg-white">BNI</span>
                            <span class="border px-1.5 py-0.5 rounded bg-white">BRI</span>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3 border rounded-xl cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="metode_pembayaran" value="E-Wallet" class="accent-purple-800">
                            <span class="text-sm font-medium text-gray-700">E-Wallet</span>
                        </div>
                        <div class="flex gap-1 text-[10px] font-bold text-gray-500">
                            <span class="border px-1.5 py-0.5 rounded bg-white">GoPay</span>
                            <span class="border px-1.5 py-0.5 rounded bg-white">OVO</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="card p-5 space-y-4">
                <h3 class="font-bold text-purple-900 text-base border-b pb-2">Ringkasan Pesanan</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span id="label-ringkasan-tiket">Tiket x1</span>
                        <span id="val-ringkasan-tiket" class="font-semibold text-gray-800">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya layanan</span>
                        <span class="font-semibold text-gray-800">Rp 5.000</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between items-center">
                        <span class="font-bold text-gray-800 text-base">Total</span>
                        <span id="val-total-harga" class="font-bold text-purple-800 text-lg">Rp 5.000</span>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    <button type="submit" class="btn-primary text-sm shadow-md shadow-purple-200">Bayar Sekarang</button>
                    <a href="{{ route('home') }}" class="btn-outline text-sm text-center block w-full py-2 rounded-xl">Batal</a>
                </div>
            </div>

        </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Selector disesuaikan ke input[name="id_tiket"]
        const radioTiket = document.querySelectorAll('input[name="id_tiket"]');
        const inputJumlah = document.getElementById('jumlah-tiket');
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        
        const labelRingkasanTiket = document.getElementById('label-ringkasan-tiket');
        const valRingkasanTiket = document.getElementById('val-ringkasan-tiket');
        const valTotalHarga = document.getElementById('val-total-harga');
        
        let hargaSatuan = 0;
        const biayaLayanan = 5000;

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        function hitungTotal() {
            let jumlah = parseInt(inputJumlah.value);
            
            if (hargaSatuan === 0) {
                valRingkasanTiket.innerText = 'Rp 0';
                valTotalHarga.innerText = formatRupiah(biayaLayanan);
                return;
            }

            let subtotalTiket = hargaSatuan * jumlah;
            let total = subtotalTiket + biayaLayanan;

            // Mengambil nama tiket dari atribut data-nama (Early Bird/Normal/VIP)
            let selectedRadio = document.querySelector('input[name="id_tiket"]:checked');
            let namaTiket = selectedRadio ? selectedRadio.getAttribute('data-nama') : '';

            labelRingkasanTiket.innerText = `Tiket (${namaTiket}) x${jumlah}`;
            valRingkasanTiket.innerText = formatRupiah(subtotalTiket);
            valTotalHarga.innerText = formatRupiah(total);
        }

        // Event listener saat ganti jenis tiket
        radioTiket.forEach(radio => {
            radio.addEventListener('change', function() {
                // Beri efek highlight border pada opsi terpilih
                document.querySelectorAll('.option-tiket').forEach(el => el.classList.remove('border-purple-600', 'bg-purple-50/50'));
                this.closest('.option-tiket').classList.add('border-purple-600', 'bg-purple-50/50');
                
                hargaSatuan = parseInt(this.getAttribute('data-harga'));
                hitungTotal();
            });
        });

        // Event counter tambah/kurang jumlah tiket
        btnPlus.addEventListener('click', function() {
            inputJumlah.value = parseInt(inputJumlah.value) + 1;
            hitungTotal();
        });

        btnMinus.addEventListener('click', function() {
            if (parseInt(inputJumlah.value) > 1) {
                inputJumlah.value = parseInt(inputJumlah.value) - 1;
                hitungTotal();
            }
        });
    });
</script>
@endpush