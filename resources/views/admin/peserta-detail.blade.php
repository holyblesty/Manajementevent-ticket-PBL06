<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes swush { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="p-6 font-sans antialiased">

<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.peserta.index') }}" class="text-white font-bold mb-4 block hover:underline">&lt; Kembali ke Dashboard</a>
    
    <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
        {{-- Header Event --}}
        <div class="bg-[#4a2e58] p-6 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-xl font-black uppercase">{{ $selectedEvent->judul }}</h1>
            <p class="text-xs text-purple-200 mt-1 uppercase tracking-widest">{{ \Carbon\Carbon::parse($selectedEvent->tanggal)->format('d M Y') }} · {{ $selectedEvent->lokasi }}</p>
        </div>

        {{-- Stats Bar (Rapat 100%) --}}
        <div class="flex">
            <div class="flex-1 p-4 text-center bg-[#4a2e58] text-white font-bold">
                <p class="text-2xl font-black">{{ $total }}</p>
                <p class="text-[9px] uppercase tracking-widest">TOTAL PESERTA</p>
            </div>
            <div class="flex-1 p-4 text-center bg-red-600 text-white font-bold">
                <p class="text-2xl font-black">{{ $belumHadir }}</p>
                <p class="text-[9px] uppercase tracking-widest">BELUM HADIR</p>
            </div>
            <div class="flex-1 p-4 text-center bg-green-700 text-white font-bold">
                <p class="text-2xl font-black">{{ $hadir }}</p>
                <p class="text-[9px] uppercase tracking-widest">SUDAH HADIR</p>
            </div>
        </div>

        {{-- Search --}}
        <div class="p-4 bg-gray-100 border-b">
            <input type="text" placeholder="Cari nama / kode / tiket" class="w-full p-2 border rounded text-sm outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        {{-- List Accordion --}}
        <div class="divide-y">
            @foreach($selectedEvent->registrations as $reg)
                <div x-data="{ open: false }" class="bg-white">
                    <div @click="open = !open" class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-50 border-b">
                        <div class="flex items-center gap-4">
                            <h2 class="font-bold text-sm uppercase">{{ $reg->nama_tim ?? 'Pendaftar Individu' }}</h2>
                            <span class="text-[10px] text-gray-500">{{ $reg->participants->count() }} Anggota</span>
                            <div class="flex gap-1">
                                <span class="bg-green-600 text-white text-[9px] px-2 py-0.5 rounded">{{ $reg->participants->where('hadir', 1)->count() }} Hadir</span>
                                <span class="bg-red-600 text-white text-[9px] px-2 py-0.5 rounded">{{ $reg->participants->where('hadir', 0)->count() }} Belum</span>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400" x-text="open ? '˄' : '˅'"></span>
                    </div>

                    {{-- Tabel Detail --}}
                    <div x-show="open" x-cloak class="bg-gray-50">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-gray-800 text-white uppercase">
                                <tr>
                                    <th class="p-3">Nama Peserta</th>
                                    <th class="p-3">Kode Peserta</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($reg->participants as $index => $p)
                                    <tr class="border-b">
                                        <td class="p-3">
                                            <div class="font-bold">{{ $p->nama }}</div>
                                            <div class="text-[10px] text-gray-500">📞 {{ $p->no_hp ?? '-' }} | 📍 {{ $p->alamat ?? '-' }}</div>
                                        </td>
                                        <td class="p-3"><span class="bg-pink-100 text-pink-700 px-2 py-1 rounded font-bold">BSKT-{{ $index + 1 }}</span></td>
                                        <td class="p-3">{{ $p->hadir ? 'Hadir' : 'Belum Hadir' }}</td>
                                        <td class="p-3 text-center">
                                            <form action="{{ route('admin.peserta.checkin_anggota', [$selectedEvent->id_event, $reg->id_registration, $index]) }}" method="POST">
                                                @csrf
                                                <button class="{{ $p->hadir ? 'bg-gray-600' : 'bg-red-600' }} text-white px-3 py-1 rounded text-[10px] font-bold uppercase">
                                                    {{ $p->hadir ? 'Batalkan' : 'Tandai Hadir' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

</body>
</html>