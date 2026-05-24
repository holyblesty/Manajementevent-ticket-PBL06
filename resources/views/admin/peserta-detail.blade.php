<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peserta - {{ $selectedEvent->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <a href="{{ route('admin.peserta.index') }}" class="mb-4 inline-block text-purple-800 font-bold">&larr; Kembali</a>
        
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-purple-800 p-6 text-white">
                <h1 class="text-2xl font-black uppercase">{{ $selectedEvent->judul }}</h1>
            </div>

            {{-- STATS BAR --}}
            <div class="flex border-b">
                <div class="flex-1 p-6 text-center bg-purple-100"><p class="text-3xl font-bold">{{ $total }}</p><p class="text-xs">TOTAL</p></div>
                <div class="flex-1 p-6 text-center bg-red-100"><p class="text-3xl font-bold">{{ $belumHadir }}</p><p class="text-xs">BELUM</p></div>
                <div class="flex-1 p-6 text-center bg-green-100"><p class="text-3xl font-bold">{{ $hadir }}</p><p class="text-xs">HADIR</p></div>
            </div>

            <div class="p-6">
                @foreach($selectedEvent->registrations as $reg)
                    <div class="mb-6 border p-4 rounded">
                        <h2 class="font-bold text-lg mb-2 uppercase">{{ $reg->nama_tim ?? 'Pendaftar Individu' }}</h2>
                        <table class="w-full text-sm">
                            @foreach($reg->participants as $index => $p)
                                <tr class="border-b">
                                    <td class="p-2">{{ $p->nama }}</td>
                                    <td class="p-2 font-bold">{{ $p->hadir ? 'HADIR' : 'BELUM' }}</td>
                                    <td class="p-2">
                                        <form action="{{ route('admin.peserta.checkin_anggota', [$selectedEvent->id_event, $reg->id_registration, $index]) }}" method="POST">
                                            @csrf
                                            <button class="bg-purple-600 text-white px-3 py-1 rounded text-xs">
                                                {{ $p->hadir ? 'Batalkan' : 'Check-in' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>