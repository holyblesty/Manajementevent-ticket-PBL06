<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = ['tgl_pesan', 'tgl_bayar', 'metode_pembayaran', 'total_harga', 'jumlah_tiket', 'kode_registrasi', 'sts_transaksi', 'id_pengunjung'];

    // Relasi ke User (Pengunjung yang beli)
    public function pengunjung()
    {
        return $this->belongsTo(User::class, 'id_pengunjung', 'id');
    }

    // Relasi ke Detail Pesanan
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }
}