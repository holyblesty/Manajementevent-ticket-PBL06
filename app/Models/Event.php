<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tiket; // Pastikan ini di-import
use App\Models\Registration; // Pastikan ini di-import

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_event';
<<<<<<< HEAD

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'kategori',
        'kapasitas',
        'jenis',
        'poster',
        'desain_tiket',
        'gambar',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_event', 'id_event');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'id_event', 'id_event');
    }

    public function getTotalTerjualAttribute(): int
    {
        return $this->tikets->sum('terjual');
    }

    public function getSisaKapasitasAttribute(): int
    {
        return $this->kapasitas - $this->total_terjual;
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? asset('storage/posters/' . $this->poster)
            : asset('images/default-event.jpg');
=======
    
protected $fillable = [
    'judul', 'deskripsi', 'tanggal', 'waktu_acara', 'lokasi', 
    'kategori', 'kapasitas', 'kuota_tersedia', 'poster', 
    'desain_tiket', 'id_admin', 'status_event'
];

    public function tiket() {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }

    public function registrations() {
        return $this->hasMany(Registration::class, 'id_event', 'id_event');
    }

    public function getTotalPendaftarAttribute() {
        return $this->registrations()->count();
    }

    public function getIsFullAttribute() {
        return $this->total_pendaftar >= $this->kapasitas;
>>>>>>> 753712b85d573d6b370734fecba1397481f4df9d
    }
}