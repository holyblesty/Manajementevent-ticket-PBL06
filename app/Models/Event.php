<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id_event';
    protected $fillable = ['judul', 'deskripsi', 'tanggal', 'jam', 'lokasi', 'kategori', 'poster', 'status_event', 'id_admin', 'id_kategori'];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriEvent::class, 'id_kategori', 'id_kategori');
    }

    // Relasi: Satu event bisa punya banyak jenis tiket (Regular, VIP, dll)
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }
}