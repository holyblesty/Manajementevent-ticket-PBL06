<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tiket';

<<<<<<< HEAD
    protected $fillable = [
        'id_event',
        'jenis_tiket',
        'harga',
        'kuota',
        'terjual',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
=======
    // Penting: Tambahkan ini jika ID Anda bukan auto-increment
    public $incrementing = true; 

    // Penting: Tambahkan timestamps jika tabel Anda memiliki created_at/updated_at
    // Jika tidak ada kolom tersebut, set ke false
    public $timestamps = false; 

    protected $fillable = [
        'nama_tiket', 
        'harga', 
        'kuota_total', 
        'kuota_tersedia', 
        'id_event'
>>>>>>> 753712b85d573d6b370734fecba1397481f4df9d
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_tiket', 'id_tiket');
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