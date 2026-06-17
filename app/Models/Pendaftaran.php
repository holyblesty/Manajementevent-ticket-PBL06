<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $primaryKey = 'id_pendaftaran';

    public $timestamps = false;


    protected $fillable = [
        'id_event',
        'nama_pendaftar',
        'email',
        'no_hp',
        'jenis_tiket',
        'jumlah_tiket',
        'tanggal_daftar',
        'status'
    ];


    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
}