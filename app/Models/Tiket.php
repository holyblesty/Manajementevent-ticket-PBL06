<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $table = 'tiket'; 
    public $timestamps = false;
    protected $primaryKey = 'id_tiket';

protected $fillable = [
    'id_event',
    'jenis_tiket',
    'harga',
    'kuota_total',    // Sesuaikan dengan nama di database
    'kuota_tersedia', // Sesuaikan dengan nama di database
];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function pesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_tiket', 'id_tiket');
    }

    public function getSisaAttribute(): int
    {
        return $this->kuota - $this->terjual;
    }

    public function isAvailable(): bool
    {
        return $this->sisa > 0;
    }
}