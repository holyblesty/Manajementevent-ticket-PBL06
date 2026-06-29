<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Event extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE CONFIGURATION
    |--------------------------------------------------------------------------
    */

    // Nama tabel yang digunakan model ini
    protected $table = 'events';

    // Primary key tabel events
    protected $primaryKey = 'id_event';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    // Field yang boleh diisi secara mass assignment
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
        'harga_tiket',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    // Konversi otomatis tipe data dari database
    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTE VALUE
    |--------------------------------------------------------------------------
    */

    // Nilai default jika status_event tidak diisi
    protected $attributes = [
        'status_event' => 'open',
    ];

    /*
    |--------------------------------------------------------------------------
    | MODEL BOOTING (EVENT MODEL LIFECYCLE)
    |--------------------------------------------------------------------------
    */

    /**
     * Event lifecycle hook saat data akan dibuat
     * Digunakan untuk sinkronisasi data otomatis sebelum insert ke database
     */
    protected static function booted()
    {
        static::creating(function ($event) {

            // Jika kuota tersedia belum diisi, otomatis disamakan dengan kapasitas
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

    /**
     * Relasi: Event dimiliki oleh satu kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriEvent::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi: Event memiliki banyak tiket
     */
    public function tiket(): HasMany
    {
        return $this->hasMany(Tiket::class, 'id_event', 'id_event');
    }

    /**
     * Relasi: Event memiliki banyak pemesanan (booking/registrasi)
     */
    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_event', 'id_event');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (DATA TURUNAN / VIRTUAL ATTRIBUTE)
    |--------------------------------------------------------------------------
    */

    /**
     * Menghitung total sisa kuota event secara real-time
     * diambil dari total kuota pada tabel tiket
     */
    public function getSisaKuotaAttribute(): int
    {
        return $this->tiket()->sum('kuota_tersedia');
    }

    /**
     * Menghasilkan URL lengkap untuk poster event
     * jika tidak ada poster, gunakan default image
     */
    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? asset('images/' . $this->poster)
            : asset('images/default-event.jpg');
    }
}
