@extends('layouts.pengunjung')

@section('content')

<div class="container mx-auto px-4 py-6">

```
<h1 class="text-2xl font-bold mb-6">
    Riwayat Pendaftaran Event
</h1>

@if(session('success'))

    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>

@endif

<div class="bg-white rounded-lg shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>
                <th class="p-3 text-left">Kode</th>
                <th class="p-3 text-left">Event</th>
                <th class="p-3 text-left">Tiket</th>
                <th class="p-3 text-left">Jumlah</th>
                <th class="p-3 text-left">Total</th>
                <th class="p-3 text-left">Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse($riwayat as $item)

                <tr class="border-b">

                    <td class="p-3">
                        {{ $item->kode_registrasi }}
                    </td>

                    <td class="p-3">
                        {{ $item->event->judul }}
                    </td>

                    <td class="p-3">
                        {{ $item->tiket->jenis_tiket }}
                    </td>

                    <td class="p-3">
                        {{ $item->jumlah_tiket }}
                    </td>

                    <td class="p-3">
                        Rp {{ number_format($item->total_harga,0,',','.') }}
                    </td>

                    <td class="p-3">
                        {{ $item->sts_transaksi }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="p-6 text-center">
                        Belum ada riwayat pendaftaran.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>
```

</div>

@endsection
