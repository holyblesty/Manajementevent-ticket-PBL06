@extends('layouts.pengunjung')

@section('title', 'Pendaftaran Event')

@section('content')

<div class="container mt-4">

<h2>Pendaftaran Event</h2>


<div class="card p-4">

<h3>
    {{ $event->nama_event }}
</h3>

<p>
Tanggal :
{{ $event->tanggal_event }}
</p>

<p>
Lokasi :
{{ $event->lokasi }}
</p>


<form action="{{ route('pendaftaran.store') }}" method="POST">

@csrf


<input type="hidden"
       name="id_event"
       value="{{ $event->id_event }}">


<div class="mb-3">

<label>
Nama Lengkap
</label>

<input type="text"
       name="nama_pendaftar"
       class="form-control"
       required>

</div>



<div class="mb-3">

<label>Email</label>

<input type="email"
       name="email"
       class="form-control"
       required>

</div>



<div class="mb-3">

<label>No HP</label>

<input type="text"
       name="no_hp"
       class="form-control"
       required>

</div>



<div class="mb-3">

<label>Pilih Tiket</label>

<select name="jenis_tiket"
        class="form-control">

<option value="Early Bird">
    Early Bird
</option>

<option value="VIP">
    VIP
</option>

<option value="Normal">
    Normal
</option>

</select>

</div>



<div class="mb-3">

<label>Jumlah Tiket</label>

<input type="number"
       name="jumlah_tiket"
       value="1"
       min="1"
       class="form-control">

</div>



<button class="btn btn-primary">

Daftar Event

</button>


<a href="{{ url()->previous() }}"
   class="btn btn-danger">

Kembali

</a>


</form>


</div>


</div>

@endsection