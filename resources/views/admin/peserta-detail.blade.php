<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="margin: 0; min-height: 100vh; background: linear-gradient(-45deg, #2b1238, #7a4988, #4b1d52, #9e7bb5); background-size: 400% 400%; animation: swush 10s ease infinite;" class="p-6 font-sans antialiased">

<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.peserta.index') }}" class="text-white font-bold mb-4 block hover:underline">&lt; Kembali ke Dashboard</a>
    
    <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
        {{-- Header Event --}}
        <div class="bg-[#4a2e58] p-6 text-white border-b-4 border-[#7a4988]">
            <h1 class="text-xl font-black uppercase">{{ $selectedEvent->judul }}</h1>
            <p class="text-xs text-purple-200 mt-1 uppercase tracking-widest">{{ \Carbon\Carbon::parse($selectedEvent->tgl_mulai)->format('d M Y') }}</p>
        </div>

        {{-- Stats Bar --}}
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
<div class="p-5 bg-gray-100 border-b">

    <form method="GET">

        <div class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari kode registrasi, nama peserta atau email..."
                class="flex-1 border rounded-lg px-4 py-2">

            <button
                class="bg-[#7a4988] text-white px-6 rounded-lg">

                Cari

            </button>

            @if(request('search'))

            <a href="{{ route('admin.peserta.detail',$selectedEvent->id_event) }}"
               class="bg-gray-500 text-white px-6 rounded-lg flex items-center">

                Reset

            </a>

            @endif

        </div>

    </form>

</div>

{{-- Tabel Peserta Individu --}}
<div class="overflow-x-auto">
    <table class="w-full text-xs text-left">
        <thead class="bg-gray-800 text-white uppercase">
            <tr>
                <th class="p-4">Nama Peserta</th>
                <th class="p-4">Kode</th>
                <th class="p-4">Status</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>
       <tbody class="divide-y">

@forelse($selectedEvent->menghadiri as $p)

<tr class="hover:bg-gray-50">

    <td class="p-4">
        <div class="font-bold text-sm">
            {{ $p->pengunjung->name }}
        </div>

        <div class="text-[10px] text-gray-500">
            {{ $p->pengunjung->email }}
        </div>
    </td>

    <td class="p-4 font-mono font-bold text-purple-700">
        {{ $p->kode_registrasi }}
    </td>

    <td class="p-4">
        <span class="{{ $p->sts_checkin == 'sudah'
                ? 'text-green-600'
                : 'text-red-600' }} font-bold">

            {{ $p->sts_checkin == 'sudah'
                ? 'Hadir'
                : 'Belum Hadir' }}

        </span>
    </td>

    <td class="p-4 text-center">

        <form action="{{ route('admin.peserta.checkin_individu', [$selectedEvent->id_event, $p->id_menghadiri]) }}" method="POST">
    @csrf
    @method('PUT')

    <button
        class="{{ ($p->sts_checkin == 'sudah') ? 'bg-gray-500' : 'bg-red-600' }} text-white px-4 py-1 rounded text-[10px] font-bold uppercase hover:opacity-80 transition">
        {{ ($p->sts_checkin == 'sudah') ? 'Batalkan' : 'Tandai Hadir' }}
    </button>
</form>

    </td>

</tr>

@empty

<tr>
    <td colspan="4"
        class="p-6 text-center text-gray-500">
        Belum ada peserta.
    </td>
</tr>

@endforelse

</tbody>
    </table>
</div>
    </div>
</div>

</body>
</html>