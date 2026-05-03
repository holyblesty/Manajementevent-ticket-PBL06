<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta - {{ $selectedEvent['judul'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes swush {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        summary { list-style: none; }
        summary::-webkit-details-marker { display: none; }
    </style>
</head>
<body style="margin:0; min-height:100vh; background: linear-gradient(-45deg,#2b1238,#7a4988,#4b1d52,#9e7bb5); background-size:400% 400%; animation: swush 10s ease infinite;" class="font-sans text-gray-900 p-8">

    {{-- KEMBALI --}}
    <div class="max-w-6xl mx-auto mb-8">
        <a href="{{ route('admin.peserta.index') }}" class="text-white font-bold text-lg flex items-center hover:opacity-80 no-underline">
            <span class="mr-3 text-xl">&larr;</span> Kembali
        </a>
    </div>

    {{-- CARD UTAMA --}}
    <div class="w-full max-w-6xl mx-auto bg-white shadow-2xl rounded-lg overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-[#7a4988] p-8 text-white border-b-4 border-[#24112e]">
            <h1 class="text-3xl font-black uppercase tracking-tight">{{ $selectedEvent['judul'] }}</h1>
            <p class="text-base text-purple-200 mt-2 font-medium">{{ $selectedEvent['tanggal'] }} • Lapangan Bola Politeknik Batam</p>
        </div>

        {{-- STATS BAR --}}
        <div class="flex w-full border-b border-gray-300">
            <div class="flex-1 bg-[#6b3577] p-8 text-center border-r border-[#8d6796] text-white">
                <p class="text-5xl font-black">{{ $total }}</p>
                <p class="text-xs font-bold uppercase tracking-widest mt-2">Total peserta</p>
            </div>
            <div class="flex-1 bg-[#d32f2f] p-8 text-center border-r border-[#e06666] text-white">
                <p class="text-5xl font-black">{{ $belumHadir }}</p>
                <p class="text-xs font-bold uppercase tracking-widest mt-2">Belum Hadir</p>
            </div>
            <div class="flex-1 bg-[#2e7d32] p-8 text-center text-white">
                <p class="text-5xl font-black">{{ $hadir }}</p>
                <p class="text-xs font-bold uppercase tracking-widest mt-2">Sudah Hadir</p>
            </div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="p-6 bg-[#4a1c54]">
            <input type="text" id="searchInput" placeholder="Cari nama / kode / tiket" 
                   class="w-full h-16 px-6 rounded text-lg border border-gray-400 outline-none">
        </div>

        {{-- AREA KONTEN --}}
        <div id="participantList">
            @if($selectedEvent['tipe'] == 'tim')
                @foreach($selectedEvent['pendaftar'] as $regId => $tim)
                    @php
                        $sudah = collect($tim['anggota'])->where('hadir', true)->count();
                        $belum = count($tim['anggota']) - $sudah;
                    @endphp
                    <div class="border-b border-gray-300">
                        <details class="group">
                            <summary class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50 transition">
                                <div class="flex items-center gap-6">
                                    <span class="font-black text-gray-800 uppercase text-lg">{{ $tim['nama_tim'] }}</span>
                                    <span class="text-sm text-gray-500 font-bold">{{ count($tim['anggota']) }} anggota</span>
                                    <span class="bg-green-600 text-white text-xs px-4 py-1 rounded font-bold">{{ $sudah }} Hadir</span>
                                    <span class="bg-red-600 text-white text-xs px-4 py-1 rounded font-bold">{{ $belum }} Belum</span>
                                </div>
                                <span class="text-sm text-gray-500 font-black uppercase">Lihat Anggota ▼</span>
                            </summary>
                            
                            <div class="px-6 pb-6 bg-gray-50 border-t border-gray-200">
                                <table class="w-full text-base">
                                    <thead>
                                        <tr class="bg-[#24112e] text-white uppercase text-xs">
                                            <th class="p-4 text-left">Nama Peserta</th>
                                            <th class="p-4 text-left">Kode peserta</th>
                                            <th class="p-4 text-left">Status</th>
                                            <th class="p-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach($tim['anggota'] as $i => $a)
                                        <tr class="border-b border-gray-200">
                                            <td class="p-4 font-medium">{{ $a['nama'] }}</td>
                                            <td class="p-4"><span class="bg-pink-200 text-pink-900 px-4 py-1 rounded font-bold uppercase text-sm">{{ $a['kode'] }}</span></td>
                                            <td class="p-4 font-bold text-gray-700">{{ $a['hadir'] ? 'Hadir' : 'Belum hadir' }}</td>
                                            <td class="p-4 text-center">
                                                <form action="{{ route('admin.peserta.checkin_anggota', [$id, $regId, $i]) }}" method="POST">
                                                    @csrf
                                                    <button class="{{ $a['hadir'] ? 'bg-gray-600' : 'bg-red-600' }} text-white px-6 py-3 font-bold uppercase text-xs rounded hover:opacity-90">
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
                <table class="w-full text-base border-collapse">
                    <thead>
                        <tr class="bg-[#24112e] text-white uppercase text-xs">
                            <th class="p-5 text-left">Nama Peserta</th>
                            <th class="p-5 text-left">Kode peserta</th>
                            <th class="p-5 text-left">Status</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($selectedEvent['pendaftar'] as $regId => $p)
                        <tr>
                            <td class="p-5 font-bold text-gray-800">{{ $p['nama'] }}</td>
                            <td class="p-5"><span class="bg-pink-200 text-pink-900 px-4 py-1 rounded font-bold uppercase text-sm">{{ $p['kode'] }}</span></td>
                            <td class="p-5 font-bold text-gray-700">{{ $p['hadir'] ? 'Hadir' : 'Belum hadir' }}</td>
                            <td class="p-5 text-center">
                                <form action="{{ route('admin.peserta.checkin_individu', [$id, $regId]) }}" method="POST">
                                    @csrf
                                    <button class="{{ $p['hadir'] ? 'bg-gray-600' : 'bg-red-600' }} text-white px-6 py-3 font-bold uppercase text-xs rounded hover:opacity-90">
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
        @include('components.pagination')

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll('#participantList > div, tbody tr').forEach(el => {
                el.style.display = el.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>