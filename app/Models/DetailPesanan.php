<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    // ======================================================
    // NAMA TABEL
    // ======================================================
    protected $table = 'detail_pesanan';

    // ======================================================
    // PRIMARY KEY
    // ======================================================
    protected $primaryKey = 'id_detail';

    // ======================================================
    // FIELD YANG BOLEH DIISI
    // ======================================================
    protected $fillable = [

        'id_pesanan',
        'id_tiket',
        'subtotal_harga',
        'jumlah_beli',
        'status_checkin'

    ];

    // ======================================================
    // TYPE DATA BOOLEAN
    // ======================================================
    protected $casts = [

        'status_checkin' => 'boolean'

    ];

    // ======================================================
    // RELASI KE PESANAN
    // ======================================================
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // ======================================================
    // RELASI KE TIKET
    // ======================================================
    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket');
    }
}