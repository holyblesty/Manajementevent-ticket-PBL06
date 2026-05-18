<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tikets';
    protected $primaryKey = 'id_tiket';
    protected $fillable = ['nama_tiket', 'harga', 'kuota_total', 'kuota_tersedia', 'id_event'];

    // Relasi balik ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
}