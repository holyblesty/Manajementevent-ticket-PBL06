@extends('layouts.admin')

@section('content')
<div class="w-full bg-gradient-to-r from-[#24112e] to-[#7a4988] rounded-2xl p-8 mb-8 text-white shadow-lg flex justify-between items-center">
    <div>
        <h1 class="text-4xl font-black mb-2 uppercase tracking-tighter leading-none">KELOLA PESERTA</h1>
        <p class="bg-white/20 inline-block px-4 py-1 rounded text-xs font-bold uppercase tracking-widest text-white mt-1">
            {{ isset($selectedEvent) ? 'Detail: ' . $selectedEvent['judul'] : 'Manajemen Kehadiran & Check-In' }}
        </p>
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

@if(!isset($selectedEvent))
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative w-full md:w-96 text-[#7a4988]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="eventSearch" placeholder="Cari nama event..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#7a4988] outline-none transition">
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">Pilih event untuk kelola kehadiran</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#7a4988] text-white text-sm uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-5 text-center">Poster</th>
                        <th class="px-6 py-4">Judul Event</th>
                        <th class="px-6 py-4 text-center">Tipe</th>
                        <th class="px-6 py-4 text-center">Total Pendaftar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="eventTableBody" class="divide-y divide-gray-100">
                    @foreach($dataRegistrasi as $id => $event)
                    <tr class="hover:bg-gray-50/50 transition duration-300 event-row">
                        <td class="px-6 py-4">
                            <div class="w-24 h-16 bg-gray-100 rounded-lg overflow-hidden mx-auto border border-gray-50">
                                @php
                                    $posters = [1 => 'basket.png', 2 => 'musik.png', 3 => 'futsal.jpg', 4 => 'seminar.jpg'];
                                    $namaFile = $posters[$id] ?? 'default.jpg';
                                @endphp
                                <img src="{{ asset('images/' . $namaFile) }}" onerror="this.src='https://ui-avatars.com/api/?name=Event&color=7a4988&background=efefef';" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <h3 class="font-bold text-base text-gray-800 search-event-name uppercase">{{ $event['judul'] }}</h3>
                            <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">ID Event: #0{{ $id }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-4 py-1 {{ $event['tipe'] == 'tim' ? 'bg-blue-100 text-blue-600' : 'bg-[#be93d4]/20 text-[#7a4988]' }} rounded-full text-[10px] font-black uppercase tracking-wider">
                                {{ $event['tipe'] == 'tim' ? 'KELOMPOK' : 'INDIVIDU' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-gray-700">{{ count($event['pendaftar']) }} Org</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="?event_id={{ $id }}" class="no-underline inline-flex items-center justify-center" style="width: 100px; height: 36px; background-color: #24112e; color: white; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em;">PILIH</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="flex flex-col md:flex-row items-center gap-4 mb-8">
        <a href="{{ route('admin.peserta.index') }}" class="inline-flex items-center bg-[#7a4988] hover:bg-[#633a6e] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md no-underline">
            ← KEMBALI
        </a>
        <div class="relative flex-grow text-[#7a4988]">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" id="participantSearch" placeholder="Cari nama peserta atau ID..." class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-1 focus:ring-[#7a4988] outline-none shadow-sm transition">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#7a4988] text-white text-sm uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-5 text-center">ID Reg</th>
                        <th class="px-6 py-4">Nama Peserta / Tim</th>
                        <th class="px-6 py-4 text-center">Detail</th>
                        <th class="px-6 py-4 text-center">Aksi Kehadiran</th>
                    </tr>
                </thead>
                <tbody id="participantTableBody" class="divide-y divide-gray-100">
                    @foreach ($selectedEvent['pendaftar'] as $regId => $p)
                    <tr class="participant-row hover:bg-gray-50/50 transition duration-300">
                        <td class="px-6 py-4 font-bold text-sm text-gray-400 text-center search-id">#{{ $regId }}</td>
                        <td class="px-6 py-4 search-nama">
                            <p class="font-bold text-base text-gray-800 uppercase leading-none">{{ $selectedEvent['tipe'] == 'tim' ? $p['nama_tim'] : $p['nama'] }}</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p['kontak']) }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#7a4988] mt-2 uppercase tracking-widest no-underline">
                                📞 {{ $p['kontak'] }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                                {{ $selectedEvent['tipe'] == 'tim' ? count($p['anggota']).' ANGGOTA' : 'PERSONEL' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                @if($selectedEvent['tipe'] == 'tim')
                                    <button onclick="toggleAccordion('{{ $regId }}')" class="inline-flex items-center justify-center" style="width: 140px; height: 38px; background-color: #24112e; color: white; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: none; cursor: pointer; letter-spacing: 0.05em;">LIHAT ANGGOTA</button>
                                @else
                                    <form action="{{ route('admin.peserta.checkin_individu', [request('event_id'), $regId]) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="transition-all flex items-center justify-center gap-2" 
                                            style="width: 160px; height: 38px; background-color: {{ $p['hadir'] ? '#10b981' : '#e11d1d' }}; color: white; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: none; cursor: pointer; letter-spacing: 0.05em;">
                                            @if($p['hadir'])
                                                <span>✅ BATAL HADIR</span>
                                            @else
                                                <span>🔴 TANDAI HADIR</span>
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    @if($selectedEvent['tipe'] == 'tim')
                    <tr id="details-{{ $regId }}" class="hidden bg-gray-50/50 shadow-inner">
                        <td colspan="4" class="px-10 py-6">
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                <div class="bg-gray-100 px-6 py-3 text-[10px] font-black uppercase text-gray-500 tracking-widest border-b border-gray-200">Daftar Anggota Kelompok</div>
                                @foreach($p['anggota'] as $idx => $angg)
                                <div class="flex items-center justify-between p-5 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 transition">
                                    <div>
                                        <p class="text-base font-bold text-gray-800 uppercase leading-none">{{ $angg['nama'] }}</p>
                                        <p class="text-[9px] font-bold text-[#7a4988] uppercase mt-1 italic">{{ $angg['kode'] }}</p>
                                    </div>
                                    <form action="{{ route('admin.peserta.checkin_anggota', [request('event_id'), $regId, $idx]) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="transition-all font-black text-[10px] uppercase cursor-pointer" 
                                            style="width: 120px; height: 34px; border-radius: 6px; border: 2px solid {{ $angg['hadir'] ? '#10b981' : '#ef4444' }}; background-color: {{ $angg['hadir'] ? '#d1fae5' : 'transparent' }}; color: {{ $angg['hadir'] ? '#065f46' : '#ef4444' }};">
                                            {{ $angg['hadir'] ? '✅ HADIR' : '🔴 HADIR?' }}
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<script>
    // Pencarian Event
    const es = document.getElementById('eventSearch');
    if(es) es.addEventListener('keyup', function() {
        const t = this.value.toLowerCase();
        document.querySelectorAll('.event-row').forEach(r => {
            const n = r.querySelector('.search-event-name').innerText.toLowerCase();
            r.style.display = n.includes(t) ? "" : "none";
        });
    });

    // Pencarian Peserta
    const ps = document.getElementById('participantSearch');
    if(ps) ps.addEventListener('keyup', function() {
        const t = this.value.toLowerCase();
        document.querySelectorAll('.participant-row').forEach(r => {
            const n = r.querySelector('.search-nama').innerText.toLowerCase();
            const i = r.querySelector('.search-id').innerText.toLowerCase();
            r.style.display = (n.includes(t) || i.includes(t)) ? "" : "none";
        });
    });

    function toggleAccordion(id) {
        const row = document.getElementById('details-' + id);
        row.classList.toggle('hidden');
    }
</script>
@endsection