<h1>SIMULASI PEMBAYARAN</h1>

<h3>Total : Rp 50.000</h3>

<form action="/pembayaran/proses" method="POST">
@csrf

<h4>Metode Pembayaran</h4>

<input type="radio" name="metode" value="Transfer Bank"> Transfer Bank <br>
<input type="radio" name="metode" value="QRIS"> QRIS <br>
<input type="radio" name="metode" value="E-Wallet"> E-Wallet <br><br>

<hr>

<h4>Transfer Dummy</h4>

<p>BCA : 1234567890</p>
<p>A/N EVENT</p>

<br>

<h4>Pilih Status Simulasi</h4>

<button type="submit" name="status" value="berhasil">
✔️ Berhasil
</button>

<button type="submit" name="status" value="pending">
⏳ Pending
</button>

<button type="submit" name="status" value="gagal">
❌ Gagal
</button>

</form>
