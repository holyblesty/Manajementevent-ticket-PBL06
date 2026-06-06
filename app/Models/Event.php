<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tiket;
use App\Models\Menghadiri; // Menggunakan model Menghadiri sebagai ganti Participant
use App\Models\Pesanan;

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
        'id_kategori', // Diperbarui dari 'kategori' menjadi 'id_kategori'
        'kapasitas',
        'jenis',
        'poster',
        'desain_tiket',
        'gambar',
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
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }

    // Relasi ke Pesanan
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_event', 'id_event');
    }

    // Relasi ke Menghadiri (sebagai pengganti Participant)
    public function participants()
    {
        return $this->hasMany(Menghadiri::class, 'id_event', 'id_event');
    }

    // Accessor untuk total terjual
    public function getTotalTerjualAttribute(): int
    {
        return $this->tikets->sum('terjual');
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