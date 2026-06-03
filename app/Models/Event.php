<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tiket; // Pastikan ini di-import
use App\Models\Registration; // Pastikan ini di-import

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id_event';
    
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
    }
}