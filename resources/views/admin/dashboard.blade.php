@extends('layouts.admin')

@section('content')
<div id="imageModal" class="fixed inset-0 z-[999] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
    <button onclick="closeModal()" class="absolute top-6 right-6 text-white hover:text-red-500 transition-colors">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <div class="max-w-4xl w-full flex flex-col items-center">
        <img id="modalImg" src="" class="max-h-[80vh] rounded-2xl shadow-2xl border-4 border-white/10 object-contain">
        <p id="modalCaption" class="mt-4 text-white font-black uppercase tracking-[0.3em] text-base bg-[#7a4988] px-8 py-3 rounded-full"></p>
    </div>
</div>

<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-10 mb-10 text-white shadow-lg flex justify-between items-center">
    <div>
        <h1 class="text-5xl font-black mb-3 uppercase tracking-tighter">DASHBOARD ADMIN</h1>
        <p class="bg-white/20 inline-block px-5 py-2 rounded text-sm font-bold uppercase tracking-widest text-white">Kelola Acara</p>
    </div>
    
    <div class="bg-white/10 border border-white/20 px-8 py-5 rounded-2xl">
        <p class="text-xs font-black uppercase tracking-[0.3em] text-[#be93d4] mb-2 text-center">
            Administrator
        </p>
        <p class="text-2xl font-black text-white text-center">
            {{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->username : 'Admin' }}
        </p>
    </div>
</div>

