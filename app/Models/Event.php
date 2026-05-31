<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id_event';
    
    // Sesuaikan dengan nama kolom di database kamu
    protected $fillable = [
        'judul', 'deskripsi', 'tanggal', 'lokasi', 'kategori', 
        'kapasitas', 'jenis', 'poster' , 'desain_tiket'
    ];

    // Relasi ke registrasi (pastikan nama model Registration sudah ada)
    public function registrations() {
        return $this->hasMany(Registration::class, 'id_event', 'id_event');
    }

    // Hitung total pendaftar otomatis
    public function getTotalPendaftarAttribute() {
        return $this->registrations()->count();
    }

    // Cek status penuh otomatis
    public function getIsFullAttribute() {
        return $this->total_pendaftar >= $this->kapasitas;
    }
}