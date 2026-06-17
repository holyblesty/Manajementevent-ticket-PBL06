<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tiket - {{ $event->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .no-underline { text-decoration: none !important; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
    </style>
</head>
<body style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="flex flex-col items-center py-10 font-sans antialiased text-gray-900">

    <div class="bg-white w-full max-w-[850px] rounded-3xl shadow-2xl overflow-hidden mb-10 mx-4 border border-gray-100">
        
        <div class="bg-[#24112e] p-8 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-white">Kelola Tiket & Kapasitas</h1>
            <p class="text-xs text-[#be93d4] font-bold mt-1 uppercase tracking-widest">{{ $event->judul }}</p>
        </div>

        @if ($errors->any())
            <div class="mx-8 mt-6 p-4 bg-red-50 border-2 border-red-200 rounded-2xl text-xs font-bold text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formTiket" action="{{ route('admin.acara.tiket.update', $event->id_event) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8 p-6 bg-purple-50 border-2 border-dashed border-purple-200 rounded-2xl flex items-center justify-between shadow-inner">
                <div class="flex items-center gap-4">
                    <div class="bg-[#7a4988] p-3 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-[#7a4988] font-black text-xs uppercase tracking-widest">Total Kapasitas Terhitung</h3>
                        <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Akumulasi otomatis dari kuota tiap tier</p>
                    </div>
                </div>
                <div class="text-4xl font-black text-[#24112e]">
                    <span id="display_total">{{ $event->kapasitas ?? 0 }}</span> <span class="text-xs text-gray-400 font-bold uppercase">Org</span>
                </div>
                <input type="hidden" name="kapasitas" id="input_total" value="{{ $event->kapasitas ?? 0 }}">
            </div>

            <div class="space-y-6">
                <div class="flex items-center space-x-4 mb-4">
                    <span class="text-[10px] font-black text-[#7a4988] uppercase tracking-[0.3em] whitespace-nowrap">Rincian Kuota & Harga</span>
                    <div class="flex-grow border-t-2 border-gray-100"></div>
                </div>

                @foreach(['early_bird' => 'Early Bird', 'normal' => 'Normal', 'vip' => 'VIP'] as $key => $label)
                @php
                    $hargaLama = $event->tiket->where('jenis_tiket', $label)->first()->harga_tiket ?? 0;
                    $kuotaLama = $event->tiket->where('jenis_tiket', $label)->first()->kuota_tiket ?? 0;
                @endphp
                <div class="tier-card bg-white p-5 rounded-2xl border-2 border-gray-100 grid grid-cols-1 md:grid-cols-3 gap-4 items-end hover:border-[#be93d4] transition-all shadow-sm">
                    <div>
                        <label class="block text-[9px] font-black uppercase text-[#7a4988] mb-2 tracking-widest">Tier Tiket</label>
                        <input type="text" value="{{ $label }}" readonly class="w-full p-3 border-2 border-gray-100 rounded-xl text-xs font-black text-gray-400 uppercase bg-gray-50 cursor-not-allowed outline-none">
                        <input type="hidden" name="tiket[{{$key}}][nama]" value="{{ $label }}" class="tier-name">
                    </div>

                    <div>
                        <label class="block text-[9px] font-black uppercase text-gray-400 mb-2 tracking-widest">Harga Per Tiket (Rp)</label>
                        <input type="number" 
                               name="tiket[{{$key}}][harga]" 
                               value="{{ $hargaLama }}" 
                               min="0" 
                               class="harga-input w-full p-3 border-2 border-gray-100 rounded-xl text-xs font-black text-gray-800 outline-none focus:border-[#7a4988] transition-all"
                               oninput="checkKuotaConstraint(this)">
                        <small class="error-msg text-[9px] text-red-500 font-bold uppercase mt-1 hidden">Kuota masih 0, harga tidak boleh diisi!</small>
                    </div>

                    <div>
                        <label class="block text-[9px] font-black uppercase text-gray-400 mb-2 tracking-widest">Kuota</label>
                        <input type="number" 
                               name="tiket[{{$key}}][kuota]" 
                               value="{{ $kuotaLama }}" 
                               min="0" 
                               class="kuota-input w-full p-3 border-2 border-[#7a4988] bg-white rounded-xl text-sm font-black text-center text-[#7a4988] outline-none focus:ring-4 focus:ring-purple-100 transition-all" 
                               oninput="validateInput(this); checkKuotaConstraint(this); updateTotal()">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-end gap-3 pt-6 border-t-2 border-gray-50">
                <a href="{{ route('admin.dashboard') }}" class="px-8 py-3 bg-white text-gray-400 rounded-xl font-black text-[10px] uppercase tracking-widest border-2 border-gray-100 hover:bg-gray-50 transition no-underline">Batal</a>
                <button type="button" onclick="handleFormSubmit(event)" class="px-10 py-3 bg-[#24112e] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition shadow-lg hover:-translate-y-1 border-none cursor-pointer">Simpan Pengaturan</button>
            </div>
        </form>
    </div>

    <script>
        function validateInput(input) {
            let val = input.value;
            if (val.length > 1 && val.startsWith('0')) { input.value = parseInt(val) || 0; }
        }

        function checkKuotaConstraint(element) {
            const card = element.closest('.tier-card');
            const kuotaInput = card.querySelector('.kuota-input');
            const hargaInput = card.querySelector('.harga-input');
            const errorMsg = card.querySelector('.error-msg');

            const kuotaVal = parseInt(kuotaInput.value) || 0;
            const hargaVal = parseInt(hargaInput.value) || 0;

            if (kuotaVal === 0 && hargaVal > 0) {
                hargaInput.classList.add('border-red-500', 'bg-red-50');
                errorMsg.classList.remove('hidden');
            } else {
                hargaInput.classList.remove('border-red-500', 'bg-red-50');
                errorMsg.classList.add('hidden');
            }
        }

        // Penanganan Submit Baru: Dipisah dari onsubmit bawaan form tag agar tidak terintersept menjadi GET
        function handleFormSubmit(e) {
            let isInvalid = false;
            let invalidTierName = '';

            document.querySelectorAll('.tier-card').forEach(card => {
                const kuotaVal = parseInt(card.querySelector('.kuota-input').value) || 0;
                const hargaVal = parseInt(card.querySelector('.harga-input').value) || 0;
                const nameVal = card.querySelector('.tier-name').value;

                if (kuotaVal === 0 && hargaVal > 0) {
                    isInvalid = true;
                    invalidTierName = nameVal;
                }
            });

            if (isInvalid) {
                Swal.fire({
                    icon: 'error',
                    title: 'LOGIKA TIKET SALAH!',
                    text: 'Masa tier ' + invalidTierName + ' tidak ada kuota (0) tapi diberi harga? Isi kuota terlebih dahulu atau ubah harga menjadi 0!',
                    confirmButtonColor: '#7a4988',
                    customClass: { popup: 'rounded-2xl' }
                });
            } else {
                // Jika validasi sukses, jalankan perintah submit form murni (POST -> PUT)
                document.getElementById('formTiket').submit();
            }
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.kuota-input').forEach(input => {
                let val = parseInt(input.value) || 0;
                if (val < 0) { val = 0; input.value = 0; }
                total += val;
            });
            document.getElementById('display_total').innerText = total;
            document.getElementById('input_total').value = total;
        }
        
        window.onload = function() {
            updateTotal();
            document.querySelectorAll('.harga-input').forEach(input => {
                checkKuotaConstraint(input);
            });
        };
    </script>
</body>
</html>