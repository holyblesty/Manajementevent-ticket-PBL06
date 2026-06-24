<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id_event';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tgl_mulai',
        'tgl_selesai',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'id_kategori',
        'status_event',
        'poster',
        'id_admin',
        'kapasitas',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
        // 'jam_mulai' dan 'jam_selesai' tidak perlu di-cast jika formatnya H:i:s di DB
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriEvent::class, 'id_kategori', 'id_kategori');
    }

    public function tiket(): HasMany
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }

    public function pemesanan(): HasManyThrough
    {
        return $this->hasManyThrough(Pemesanan::class, Tiket::class, 'id_event', 'id_tiket', 'id_event', 'id_tiket');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Menghadiri::class, 'id_event', 'id_event');
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'id_event', 'id_event');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? asset('images/' . $this->poster)
            : asset('images/default-event.jpg');
    }
}
