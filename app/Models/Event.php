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
        'kuota_tersedia',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
    ];

    // Hapus 'kapasitas' => 0 dari sini agar tidak memaksa nilai nol saat pembuatan
    protected $attributes = [
        'status_event' => 'open',
    ];

    /**
     * Otomatis sinkronisasi kuota saat Event dibuat
     */
    protected static function booted()
    {
        static::creating(function ($event) {
            // Jika kuota_tersedia kosong, isi otomatis dengan kapasitas
            if (is_null($event->kuota_tersedia)) {
                $event->kuota_tersedia = $event->kapasitas;
            }
        });
    }

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

    // UBAH: Mengarah ke model Pemesanan yang baru
    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_event', 'id_event');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Untuk sisa kuota dinamis)
    |--------------------------------------------------------------------------
    */

    // Menghitung sisa kuota secara real-time dari tabel tiket
    public function getSisaKuotaAttribute(): int
    {
        return $this->tiket()->sum('kuota_tersedia');
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? asset('images/' . $this->poster)
            : asset('images/default-event.jpg');
    }
}
