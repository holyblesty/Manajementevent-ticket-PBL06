<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pesanan'; // Sesuai database admin
    
    // Matikan timestamps jika admin tidak membuat kolom created_at / updated_at
    public $timestamps = false; 

    protected $fillable = [
        'id_event',
        'id_pengunjung',
        'id_tiket', // Menyimpan ID Kategori Tiket (Early Bird / Normal / VIP)
        'tgl_pesan',
        'tgl_bayar',
        'metode_pembayaran',
        'total_harga',
        'jumlah_tiket',
        'kode_registrasi',
        'sts_transaksi'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
}