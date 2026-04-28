@extends('layouts.admin')

@section('content')
<div id="imageModal" class="fixed inset-0 z-[999] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
    <button onclick="closeModal()" class="absolute top-6 right-6 text-white hover:text-red-500 transition-colors">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    <div class="max-w-4xl w-full flex flex-col items-center">
        <img id="modalImg" src="" class="max-h-[80vh] rounded-2xl shadow-2xl border-4 border-white/10 object-contain">
        <p id="modalCaption" class="mt-4 text-white font-black uppercase tracking-[0.3em] text-xs bg-[#7a4988] px-6 py-2 rounded-full"></p>
    </div>
</div>

<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-8 mb-8 text-white shadow-lg flex justify-between items-center">
    <div>
        <h1 class="text-4xl font-black mb-2 uppercase tracking-tighter">DASHBOARD ADMIN</h1>
        <p class="bg-white/20 inline-block px-4 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">Kelola Acara</p>
    </div>
    
    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 p-2 pr-6 rounded-full transition-all group no-underline border border-white/20">
        <div class="w-12 h-12 rounded-full border-2 border-white overflow-hidden shadow-md">
           <img src="{{ asset('images/' . session('admin_foto', 'profile_default.jpg')) }}?v={{ time() }}" 
                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('admin_name', 'Vivian')) }}&color=7a4988&background=ffffff';"
                class="w-full h-full object-cover">
        </div>
        <div class="text-left">
            <p class="text-[10px] font-black uppercase tracking-widest text-[#be93d4] leading-none mb-1">Administrator</p>
            <p class="text-sm font-bold text-white leading-none group-hover:text-[#be93d4] transition-colors">{{ session('admin_name', 'Vivian Sarah Diva Alisianoi') }}</p>
        </div>
    </a>
</div>

<div class="mb-8">
    <a href="{{ route('admin.acara.create') }}" class="inline-flex items-center bg-[#7a4988] hover:bg-[#633a6e] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md no-underline">
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
            <input type="text" id="searchInput" placeholder="Cari otomatis nama event" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#7a4988] outline-none transition">
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
                    <th class="px-6 py-4 text-center">E-Ticket</th>
                    <th class="px-6 py-4">Judul Acara</th>
                    <th class="px-6 py-4">Tanggal Acara</th>
                    <th class="px-6 py-4 text-center">Kategori</th>
                    <th class="px-6 py-4 text-center">Kapasitas</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($events as $event)
                <tr class="hover:bg-gray-50/50 transition duration-300">
                    <td class="px-6 py-4">
                        <div onclick="openModal('{{ asset('images/' . $event->poster) }}', 'Poster: {{ $event->judul }}')" class="w-20 h-12 bg-gray-100 rounded-lg overflow-hidden mx-auto shadow-inner border border-gray-50 cursor-pointer hover:ring-2 hover:ring-[#7a4988] transition-all">
                            <img src="{{ asset('images/' . $event->poster) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($event->desain_tiket)
                            <div onclick="openModal('{{ asset('images/' . $event->desain_tiket) }}', 'E-Ticket: {{ $event->judul }}')" class="w-12 h-8 bg-gray-100 rounded border border-gray-200 overflow-hidden shadow-sm mx-auto cursor-pointer hover:ring-2 hover:ring-[#7a4988] transition-all">
                                <img src="{{ asset('images/' . $event->desain_tiket) }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <span class="text-[8px] font-black text-gray-300 uppercase italic tracking-widest">Belum Ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-sm text-gray-700 judul-acara">{{ $event->judul }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400 font-medium">{{ $event->tanggal }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-4 py-1 bg-[#be93d4]/20 text-[#7a4988] rounded-full text-[10px] font-black uppercase tracking-wider kategori-label">{{ $event->kategori }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center justify-center bg-gray-100 px-3 py-1 rounded-md border border-gray-200">
                            <svg class="w-3 h-3 text-gray-500 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                            <span class="text-xs font-black text-gray-700">{{ $event->kapasitas }} <span class="text-[9px] text-gray-400 font-bold uppercase ml-0.5">Org</span></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2"> 
                            <a href="{{ route('admin.acara.tiket', $event->id) }}" class="no-underline" style="width: 70px; height: 32px; background-color: #be93d4; color: #24112e; border-radius: 9999px; font-size: 9px; font-weight: 900; display: flex; align-items: center; justify-content: center; text-transform: uppercase; letter-spacing: 0.1em;">TIKET</a>
                            <a href="{{ route('admin.acara.edit', $event->id) }}" class="no-underline" style="width: 70px; height: 32px; background-color: #24112e; color: white; border-radius: 9999px; font-size: 9px; font-weight: 900; display: flex; align-items: center; justify-content: center; text-transform: uppercase; letter-spacing: 0.1em;">UBAH</a>
                            <form action="{{ route('admin.acara.destroy', $event->id) }}" method="POST" class="form-delete" style="margin: 0; padding: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" style="width: 70px; height: 32px; background-color: #e11d1d; color: white; border-radius: 9999px; font-size: 9px; font-weight: 900; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 0.1em;">HAPUS</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // FUNGSI MODAL PREVIEW
    function openModal(imgSrc, caption) {
        document.getElementById('modalImg').src = imgSrc;
        document.getElementById('modalCaption').innerText = caption;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Stop scroll
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scroll
    }

    // Close modal kalo klik area gelap
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if(e.target === this) closeModal();
    });

    // FUNGSI SWEETALERT UNTUK HAPUS
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
            customClass: {
                popup: 'rounded-3xl',
                title: 'font-black text-sm uppercase tracking-tighter',
            }
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        })
    }

    // FILTER KATEGORI & SEARCH
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryTerm = filterKategori.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const judul = row.querySelector('.judul-acara').innerText.toLowerCase();
            const kategori = row.querySelector('.kategori-label').innerText.toLowerCase();
            const matchSearch = judul.includes(searchTerm);
            const matchCategory = categoryTerm === "" || kategori.includes(categoryTerm);
            row.style.display = (matchSearch && matchCategory) ? "" : "none";
        });
    }

    searchInput.addEventListener('keyup', applyFilters);
    filterKategori.addEventListener('change', applyFilters);
</script>
@endsection