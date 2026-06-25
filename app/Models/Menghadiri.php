<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menghadiri extends Model
{
    // Tentukan nama tabel jika tidak mengikuti konvensi jamak (opsional)
    protected $table = 'menghadiri';

    // Tentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'id_user', 
        'id_event', 
        'status_kehadiran', // misal: 'hadir', 'tidak hadir'
        'waktu_check_in'
    ];

    // Definisikan relasi ke User
    public function user()
    {
        return $this->belongsTo(Pengunjung::class, 'id_user');
    }

    // Definisikan relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
}