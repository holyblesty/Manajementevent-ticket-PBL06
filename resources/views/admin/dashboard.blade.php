@extends('layouts.admin')

@section('content')
<div class="w-full bg-gradient-to-r from-[#7a4988] to-[#be93d4] rounded-2xl p-8 mb-8 text-white shadow-sm">
    <h1 class="text-4xl font-black mb-2 uppercase tracking-tighter">DASHBOARD ADMIN</h1>
    <p class="bg-white/20 inline-block px-4 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">Kelola Acara</p>
</div>

<div class="mb-8">
    <a href="{{ route('admin.acara.create') }}" class="inline-flex items-center bg-[#7a4988] hover:bg-[#633a6e] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        TAMBAH ACARA
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative w-full md:w-96 text-[#7a4988]">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" placeholder="Cari otomatis nama event" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#7a4988] focus:border-[#7a4988] outline-none transition">
        </div>
        <select id="filterKategori" class="bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-lg px-4 py-2 outline-none focus:ring-1 focus:ring-[#7a4988] cursor-pointer font-bold">
            <option value="">Semua Kategori</option>
            <option value="Olahraga">Olahraga</option>
            <option value="Seminar">Seminar</option>
            <option value="Hiburan">Hiburan</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#7a4988] text-white text-[11px] uppercase tracking-widest font-black">
                <tr>
                    <th class="px-6 py-5 text-center">Poster</th>
                    <th class="px-6 py-4">Judul Acara</th>
                    <th class="px-6 py-4">Tanggal Acara</th>
                    <th class="px-6 py-4">Lokasi</th>
                    <th class="px-6 py-4 text-center">Kategori</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($events as $event)
                <tr class="hover:bg-gray-50/50 transition duration-300">
                    <td class="px-6 py-4">
                        <div class="w-20 h-12 bg-gray-100 rounded-lg overflow-hidden mx-auto shadow-inner border border-gray-50">
                            <img src="{{ asset('images/' . $event->poster) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-sm text-gray-700">{{ $event->judul }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400 font-medium">{{ $event->tanggal }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400 font-medium">{{ $event->lokasi }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-4 py-1 bg-[#be93d4]/20 text-[#7a4988] rounded-full text-[10px] font-black uppercase tracking-wider">{{ $event->kategori }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-3"> 
                            <a href="{{ route('admin.acara.edit', $event->id) }}" 
                               class="flex items-center justify-center w-24 h-8 bg-[#24112e] text-white rounded-full text-[9px] font-black hover:bg-black transition shadow-sm uppercase tracking-widest leading-none border-none outline-none">
                               UBAH
                            </a>

                            <form action="{{ route('admin.acara.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus acara ini?')" class="m-0 p-0 inline-flex">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="flex items-center justify-center w-24 h-8 bg-red-600 text-white rounded-full text-[9px] font-black hover:bg-red-700 transition shadow-sm uppercase tracking-widest leading-none border-none outline-none p-0 m-0 cursor-pointer">
                                    HAPUS
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-8 border-t border-gray-50 flex justify-center">
        <nav class="flex items-center space-x-2">
            <button class="p-2 text-gray-300 hover:text-[#7a4988] transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
            <button class="w-9 h-9 rounded-xl bg-[#be93d4] text-[#7a4988] font-black text-xs shadow-sm">1</button>
            <button class="w-9 h-9 rounded-xl text-gray-400 hover:bg-gray-50 font-bold text-xs transition">2</button>
            <button class="w-9 h-9 rounded-xl text-gray-400 hover:bg-gray-50 font-bold text-xs transition">3</button>
            <button class="p-2 text-gray-300 hover:text-[#7a4988] transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </nav>
    </div>
</div>

<script>
document.getElementById('filterKategori').addEventListener('change', function() {
    const selected = this.value.toLowerCase();
    const tbody = document.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    const match = [];
    const noMatch = [];

    rows.forEach(row => {
        const kategori = row.querySelector('td:nth-child(5)').innerText.toLowerCase();
        
        if (selected === "" || kategori.includes(selected)) {
            match.push(row);
            if(selected !== "") {
                row.classList.add('bg-purple-50/50');
            } else {
                row.classList.remove('bg-purple-50/50');
            }
        } else {
            noMatch.push(row);
            row.classList.remove('bg-purple-50/50');
        }
    });

    const sortedRows = [...match, ...noMatch];
    tbody.innerHTML = '';
    sortedRows.forEach(row => tbody.appendChild(row));
});
</script>
@endsection