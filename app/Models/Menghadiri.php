<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menghadiri extends Model
{
    protected $table = 'menghadiri';

    protected $primaryKey = 'id_menghadiri';

    public $timestamps = false;

    protected $fillable = [
        'id_pengunjung',
        'id_event',
        'id_tiket',
        'kode_registrasi',
        'sts_checkin'
    ];

    public function pengunjung()
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