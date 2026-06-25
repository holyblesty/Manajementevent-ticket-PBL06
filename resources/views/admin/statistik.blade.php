@extends('layouts.admin')

@section('content')
{{-- DEKLARASI WARNA DI PALING ATAS --}}
@php
    $colors = [
        'bg-[#059669]',
        'bg-[#1e3a8a]',
        'bg-[#581c1c]',
        'bg-[#c2410c]'
    ];
@endphp

{{-- Pembungkus Utama --}}
<div class="w-full px-8 py-6 font-sans antialiased !overflow-visible">
    
    {{-- 1. HEADER BANNER --}}
    <div class="relative w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-3xl p-6 mb-6 text-white shadow-md flex items-center overflow-hidden">
        <div class="flex-grow">
            <h1 class="text-3xl font-black uppercase tracking-tighter mb-1">DASHBOARD ADMIN</h1>
            <div class="bg-white/20 inline-block px-3 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">
                STATISTIK
            </div>
        </div>
    </div>

    {{-- 2. GRID UTAMA (Grafik & Cards) --}}
    <div class="grid grid-cols-12 gap-6 items-stretch !overflow-visible">
        
        {{-- BAGIAN KIRI: GRAFIK --}}
        <div class="col-span-12 xl:col-span-8 bg-white rounded-2xl shadow-xl border border-gray-100 p-8 !overflow-visible flex flex-col justify-between">
            
            {{-- Bagian Atas Grafik: Judul & Form Filter --}}
            <div class="flex justify-between items-center mb-10 !overflow-visible">
                <h3 class="text-lg font-black text-[#24112e] uppercase italic tracking-wider">
                    Grafik Penjualan Tiket Per Bulan
                </h3>
                
                <form action="{{ route('admin.statistik') }}" method="GET" class="flex gap-3 !overflow-visible">
                    {{-- DROPDOWN SORT --}}
                    <select name="sort" onchange="this.form.submit()" 
                        class="border border-gray-300 bg-gray-50 text-xs font-bold px-3 py-2 rounded-xl outline-none hover:border-[#7a4988] transition cursor-pointer w-52 shadow-sm">
                        <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>
                            Penjualan terbanyak
                        </option>
                        <option value="terdikit" {{ request('sort') == 'terdikit' ? 'selected' : '' }}>
                            Penjualan terdikit
                        </option>
                    </select>
                    
                    {{-- DROPDOWN BULAN --}}
   <select name="bulan" onchange="this.form.submit()" 
    class="bg-gray-100 border border-gray-300 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 outline-none hover:bg-gray-200 transition cursor-pointer w-44 shadow-sm">
    
    @php
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
    @endphp

    <option value="">Pilih Bulan</option>
    @foreach($bulanList as $b)
        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
            {{ $b }}
        </option>
    @endforeach
