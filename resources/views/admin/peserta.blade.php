@extends('layouts.admin')

@section('content')
<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-8 mb-8 text-white shadow-lg flex justify-between items-center">
    <div>
        <h1 class="text-4xl font-black mb-2 uppercase tracking-tighter">KELOLA PESERTA</h1>
        <p class="bg-white/20 inline-block px-4 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">Data Registrasi & Check-In</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -z-10"></div>
    
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="w-full md:w-1/2">
            <h2 class="text-lg font-black text-[#24112e] uppercase tracking-widest mb-1">Meja Check-In</h2>
            <p class="text-xs text-gray-400 font-bold uppercase">Cari nama atau ID Tiket peserta yang datang</p>
        </div>
        
        <div class="w-full md:w-1/2 relative flex items-center">
            <span class="absolute left-4 text-[#7a4988]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" id="quickSearch" placeholder="Ketik Nama / ID Tiket (Contoh: TKT-001)" class="w-full pl-12 pr-32 py-4 bg-gray-50 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-800 focus:border-[#7a4988] outline-none transition-all">
            <button onclick="applyFilters()" class="absolute right-2 top-2 bottom-2 bg-[#24112e] text-white px-6 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-black transition shadow-md border-none cursor-pointer">
                CARI
            </button>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
        <h3 class="text-xs font-black text-[#7a4988] uppercase tracking-widest">Daftar Semua Peserta</h3>
        <select id="filterEvent" class="bg-white border border-gray-200 text-gray-500 text-xs rounded-lg px-4 py-2 outline-none focus:ring-1 focus:ring-[#7a4988] font-bold cursor-pointer">
            <option value="">Semua Event</option>
            <option value="Turnamen Basket">Turnamen Basket</option>
            <option value="Festival Musik">Festival Musik</option>
            <option value="Seminar Nasional AI">Seminar AI</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#7a4988] text-white text-[10px] uppercase tracking-[0.2em] font-black">
                <tr>
                    <th class="px-6 py-4">ID Tiket</th>
                    <th class="px-6 py-4">Peserta / Tim</th>
                    <th class="px-6 py-4">Event & Tier</th>
                    <th class="px-6 py-4 text-center">Status Bayar</th>
                    <th class="px-6 py-4 text-center">Kehadiran</th>
                    <th class="px-6 py-4 text-center">Aksi Check-In</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($peserta as $p)
                <tr class="{{ $p['hadir'] ? 'bg-gray-50/50' : 'hover:bg-purple-50/30' }} transition participant-row">
                    <td class="px-6 py-4 font-black text-xs {{ $p['hadir'] ? 'text-gray-400' : 'text-[#24112e]' }} search-id">
                        #{{ $p['id'] }}
                    </td>
                    
                    <td class="px-6 py-4 search-nama">
                        <p class="font-bold text-sm {{ $p['hadir'] ? 'text-gray-400' : 'text-gray-800' }}">{{ $p['nama'] }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $p['kontak'] }}</p>
                    </td>

                    <td class="px-6 py-4 filter-event">
                        <p class="font-bold text-xs {{ $p['hadir'] ? 'text-gray-400' : 'text-gray-700' }}">{{ $p['event'] }}</p>
                        <p class="text-[10px] {{ $p['hadir'] ? 'text-gray-300' : 'text-[#7a4988]' }} font-black uppercase tracking-wider">{{ $p['tier'] }}</p>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($p['status_bayar'] == 'Lunas')
                            <span class="{{ $p['hadir'] ? 'bg-green-100/50 text-green-700/50' : 'bg-green-100 text-green-700' }} px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest">Lunas</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest">Pending</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($p['hadir'])
                            <span class="bg-[#be93d4] text-[#24112e] px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest shadow-sm">Sudah Hadir</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest">Belum Hadir</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if(!$p['hadir'])
                            @if($p['status_bayar'] == 'Lunas')
                                <form action="{{ route('admin.peserta.checkin', $p['id']) }}" method="POST" class="form-checkin inline-block m-0 p-0">
                                    @csrf
                                    <button type="button" onclick="confirmCheckIn(this, '{{ $p['nama'] }}')" class="bg-[#7a4988] hover:bg-[#24112e] text-white px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest transition shadow-sm border-none cursor-pointer">
                                        Check-In
                                    </button>
                                </form>
                            @else
                                <button onclick="Swal.fire({title:'AKSES DITOLAK', text:'Peserta belum melunasi pembayaran!', icon:'error', confirmButtonColor: '#e11d1d', customClass: {popup: 'rounded-3xl', title: 'font-black text-sm uppercase'}})" class="bg-gray-200 text-gray-400 px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest cursor-not-allowed border-none">
                                    Check-In
                                </button>
                            @endif
                        @else
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // NOTIFIKASI DARI CONTROLLER (Flash Session)
    @if(session('success'))
        Swal.fire({
            title: 'BERHASIL!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#24112e',
            timer: 2000,
            showConfirmButton: false,
            customClass: { popup: 'rounded-3xl', title: 'font-black text-sm uppercase' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'GAGAL!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonColor: '#e11d1d',
            customClass: { popup: 'rounded-3xl', title: 'font-black text-sm uppercase' }
        });
    @endif

    // LOGIC CHECK-IN MANUAL
    function confirmCheckIn(btn, nama) {
        const form = btn.closest('.form-checkin');
        Swal.fire({
            title: 'CHECK-IN PESERTA?',
            text: `Konfirmasi kehadiran untuk ${nama}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7a4988', 
            cancelButtonColor: '#e11d1d',  
            confirmButtonText: 'YA, HADIR',
            cancelButtonText: 'BATAL',
            reverseButtons: true,
            customClass: { popup: 'rounded-3xl', title: 'font-black text-sm uppercase tracking-tighter' }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form ke Controller jika dikonfirmasi
            }
        })
    }

    // LOGIC SEARCH & FILTER (Frontend)
    const searchInput = document.getElementById('quickSearch');
    const filterEvent = document.getElementById('filterEvent');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const eventTerm = filterEvent.value.toLowerCase();
        const rows = document.querySelectorAll('.participant-row');

        rows.forEach(row => {
            const nama = row.querySelector('.search-nama').innerText.toLowerCase();
            const id = row.querySelector('.search-id').innerText.toLowerCase();
            const event = row.querySelector('.filter-event').innerText.toLowerCase();
            
            const matchSearch = nama.includes(searchTerm) || id.includes(searchTerm);
            const matchEvent = eventTerm === "" || event.includes(eventTerm);

            if (matchSearch && matchEvent) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    searchInput.addEventListener('keyup', applyFilters);
    filterEvent.addEventListener('change', applyFilters);
</script>
@endsection