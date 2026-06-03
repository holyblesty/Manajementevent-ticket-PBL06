<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tikets';
    protected $primaryKey = 'id_tiket';

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
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
}