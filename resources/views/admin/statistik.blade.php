@extends('layouts.admin')

@section('content')
    {{-- HEADER BANNER --}}
<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-8 mb-8 text-white shadow-lg">
    <h1 class="text-4xl font-black uppercase tracking-tighter">DASHBOARD ADMIN</h1>
<p class="bg-white/20 inline-block px-4 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">Melihat Statistik</p>
    </div>

    {{-- GRID UTAMA --}}
    <div class="grid grid-cols-12 gap-6">
        
        {{-- GRAFIK SECTION (KIRI - Dibuat lebih dominan) --}}
        <div class="col-span-12 xl:col-span-8 bg-white rounded-xl shadow border border-gray-100 p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xs font-black text-[#24112e] uppercase">GRAFIK PENJUALAN TIKET PER EVENT</h3>
                
                <div class="flex gap-2">
                    <form action="{{ route('admin.statistik') }}" method="GET">
                        <select name="sort" onchange="this.form.submit()" class="border border-gray-300 text-[10px] px-1 py-1 rounded cursor-pointer outline-none w-45">
                            <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>Penjualan Terbanyak</option>
                            <option value="terdikit" {{ request('sort') == 'terdikit' ? 'selected' : '' }}>Penjualan Terdikit</option>
                        </select>
                    </form>
                    <select class="border border-gray-300 text-[10px] px-3 py-1.5 rounded bg-gray-50 w-45" disabled>
                        <option>Pilih Bulan : Mei</option>
                    </select>
                </div>
            </div>

            {{-- AREA GRAFIK DITINGGIKAN (h-64) --}}
            <div class="flex items-start gap-8">
                <div class="relative h-64 w-full border-l border-b border-gray-300 flex items-end justify-around pb-0">
                    {{-- Grid lines --}}
                    <div class="absolute w-full border-t border-gray-100 top-0"></div>
                    <div class="absolute w-full border-t border-gray-100 top-1/4"></div>
                    <div class="absolute w-full border-t border-gray-100 top-1/2"></div>
                    <div class="absolute w-full border-t border-gray-100 top-3/4"></div>
                    
                    {{-- Bar Grafik (Lebih lebar w-12) --}}
                    @php $colors = ['bg-green-600', 'bg-blue-800', 'bg-red-900', 'bg-orange-600']; @endphp
                    @forelse($laporanEvent as $index => $ev)
                    <div class="group relative w-16 flex flex-col items-center justify-end h-full">
{{-- TOOLTIP (Pasti muncul karena z-[9999]) --}}
    <div class="absolute bottom-full mb-3 w-40 bg-gray-900 text-white p-3 rounded shadow-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-[9999] pointer-events-none text-[10px] text-center transform -translate-x-1/2 left-1/2 whitespace-nowrap">
        <p class="font-black uppercase truncate">{{ $ev['judul'] }} !</p>
        <p>Tiket: <strong>{{ $ev['terjual'] }}</strong></p>
        <p>Rp {{ number_format($ev['pendapatan'], 0, ',', '.') }}</p>
    </div>            {{-- Batang --}}
                        <div class="{{ $colors[$index % 4] }} w-30 transition-all duration-500 hover:opacity-80" 
                             style="height: {{ max(($ev['terjual'] / 125) * 100, 15) }}%;">
                        </div>
                    </div>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada data</p>
                    @endforelse
                </div>

                {{-- LEGENDA --}}
                <div class="w-56 space-y-3 pt-2">
                    @foreach($laporanEvent as $index => $ev)
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 flex-shrink-0 {{ $colors[$index % 4] }}"></div>
                        <span class="text-[10px] font-bold text-gray-700 truncate">{{ \Illuminate\Support\Str::limit($ev['judul'], 25) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="text-center font-black text-[#24112e] text-[12px] mt-6">Mei</div>
        </div>

        {{-- KANAN CARDS --}}
        <div class="col-span-12 xl:col-span-4 flex flex-col gap-6">
            <div class="bg-[#7a4988] p-8 rounded-xl text-white shadow-md">
                <p class="text-[10px] font-bold opacity-70 uppercase tracking-widest">Total Pendapatan</p>
                <h2 class="text-3xl font-black mt-2 italic">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
            </div>
            <div class="bg-[#7a4988] p-8 rounded-xl text-white shadow-md">
                <p class="text-[10px] font-bold opacity-70 uppercase tracking-widest">Tiket Terjual</p>
                <h2 class="text-3xl font-black mt-2">{{ $totalTiketTerjual }}</h2>
            </div>
            <div class="bg-[#4a1c54] p-8 rounded-xl text-white shadow-md flex-grow">
                <p class="text-[10px] font-bold opacity-70 uppercase tracking-widest">Event Terlaris</p>
                <h3 class="text-lg font-black mt-2">{{ $terlaris['judul'] ?? '-' }}</h3>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
  {{-- TABEL (Versi Font Jumbo) --}}
    <div class="mt-8 bg-white rounded-2xl shadow border border-gray-100 w-full">
        <div class="p-8 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="font-black text-lg uppercase text-gray-800">Laporan Ringkasan Per Event</h3>
            <input type="text" id="searchTable" placeholder="Cari nama event..." class="pl-5 py-3 border border-gray-300 rounded-xl text-base w-80 outline-none">
        </div>
        
        {{-- Menggunakan text-lg (18px) agar sangat terbaca --}}
        <table class="w-full text-left text-lg">
            <thead class="bg-[#7a4988] text-white uppercase text-base font-bold">
                <tr>
                    <th class="p-8">Tanggal</th>
                    <th class="p-8">Nama Event</th>
                    <th class="p-8">Kategori</th>
                    <th class="p-8">Kapasitas</th>
                    <th class="p-8">Tiket Terjual</th>
                    <th class="p-8">Pendapatan</th>
                    <th class="p-8">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($laporanEvent as $row)
                <tr class="row-event hover:bg-purple-50 transition-colors">
                    <td class="p-8 text-gray-700">{{ $row['tanggal'] }}</td>
                    <td class="p-8 font-black text-gray-900 judul-acara">{{ $row['judul'] }}</td>
                    <td class="p-8 text-gray-700">{{ $row['kategori'] }}</td>
                    <td class="p-8 text-gray-700">{{ $row['kuota'] }}</td>
                    <td class="p-8 font-black text-gray-900">{{ $row['terjual'] }}/{{ $row['kuota'] }}</td>
                    <td class="p-8 font-black text-gray-900">Rp {{ number_format($row['pendapatan'], 0, ',', '.') }}</td>
                    <td class="p-8">
                        <span class="{{ $row['status'] == 'Terjual Habis' ? 'bg-red-600' : 'bg-green-600' }} text-white px-6 py-2 rounded-xl text-base font-bold uppercase">
                            {{ $row['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
          @include('components.pagination')
</div>

<script>
    document.getElementById('searchTable').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.row-event');
        rows.forEach(row => {
            let title = row.querySelector('.judul-acara').innerText.toLowerCase();
            row.style.display = title.includes(filter) ? "" : "none";
        });
    });
</script>
@endsection