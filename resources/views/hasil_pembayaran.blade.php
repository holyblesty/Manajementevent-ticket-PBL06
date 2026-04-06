h1>Hasil Pembayaran</h1>

<p>Metode : {{ $metode }}</p>

@if($status == 'berhasil')
<h2 style="color:green;">Pembayaran Berhasil</h2>
@endif

@if($status == 'pending')
<h2 style="color:orange;">Pembayaran Pending</h2>
@endif

@if($status == 'gagal')
<h2 style="color:red;">Pembayaran Gagal</h2>
@endif

<br>

<a href="/dashboard-pengunjung">Kembali ke Dashboard</a>