<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peserta - {{ $selectedEvent['judul'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes swush { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    </style>
</head>
<body style="min-height:100vh; background: linear-gradient(-45deg,#2b1238,#7a4988,#4b1d52,#9e7bb5); background-size:400% 400%; animation: swush 10s ease infinite;" class="font-sans text-gray-900 p-8">

    {{-- KEMBALI --}}
    <div class="max-w-6xl mx-auto mb-8">
        <a href="{{ route('admin.peserta.index') }}" class="text-white font-bold text-lg flex items-center hover:opacity-80">
            <span class="mr-3 text-xl">&larr;</span> Kembali
        </a>
    </div>

    <div class="w-full max-w-6xl mx-auto bg-white shadow-2xl rounded-lg overflow-hidden">
        {{-- FLASH MESSAGE DINAMIS --}}
        @if(session('message'))
            <div class="p-4 border-l-4 font-bold 
                {{ session('status') == 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-yellow-100 border-yellow-500 text-yellow-700' }}">
                {{ session('message') }}
            </div>
        @endif

        {{-- HEADER (Sudah Dinamis Tanggal & Lokasi) --}}
        <div class="bg-[#7a4988] p-8 text-white border-b-4 border-[#24112e]">
            <h1 class="text-3xl font-black uppercase">{{ $selectedEvent['judul'] }}</h1>
            <p class="text-purple-200 mt-2 font-medium">
                {{ $selectedEvent['tanggal'] }} &middot; {{ $selectedEvent['lokasi'] ?? 'Politeknik Negeri Batam' }}
            </p>
        </div>

        {{-- STATS BAR --}}
        <div class="flex w-full border-b border-gray-300">
            <div class="flex-1 bg-[#6b3577] p-8 text-center text-white"><p class="text-5xl font-black">{{ $total }}</p><p class="text-xs font-bold uppercase mt-2">Total</p></div>
            <div class="flex-1 bg-[#d32f2f] p-8 text-center text-white"><p class="text-5xl font-black">{{ $belumHadir }}</p><p class="text-xs font-bold uppercase mt-2">Belum</p></div>
            <div class="flex-1 bg-[#2e7d32] p-8 text-center text-white"><p class="text-5xl font-black">{{ $hadir }}</p><p class="text-xs font-bold uppercase mt-2">Hadir</p></div>
        </div>

        <div class="p-6 bg-[#4a1c54]">
            <input type="text" id="searchInput" placeholder="Cari nama / kode..." class="w-full h-16 px-6 rounded text-lg border outline-none">
        </div>

        <div id="participantList">
            @if(empty($selectedEvent['pendaftar']))
                <div class="p-10 text-center text-gray-500 font-bold">Belum ada peserta yang mendaftar di event ini.</div>
            @elseif($selectedEvent['tipe'] == 'tim')
                @foreach($selectedEvent['pendaftar'] as $regId => $tim)
                    <div class="border-b border-gray-300">
                        <details class="group">
                            <summary class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50">
                                <span class="font-black text-gray-800 uppercase text-lg">{{ $tim['nama_tim'] }}</span>
                                <span class="text-sm font-black text-purple-700 uppercase group-open:hidden">Lihat Anggota ▼</span>
                                <span class="text-sm font-black text-purple-700 uppercase hidden group-open:inline">Tutup Anggota ▲</span>
                            </summary>
                            
                            <div class="px-6 pb-6 bg-gray-50">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-[#24112e] text-white uppercase text-xs">
                                            <th class="p-4 text-left">Nama Anggota</th>
                                            <th class="p-4 text-left">Kode</th>
                                            <th class="p-4 text-left">Status</th>
                                            <th class="p-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach($tim['anggota'] as $i => $a)
                                        <tr class="border-b border-gray-100">
                                            <td class="p-4">
                                                <div class="flex flex-col">
                                                    {{-- Nama Anggota --}}
                                                    <span class="font-bold text-gray-800 flex items-center gap-2">
                                                        {{ $a['nama'] }} 
                                                        @if($i == 0) 
                                                            <span class="text-xs bg-[#ebd9fc] text-[#6119b0] px-2 py-0.5 rounded font-black uppercase">Ketua</span> 
                                                        @endif
                                                    </span>
                                                    
                                                    {{-- Khusus Ketua (Index 0) yang menampilkan Email, Instansi, dan Kontak --}}
                                                    @if($i == 0)
                                                        @if(!empty($a['email']))
                                                            <span class="text-xs text-gray-500 mt-1">📧 {{ $a['email'] }}</span>
                                                        @endif
                                                        @if(!empty($a['instansi']))
                                                            <span class="text-xs text-gray-400">🏢 {{ $a['instansi'] }}</span>
                                                        @endif
                                                        @if(!empty($a['kontak']))
                                                            <div class="flex items-center gap-2 mt-2">
                                                                <span class="text-xs text-gray-700 font-bold">📞 {{ $a['kontak'] }}</span>
                                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $a['kontak']) }}" target="_blank" class="bg-[#1ebd62] hover:bg-[#12c868] text-white font-bold text-[10px] px-2 py-0.5 rounded flex items-center gap-0.5 transition-all" title="Hubungi Ketua via WhatsApp">
                                                                    💬 WA
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-4"><span class="bg-pink-200 px-3 py-1 rounded font-bold text-sm text-pink-800">{{ $a['kode'] }}</span></td>
                                            <td class="p-4 font-bold text-sm {{ $a['hadir'] ? 'text-green-600' : 'text-red-600' }}">{{ $a['hadir'] ? 'Hadir' : 'Belum' }}</td>
                                            <td class="p-4 text-center">
                                                <form action="{{ route('admin.peserta.checkin_anggota', [$id, $regId, $i]) }}" method="POST">
                                                    @csrf 
                                                    <button class="{{ $a['hadir'] ? 'bg-gray-600 hover:bg-gray-700' : 'bg-[#7a4988] hover:bg-[#61346e]' }} text-white px-4 py-2 rounded text-xs font-bold transition-colors">
                                                        {{ $a['hadir'] ? 'Batalkan' : 'Tandai Hadir' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                    </div>
                @endforeach
            @else
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#24112e] text-white uppercase text-xs">
                            <th class="p-5 text-left">Nama & Profil</th>
                            <th class="p-5 text-left">Kode</th>
                            <th class="p-5 text-left">No. HP / WA</th>
                            <th class="p-5 text-left">Status</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($selectedEvent['pendaftar'] as $regId => $p)
                        <tr>
                            <td class="p-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 text-base">{{ $p['nama'] }}</span>
                                    {{-- Profil Lengkap Pengunjung Individu --}}
                                    <span class="text-xs text-gray-500 mt-1">📧 {{ $p['email'] ?? 'peserta@gmail.com' }}</span>
                                    <span class="text-xs text-gray-400">🏢 {{ $p['instansi'] ?? 'Politeknik Negeri Batam' }}</span>
                                </div>
                            </td>
                            <td class="p-5"><span class="bg-pink-200 px-3 py-1 rounded font-bold text-sm text-pink-800">{{ $p['kode'] }}</span></td>
                            <td class="p-5">
                                {{-- Kontak Individu --}}
                                @if(!empty($p['kontak']))
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-700 font-medium text-sm">{{ $p['kontak'] }}</span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p['kontak']) }}" target="_blank" class="bg-[#1ebd62] hover:bg-[#12c868] text-white px-2 py-1 rounded text-xs font-bold flex items-center gap-1 transition-colors" title="Hubungi via WhatsApp">
                                            💬 WA
                                        </a>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic text-sm">-</span>
                                @endif
                            </td>
                            <td class="p-5 font-bold text-sm {{ $p['hadir'] ? 'text-green-600' : 'text-red-600' }}">{{ $p['hadir'] ? 'Hadir' : 'Belum' }}</td>
                            <td class="p-5 text-center">
                                <form action="{{ route('admin.peserta.checkin_individu', [$id, $regId]) }}" method="POST">
                                    @csrf 
                                    <button class="{{ $p['hadir'] ? 'bg-gray-600 hover:bg-gray-700' : 'bg-[#7a4988] hover:bg-[#61346e]' }} text-white px-4 py-2 rounded text-xs font-bold transition-colors">
                                        {{ $p['hadir'] ? 'Batalkan' : 'Tandai Hadir' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- PAGINATION --}}
        <div class="bg-white px-10 py-8 flex justify-center border-t border-gray-100">
            @include('components.pagination')
        </div>
    </div>
</body>
</html>