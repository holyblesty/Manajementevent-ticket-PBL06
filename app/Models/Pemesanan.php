<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $primaryKey = 'id_pesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_event',
        'id_pengunjung',
        'id_tiket',
        'tgl_pesan',
        'tgl_bayar',
        'metode_pembayaran',
        'total_harga',
        'jumlah_tiket',
        'kode_registrasi',
        'sts_transaksi'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    public static function generateKode(): string
    {
        return 'EVT-' . strtoupper(Str::random(8));
    }

    public function user()
    {
        return $this->belongsTo(
            Pengunjung::class,
            'id_pengunjung',
            'id_pengunjung'
        );
    }

    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }

    public function tiket()
    {
        return $this->belongsTo(
            Tiket::class,
            'id_tiket',
            'id_tiket'
        );
    }
}
