<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tiket;
use App\Models\Menghadiri;
use App\Models\Pemesanan;

class Event extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi jamak
    protected $table = 'events';

    // Menentukan Primary Key
    protected $primaryKey = 'id_event';

    // Pastikan timestamps aktif
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'id_kategori',
        'kapasitas',
        'kuota_tersedia',
        'status_event',
        'jenis',
        'poster',
        'id_admin',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriEvent::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke Tiket
    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }

    public function pemesanan()
    {
        // Ini artinya: Event punya banyak tiket, dan setiap tiket punya banyak pesanan
        return $this->hasManyThrough(
            Pemesanan::class, // Target akhir
            Tiket::class,     // Model perantara
            'id_event',       // Foreign key di tabel 'tiket'
            'id_tiket',       // Foreign key di tabel 'pemesanan'
            'id_event',       // Local key di tabel 'events'
            'id_tiket'        // Local key di tabel 'tiket'
        );
    }

    public function participants()
    {
        return $this->hasMany(Menghadiri::class, 'id_event', 'id_event');
    }

    // Accessor untuk total terjual
    public function getTotalTerjualAttribute(): int
    {
        return $this->tiket->sum('terjual');
    }

    // Accessor untuk sisa kapasitas
    public function getSisaKapasitasAttribute(): int
    {
        return $this->kapasitas - $this->total_terjual;
    }

    // Accessor untuk URL Poster
    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? asset('storage/posters/' . $this->poster)
            : asset('images/default-event.jpg');
    }
}
