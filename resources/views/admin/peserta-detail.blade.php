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

        {{-- HEADER --}}
        <div class="bg-[#7a4988] p-8 text-white border-b-4 border-[#24112e]">
            <h1 class="text-3xl font-black uppercase">{{ $selectedEvent['judul'] }}</h1>
            <p class="text-purple-200 mt-2 font-medium">{{ $selectedEvent['tanggal'] }}</p>
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
                                <span class="text-sm font-black uppercase">Lihat Anggota ▼</span>
                            </summary>
                            <div class="px-6 pb-6 bg-gray-50">
                                <table class="w-full">
                                    <thead><tr class="bg-[#24112e] text-white uppercase text-xs"><th class="p-4 text-left">Nama</th><th class="p-4 text-left">Kode</th><th class="p-4 text-left">Status</th><th class="p-4 text-center">Aksi</th></tr></thead>
                                    <tbody class="bg-white">
                                        @foreach($tim['anggota'] as $i => $a)
                                        <tr><td class="p-4">{{ $a['nama'] }}</td><td class="p-4"><span class="bg-pink-200 px-3 py-1 rounded font-bold">{{ $a['kode'] }}</span></td><td class="p-4 font-bold">{{ $a['hadir'] ? 'Hadir' : 'Belum' }}</td><td class="p-4 text-center">
                                            <form action="{{ route('admin.peserta.checkin_anggota', [$id, $regId, $i]) }}" method="POST">
                                                @csrf <button class="{{ $a['hadir'] ? 'bg-gray-600' : 'bg-red-600' }} text-white px-4 py-2 rounded text-xs font-bold">{{ $a['hadir'] ? 'Batalkan' : 'Tandai Hadir' }}</button>
                                            </form>
                                        </td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                    </div>
                @endforeach
            @else
                <table class="w-full">
                    <thead><tr class="bg-[#24112e] text-white uppercase text-xs"><th class="p-5 text-left">Nama</th><th class="p-5 text-left">Kode</th><th class="p-5 text-left">Status</th><th class="p-5 text-center">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($selectedEvent['pendaftar'] as $regId => $p)
                        <tr>
                            <td class="p-5 font-bold">{{ $p['nama'] }}</td>
                            <td class="p-5"><span class="bg-pink-200 px-3 py-1 rounded font-bold">{{ $p['kode'] }}</span></td>
                            <td class="p-5 font-bold">{{ $p['hadir'] ? 'Hadir' : 'Belum' }}</td>
                            <td class="p-5 text-center">
                                <form action="{{ route('admin.peserta.checkin_individu', [$id, $regId]) }}" method="POST">
                                    @csrf <button class="{{ $p['hadir'] ? 'bg-gray-600' : 'bg-red-600' }} text-white px-4 py-2 rounded text-xs font-bold">{{ $p['hadir'] ? 'Batalkan' : 'Tandai Hadir' }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>