</select>
                </form>
            </div>

            {{-- Bagian Tengah: Sumbu Grafik & Legenda Berdampingan --}}
            <div class="flex items-center gap-10 flex-grow w-full mb-6 !overflow-visible">
                
                {{-- AREA DUA KOLOM UTAMA --}}
                <div class="flex h-[250px] flex-grow !overflow-visible items-stretch">
                    
                    {{-- 1. KOLOM SUMBU Y --}}
                    <div class="w-10 flex flex-col justify-between text-xs font-bold text-gray-400 py-0 pr-3 text-right select-none pointer-events-none">
                        <span>125</span>
                        <span>100</span>
                        <span>75</span>
                        <span>50</span>
                        <span>25</span>
                        <span class="mb-0.5">0</span>
                    </div>

                    {{-- 2. SUB-CONTAINER GRAFIK BATANG (Garis grid horizontal dikunci 100% hanya di dalam box ini) --}}
                    <div class="relative flex-grow border-l-2 border-b-2 border-gray-300 flex items-end justify-start gap-12 pl-12 pb-0 !overflow-visible">
                        
                        {{-- Garis Grid Belakang (Aman terkurung di dalam area grafik, tidak bisa bolos ke kanan) --}}
                        <div class="absolute inset-x-0 top-0 border-t border-gray-100 z-0"></div>
                        <div class="absolute inset-x-0 top-[20%] border-t border-gray-100 z-0"></div>
                        <div class="absolute inset-x-0 top-[40%] border-t border-gray-100 z-0"></div>
                        <div class="absolute inset-x-0 top-[60%] border-t border-gray-100 z-0"></div>
                        <div class="absolute inset-x-0 top-[80%] border-t border-gray-100 z-0"></div>

                        @forelse($laporanEvent as $index => $ev)
                        {{-- Batang grafik --}}
                        <div class="group relative flex flex-col-reverse items-center gap-2 h-full z-10 !overflow-visible bar-container cursor-help"
                             data-judul="{{ $ev['judul'] }}"
                             data-terjual="{{ $ev['terjual'] }}"
                             data-pendapatan="Rp {{ number_format($ev['pendapatan'], 0, ',', '.') }}"
                             style="width: 56px;">

                            {{-- BAR --}}
                            <div class="{{ $colors[$index % 4] }}
                                        w-14
                                        transition-all
                                        duration-500
                                        hover:brightness-125
                                        shadow
                                        rounded-t-sm"
                                style="height: {{ ($ev['terjual'] / 125) * 100 }}%;">
                            </div>

                            {{-- ANGKA DI ATAS BATANG --}}
                            <div class="text-xs font-black text-[#24112e] whitespace-nowrap select-none">
                                {{ $ev['terjual'] }}
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 font-bold text-sm mb-6 italic z-10">
                            Belum ada data untuk bulan {{ $selectedMonth }}...
                        </p>
                        @endforelse
                    </div>
                </div>

                {{-- LEGENDA KANAN (Aman, bersih dari gangguan tabrakan garis grid) --}}
                <div class="w-64 space-y-3 flex-shrink-0">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Daftar Event</p>
                    @foreach($laporanEvent as $index => $ev)
                    <div class="flex items-center gap-2.5">
                        <div class="w-4 h-4 flex-shrink-0 {{ $colors[$index % 4] }} rounded shadow-sm"></div>
                        <span class="text-xs font-black text-gray-800 leading-tight uppercase truncate" title="{{ $ev['judul'] }}">
                            {{ \Illuminate\Support\Str::limit($ev['judul'], 20) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Nama Bulan di Bawah --}}
            <div class="text-center font-black text-xl text-[#24112e] uppercase italic tracking-widest pt-2">
          
            </div>
        </div>

        {{-- BAGIAN KANAN: CARDS --}}
        <div class="col-span-12 xl:col-span-4 flex flex-col gap-4">
            <div class="grid grid-cols-2 gap-4">
                {{-- PENDAPATAN --}}
                <div class="bg-white p-5 rounded-2xl shadow border border-gray-100 hover:border-[#7a4988] transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between min-h-[140px]"
                     style="min-width: 175px !important;">
                    <div>
                        <div class="bg-[#7a4988]/10 w-11 h-11 flex items-center justify-center rounded-xl text-[#7a4988] mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                            Pendapatan
                        </p>
                    </div>
                    <h2 class="text-base font-black text-[#24112e] tracking-tight group-hover:text-[#7a4988]"
                        style="white-space: nowrap !important; word-break: keep-all !important; overflow: visible !important;">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h2>
                </div>

                {{-- TIKET TERJUAL --}}
                <div class="bg-white p-5 rounded-2xl shadow border border-gray-100 hover:border-[#9e7bb5] transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-between min-h-[140px]"
                     style="min-width: 130px !important;">
                    <div>
                        <div class="bg-[#9e7bb5]/10 w-11 h-11 flex items-center justify-center rounded-xl text-[#9e7bb5] mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                            Terjual
                        </p>
                    </div>
                    <h2 class="text-xl font-black text-[#24112e]" style="white-space: nowrap !important;">
                        {{ $totalTiketTerjual }}
                        <span class="text-[10px] font-medium text-gray-400 uppercase">Tiket</span>
                    </h2>
                </div>
            </div>

            {{-- EVENT TERLARIS --}}
            <div class="bg-[#7a4988] p-5 rounded-2xl text-white shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5 relative overflow-hidden group flex-grow flex flex-col justify-center items-center border-2 border-white hover:border-[#9e7bb5] min-h-[150px]">
                <div class="absolute right-[-10%] top-[-10%] opacity-10 group-hover:scale-110 group-hover:-rotate-12 transition-all duration-1000">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                </div>
                
                <div class="z-10 text-center flex flex-col items-center w-full max-w-full px-2">
                    <p class="text-[10px] font-bold opacity-80 uppercase tracking-[0.15rem] mb-2.5 italic">
                        🏆 EVENT TERLARIS {{ $selectedMonth }}
                    </p>
                    <h3 class="text-lg md:text-xl font-black leading-tight uppercase italic text-center w-full line-clamp-2" title="{{ $terlaris['judul'] ?? '' }}">
                        {{ $terlaris['judul'] ?? 'Belum Ada Data' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. TABEL --}}
    <div class="mt-8 bg-white rounded-2xl shadow border border-gray-100 overflow-hidden w-full">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="font-black text-lg uppercase italic text-[#24112e]">
                Laporan Ringkasan per Event
            </h3>
            <div class="relative">
                <input type="text" 
                       id="searchTable" 
                       placeholder="Cari otomatis nama event..." 
                       class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-72 outline-none focus:border-[#7a4988] transition shadow-inner font-bold">
                <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-lg">
                <thead class="bg-[#9e7bb5] text-white uppercase text-sm font-black tracking-wider">
                    <tr>
                        <th class="p-4 text-center w-36">Tanggal</th>
                        <th class="p-4">Nama Event</th>
                        <th class="p-4 w-40">Kategori</th>
                        <th class="p-4 text-center w-40">Kapasitas</th>
                        <th class="p-4 text-center w-40">Tiket Terjual</th>
                        <th class="p-4 w-48">Pendapatan</th>
                        <th class="p-4 text-center w-36">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse($laporanEvent as $row)
                    <tr class="row-event hover:bg-purple-50/50 transition-colors">
                        <td class="p-4 text-center font-bold text-gray-600 whitespace-nowrap text-base">
                            {{ $row['tanggal'] }}
                        </td>
                        <td class="p-4 font-black text-gray-900 judul-acara uppercase text-lg">
                            {{ $row['judul'] }}
                        </td>
                        <td class="p-4 text-gray-600 font-bold text-base">
                            {{ $row['kategori'] }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="font-black text-gray-800 text-lg">
                                {{ $row['kuota'] }}
                            </div>
                            <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">
                                {{ $row['tipe'] == 'tim' ? 'TIKET TIM' : 'TIKET INDIVIDU' }}
                            </div>
                        </td>
                        <td class="p-4 text-center font-black text-[#7a4988] text-xl">
                            {{ $row['terjual'] }}/
                            <span class="text-base text-gray-500">
                                {{ $row['kuota'] }}
                            </span>
                        </td>
                        <td class="p-4 font-black text-green-600 whitespace-nowrap text-lg">
                            Rp {{ number_format($row['pendapatan'], 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center">
                            <span class="{{ $row['status'] == 'Terjual Habis' ? 'bg-red-600' : 'bg-green-600' }} text-white px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm whitespace-nowrap inline-block">
                                {{ $row['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-400 font-bold text-lg not-italic">
                            Data tidak ditemukan untuk bulan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

{{-- HTML TOOLTIP GLOBAL MELAYANG --}}
<div id="custom-tooltip" class="fixed bg-white/95 backdrop-blur-md text-gray-900 px-6 py-4 rounded-2xl shadow-2xl border border-gray-100 pointer-events-none opacity-0 transition-opacity duration-150 z-[9999] text-left hidden w-80">
    <p id="tooltip-judul" class="font-black text-base uppercase text-[#24112e] mb-2 border-b border-gray-100 pb-2"></p>
    <p class="text-xs font-bold text-gray-600 mb-1">
        Penjualan tiket : <span id="tooltip-terjual" class="text-[#7a4988] font-black"></span>
    </p>
    <p class="text-xs font-bold text-gray-600">
        Pendapatan : <span id="tooltip-pendapatan" class="text-green-600 font-black"></span>
    </p>
</div>

<script>
    // FILTER PENCARIAN OTOMATIS TABEL
    document.getElementById('searchTable').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('.row-event').forEach(row => {
            let title = row.querySelector('.judul-acara').innerText.toLowerCase();
            row.style.display = title.includes(filter) ? "" : "none";
        });
    });

    // SISTEM MOUSE-TRACKING TOOLTIP GRAFIK
    document.addEventListener('DOMContentLoaded', function() {
        const tooltip = document.getElementById('custom-tooltip');
        const tooltipJudul = document.getElementById('tooltip-judul');
        const tooltipTerjual = document.getElementById('tooltip-terjual');
        const tooltipPendapatan = document.getElementById('tooltip-pendapatan');
        const containers = document.querySelectorAll('.bar-container');

        containers.forEach(container => {
            container.addEventListener('mouseenter', function(e) {
                const judul = this.getAttribute('data-judul');
                const terjual = this.getAttribute('data-terjual');
                const pendapatan = this.getAttribute('data-pendapatan');

                tooltipJudul.innerText = judul;
                tooltipTerjual.innerText = terjual + ' tiket';
                tooltipPendapatan.innerText = pendapatan;

                tooltip.classList.remove('hidden');
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY + 15) + 'px';
                
                setTimeout(() => tooltip.classList.add('opacity-100'), 10);
            });

            container.addEventListener('mousemove', function(e) {
                tooltip.style.left = (e.clientX + 15) + 'px';
                tooltip.style.top = (e.clientY + 15) + 'px';
            });

            container.addEventListener('mouseleave', function() {
                tooltip.classList.remove('opacity-100');
                tooltip.classList.add('opacity-0');
                setTimeout(() => {
                    if (tooltip.classList.contains('opacity-0')) {
                        tooltip.classList.add('hidden');
                    }
                }, 150);
            });
        });
    });
</script>
@endsection