<div class="mb-8">
    <a href="{{ route('admin.acara.create') }}" class="inline-flex items-center bg-[#7a4988] hover:bg-[#633a6e] text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-md no-underline">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        TAMBAH ACARA
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative w-full md:w-96 text-[#7a4988]">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" id="searchInput" placeholder="Cari event atau lokasi..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-base focus:ring-1 focus:ring-[#7a4988] outline-none transition">
        </div>
        
      <form method="GET" action="{{ route('admin.dashboard') }}">
    <select
        name="status"
        onchange="this.form.submit()"
        class="bg-gray-50 border border-gray-200 text-gray-500 text-base rounded-lg px-5 py-3 outline-none focus:ring-1 focus:ring-[#7a4988] cursor-pointer font-bold"
    >
        <option value="">Semua Event</option>

        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>
            Open
        </option>

        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
            Closed
        </option>

        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
            Draft
        </option>
    </select>
</form>
        <select id="filterKategori" class="bg-gray-50 border border-gray-200 text-gray-500 text-base rounded-lg px-5 py-3 outline-none focus:ring-1 focus:ring-[#7a4988] cursor-pointer font-bold">
            <option value="" {{ (isset($selectedCategory) && $selectedCategory == '') ? 'selected' : '' }}>Semua Kategori</option>
            <option value="Olahraga" {{ (isset($selectedCategory) && $selectedCategory == 'Olahraga') ? 'selected' : '' }}>Olahraga</option>
            <option value="Seminar" {{ (isset($selectedCategory) && $selectedCategory == 'Seminar') ? 'selected' : '' }}>Seminar</option>
            <option value="Hiburan" {{ (isset($selectedCategory) && $selectedCategory == 'Hiburan') ? 'selected' : '' }}>Hiburan</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#7a4988] text-white text-base uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-5 text-center">Poster</th>
                    <th class="px-6 py-5">Judul Acara</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5">Waktu Acara</th>
                    <th class="px-6 py-5">Lokasi</th>
                    <th class="px-6 py-5 text-center">Kategori</th>
                    <th class="px-6 py-5 text-center">Kapasitas</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($events as $event)
                <tr class="hover:bg-gray-50/50 transition duration-300">
                    <td class="px-6 py-5">
                        <div onclick="openModal('{{ $event->poster ? asset('images/' . $event->poster) : asset('images/default.jpg') }}', 'Poster: {{ $event->judul }}')" class="w-28 h-20 bg-gray-100 rounded-lg overflow-hidden mx-auto shadow-inner border border-gray-50 cursor-pointer hover:ring-2 hover:ring-[#7a4988] transition-all">
                            <img src="{{ $event->poster ? asset('images/' . $event->poster) : asset('images/default.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="font-bold text-xl text-gray-800 judul-acara">{{ $event->judul }}</div>
                        <div class="text-l text-gray-400 font-medium mt-1 line-clamp-2 max-w-[200px]">
                            {{ $event->deskripsi }}
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $waktuSelesaiEvent = $event->tgl_selesai ? strtotime($event->tgl_selesai->format('Y-m-d') . ' ' . ($event->jam_selesai ?? '23:59:59')) : time();
                            $status = ($event->status_event == 'draft') ? 'draft' : 
                                      (($waktuSelesaiEvent < time()) ? 'closed' : 'open');
                            
                            $badgeClass = [
                                'draft' => 'bg-gray-100 text-gray-600 border-gray-200',
                                'open'  => 'bg-green-50 text-green-700 border-green-200',
                                'closed'=> 'bg-red-50 text-red-700 border-red-200'
                            ][$status];
                        @endphp
                        <span class="status-label inline-block px-4 py-1.5 text-xs font-black uppercase tracking-widest rounded-full border {{ $badgeClass }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-gray-500 whitespace-nowrap">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center text-sm font-bold text-gray-700">
                                <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded text-[10px] uppercase font-black tracking-wider mr-2">Mulai</span>
                                {{ $event->tgl_mulai ? $event->tgl_mulai->format('d-m-y') : '-' }}
                                <span class="text-xs font-medium text-gray-400 ml-2">({{ substr($event->jam_mulai ?? '-', 0, 5) }})</span>
                            </div>
                            <div class="flex items-center text-sm font-bold text-gray-600">
                                <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded text-[10px] uppercase font-black tracking-wider mr-2">Akhir</span>
                                {{ $event->tgl_selesai ? $event->tgl_selesai->format('d-m-y') : '-' }}
                                <span class="text-xs font-medium text-gray-400 ml-2">({{ substr($event->jam_selesai ?? '-', 0, 5) }})</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2 text-lg text-gray-600 font-medium">
                            <span class="lokasi-acara">{{ $event->lokasi ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="kategori-label font-bold text-gray-700">
                            @if(is_array($event->kategori) || is_object($event->kategori))
                                {{ $event->kategori['nama_kategori'] ?? ($event->kategori->nama_kategori ?? '-') }}
                            @else
                                {{ $event->kategori ?? '-' }}
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="inline-flex items-center justify-center bg-gray-100 px-5 py-3 rounded-md border border-gray-200">
                            <span class="text-lg font-bold text-gray-700">{{ $event->kapasitas ?? 0 }} <span class="text-sm text-gray-400 font-bold uppercase ml-1">Org</span></span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex justify-center items-center gap-3"> 
                            <a href="{{ route('admin.acara.tiket', $event->id_event) }}" style="width: 90px; height: 42px; background-color: #be93d4; color: #24112e; border-radius: 8px; font-size: 13px; font-weight: 900; display: flex; align-items: center; justify-content: center; text-transform: uppercase; text-decoration: none;">TIKET</a>
                            <a href="{{ route('admin.acara.edit', $event->id_event) }}" style="width: 90px; height: 42px; background-color: #24112e; color: white; border-radius: 8px; font-size: 13px; font-weight: 900; display: flex; align-items: center; justify-content: center; text-transform: uppercase; text-decoration: none;">UBAH</a>
                            <form action="{{ route('admin.acara.destroy', $event->id_event) }}" method="POST" class="form-delete" style="margin: 0; padding: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" style="width: 90px; height: 42px; background-color: #e11d1d; color: white; border-radius: 8px; font-size: 13px; font-weight: 900; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; text-transform: uppercase;">HAPUS</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<x-pagination :paginator="$events" />

<script>
    function openModal(imgSrc, caption) {
        document.getElementById('modalImg').src = imgSrc;
        document.getElementById('modalCaption').innerText = caption;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; 
    }

    document.getElementById('imageModal').addEventListener('click', function(e) {
        if(e.target === this) closeModal();
    });

    function confirmDelete(button) {
        const form = button.closest('.form-delete');
        Swal.fire({
            title: 'YAKIN INGIN MENGHAPUS DATA INI?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d1d', 
            cancelButtonColor: '#7a4988',  
            confirmButtonText: 'YA, HAPUS',
            cancelButtonText: 'TIDAK',
            reverseButtons: true,
            customClass: { popup: 'rounded-3xl', title: 'font-black text-lg uppercase tracking-tighter' }
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        })
    }

    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryTerm = filterKategori.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const judul = row.querySelector('.judul-acara').innerText.toLowerCase();
            const lokasi = row.querySelector('.lokasi-acara').innerText.toLowerCase(); 
            const kategori = row.querySelector('.kategori-label').innerText.toLowerCase();
            const matchSearch = judul.includes(searchTerm) || lokasi.includes(searchTerm);
            const matchCategory = categoryTerm === "" || kategori.includes(categoryTerm);
            row.style.display = (matchSearch && matchCategory) ? "" : "none";
        });
    }

    searchInput.addEventListener('keyup', applyFilters);
    filterKategori.addEventListener('change', applyFilters);
    window.addEventListener('DOMContentLoaded', applyFilters);
</script>
@endsection