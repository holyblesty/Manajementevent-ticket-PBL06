@extends('layouts.admin')

@section('content')
<div class="w-full px-8 py-8">
    
    {{-- 1. HEADER BANNER --}}
    <div class="relative w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-3xl p-12 mb-10 text-white shadow-2xl flex items-center overflow-hidden">
        <div class="flex flex-col items-center mr-12">
            <div class="w-32 h-32 bg-black rounded-full border-4 border-white/20 flex items-center justify-center overflow-hidden shadow-inner mb-4">
                <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <p class="font-black text-lg uppercase tracking-widest">WELCOME ADMIN</p>
        </div>

        <div class="flex-grow">
            <h1 class="text-7xl font-black uppercase tracking-tighter mb-4">DASHBOARD ADMIN</h1>
            <div class="bg-white/20 inline-block px-5 py-2 rounded-md text-xl font-bold uppercase tracking-widest text-white">
                STATISTIK
            </div>
        </div>
    </div>

    {{-- 2. GRID UTAMA (Grafik & Cards) --}}
    <div class="grid grid-cols-12 gap-8 items-stretch">
        
        {{-- BAGIAN KIRI: GRAFIK --}}
        <div class="col-span-12 xl:col-span-8 bg-white rounded-2xl shadow-xl border border-gray-100 p-10 overflow-hidden flex flex-col">
            <div class="flex justify-between items-center mb-12">
                <h3 class="text-3xl font-black text-[#24112e] uppercase italic">Grafik Penjualan Tiket Per Bulan</h3>
                
                <form action="{{ route('admin.statistik') }}" method="GET" class="flex gap-4">
                    <select name="sort" onchange="this.form.submit()" class="border-2 border-gray-200 bg-gray-50 text-base font-bold px-10 py-3 rounded-xl outline-none hover:border-[#7a4988] transition cursor-pointer">
                        <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>Penjualan terbanyak</option>
                        <option value="terdikit" {{ request('sort') == 'terdikit' ? 'selected' : '' }}>Penjualan terdikit</option>
                    </select>
                    
                    <select name="bulan" onchange="this.form.submit()" class="bg-gray-200 px-10 py-3 rounded-xl text-base font-bold text-gray-700 outline-none hover:bg-gray-300 transition cursor-pointer border-2 border-transparent">
                        <option value="Mei" {{ request('bulan', 'Mei') == 'Mei' ? 'selected' : '' }}>Pilih Bulan : Mei</option>
                        <option value="Juni" {{ request('bulan') == 'Juni' ? 'selected' : '' }}>Pilih Bulan : Juni</option>
                    </select>
                </form>
            </div>

            <div class="flex items-end gap-12 flex-grow">
                {{-- Area Grafik --}}
                <div class="relative h-[400px] w-full border-l-4 border-b-4 border-gray-300 flex items-end justify-start gap-12 pl-14 pb-0 overflow-x-auto">
                    <div class="absolute -left-12 h-full flex flex-col justify-between text-base font-bold text-gray-500 py-0 pr-2 text-right w-12">
                        <span>125</span><span>100</span><span>75</span><span>50</span><span>25</span><span class="mb-1">0</span>
                    </div>

                    <div class="absolute w-full border-t-2 border-gray-100 top-0"></div>
                    <div class="absolute w-full border-t-2 border-gray-100 top-[20%]"></div>
                    <div class="absolute w-full border-t-2 border-gray-100 top-[40%]"></div>
                    <div class="absolute w-full border-t-2 border-gray-100 top-[60%]"></div>
                    <div class="absolute w-full border-t-2 border-gray-100 top-[80%]"></div>
                    
                    @php $colors = ['bg-[#059669]', 'bg-[#1e3a8a]', 'bg-[#581c1c]', 'bg-[#c2410c]']; @endphp
                    @forelse($laporanEvent as $index => $ev)
                    <div class="group relative w-28 flex flex-col items-center justify-end h-full z-10">
                        <div class="absolute bottom-full mb-4 w-72 bg-gray-900/95 text-white p-5 rounded-2xl shadow-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none text-base transform -translate-x-1/2 left-1/2 border border-white/20">
                            <p class="font-black text-lg uppercase mb-2 border-b border-white/10 pb-2">{{ $ev['judul'] }}</p>
                            <p class="mb-1">Penjualan : <strong class="text-[#be93d4]">{{ $ev['terjual'] }} tiket</strong></p>
                            <p>Pendapatan : <strong class="text-green-400">Rp {{ number_format($ev['pendapatan'], 0, ',', '.') }}</strong></p>
                        </div>
                        
                        <div class="{{ $colors[$index % 4] }} w-24 transition-all duration-500 hover:brightness-125 shadow-lg rounded-t-sm" 
                             style="height: {{ min(($ev['terjual'] / 125) * 100, 100) }}%;">
                        </div>
                    </div>
                    @empty
                        <p class="text-gray-400 font-bold text-xl mb-10 italic z-10">Belum ada data untuk bulan {{ $selectedMonth }}...</p>
                    @endforelse
                </div>

                <div class="w-80 space-y-5">
                    @foreach($laporanEvent as $index => $ev)
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 flex-shrink-0 {{ $colors[$index % 4] }} rounded shadow-sm"></div>
                        <span class="text-base font-black text-gray-800 leading-tight uppercase">{{ \Illuminate\Support\Str::limit($ev['judul'], 35) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="text-center font-black text-4xl text-[#24112e] mt-12 uppercase italic tracking-widest">{{ $selectedMonth }}</div>
        </div>

        {{-- BAGIAN KANAN: CARDS --}}
        <div class="col-span-12 xl:col-span-4 flex flex-col gap-6">
            
            {{-- Kotak Pendapatan & Terjual (Bersebelahan) --}}
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#7a4988] transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="bg-[#7a4988]/10 w-16 h-16 flex items-center justify-center rounded-2xl text-[#7a4988] mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Pendapatan</p>
                    <h2 class="text-3xl font-black text-[#24112e] break-all leading-tight group-hover:text-[#7a4988]">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#9e7bb5] transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="bg-[#9e7bb5]/10 w-16 h-16 flex items-center justify-center rounded-2xl text-[#9e7bb5] mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Terjual</p>
                    <h2 class="text-4xl font-black text-[#24112e] group-hover:text-[#9e7bb5]">{{ $totalTiketTerjual }} <span class="text-sm font-medium text-gray-400 uppercase">Tiket</span></h2>
                </div>
            </div>

            {{-- Kartu Event Terlaris (HEBOH & CENTERED) --}}
            <div class="bg-[#7a4988] p-12 rounded-3xl text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group flex-grow flex flex-col justify-center items-center border-4 border-white hover:border-[#9e7bb5]">
                <div class="absolute right-[-5%] top-[-5%] opacity-20 group-hover:scale-150 group-hover:-rotate-12 transition-all duration-1000">
                    <svg class="w-56 h-56" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                </div>
                
                <div class="z-10 text-center flex flex-col items-center">
                    <p class="text-xl font-bold opacity-80 uppercase tracking-[0.3rem] mb-6 z-10 italic">
                        🏆 EVENT TERLARIS {{ $selectedMonth }}
                    </p>
                    <h3 class="text-5xl font-black leading-tight group-hover:scale-105 transition-transform duration-500 z-10 uppercase italic mb-4">
                        {{ $terlaris['judul'] ?? 'Belum Ada Data' }}
                    </h3>
                    @if($terlaris['judul'])
                        <p class="text-2xl font-bold opacity-80 tracking-wide z-10 italic mt-3 text-[#be93d4]">
                            PECAH REKOR PENJUALAN TIKET! 💥💥💥
                        </p>
                    @endif
                </div>
                <div class="absolute inset-0 rounded-3xl border-4 border-white opacity-0 group-hover:opacity-30 transition-opacity duration-300 z-5"></div>
            </div>

        </div>
    </div> 

    {{-- 3. TABEL RINGKASAN --}}
    <div class="mt-12 bg-white rounded-[2rem] shadow-2xl border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="font-black text-4xl uppercase italic text-[#24112e]">Laporan Ringkasan per Event</h3>
            <div class="relative">
                <input type="text" id="searchTable" placeholder="Cari otomatis nama event..." 
                       class="pl-14 pr-6 py-5 border-2 border-gray-200 rounded-2xl text-lg w-[450px] outline-none focus:border-[#7a4988] transition shadow-inner font-bold">
                <svg class="w-7 h-7 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#9e7bb5] text-white uppercase text-lg font-black tracking-wider">
                    <tr>
                        <th class="p-8 text-center w-40">Tanggal</th>
                        <th class="p-8">Nama Event</th>
                        <th class="p-8 w-48">Kategori</th>
                        <th class="p-8 text-center w-40">Kapasitas</th>
                        <th class="p-8 text-center w-48">Tiket Terjual</th>
                        <th class="p-8 w-64">Pendapatan</th>
                        <th class="p-8 text-center w-48">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse($laporanEvent as $row)
                    <tr class="row-event hover:bg-purple-50/50 transition-colors">
                        <td class="p-8 text-center font-bold text-gray-600 whitespace-nowrap text-xl">{{ $row['tanggal'] }}</td>
                        <td class="p-8 font-black text-gray-900 judul-acara uppercase text-2xl">{{ $row['judul'] }}</td>
                        <td class="p-8 text-gray-600 font-bold text-xl">{{ $row['kategori'] }}</td>
                        <td class="p-8 text-center">
                            <div class="font-black text-gray-800 text-2xl">{{ $row['kuota'] }}</div>
                            <div class="text-sm font-black text-gray-400 uppercase tracking-widest mt-1">{{ $row['tipe'] }}</div>
                        </td>
                        <td class="p-8 text-center font-black text-[#7a4988] text-3xl">{{ $row['terjual'] }}/<span class="text-2xl text-gray-500">{{ $row['kuota'] }}</span></td>
                        <td class="p-8 font-black text-green-600 whitespace-nowrap text-2xl">Rp {{ number_format($row['pendapatan'], 0, ',', '.') }}</td>
                        <td class="p-8 text-center">
                            <span class="{{ $row['status'] == 'Terjual Habis' ? 'bg-red-600' : 'bg-green-600' }} text-white px-6 py-3 rounded-xl text-sm font-black uppercase tracking-widest shadow-md whitespace-nowrap inline-block">
                                {{ $row['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-16 text-center text-gray-400 font-bold text-2xl not-italic">Data tidak ditemukan untuk bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-8 flex justify-center">
        @include('components.pagination')
    </div>
</div>

<script>
    document.getElementById('searchTable').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('.row-event').forEach(row => {
            let title = row.querySelector('.judul-acara').innerText.toLowerCase();
            row.style.display = title.includes(filter) ? "" : "none";
        });
    });
</script>
@endsection