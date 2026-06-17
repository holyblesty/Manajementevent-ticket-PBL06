<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $primaryKey = 'id_event';

    public $timestamps = true;

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
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    protected static function booted()
    {
        static::addGlobalScope('order_by_date', function ($builder) {
            $builder->orderBy('tgl_mulai', 'asc');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function kategori()
    {
        return $this->belongsTo(
            KategoriEvent::class,
            'id_kategori',
            'id_kategori'
        );
    }

    public function tiket()
    {
        return $this->hasMany(
            Tiket::class,
            'id_event',
            'id_event'
        );
    }

    public function pemesanan()
    {
        return $this->hasManyThrough(
            Pemesanan::class,
            Tiket::class,
            'id_event',
            'id_tiket',
            'id_event',
            'id_tiket'
        );
    }

    public function participants()
    {
        return $this->hasMany(
            Menghadiri::class,
            'id_event',
            'id_event'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    // Total tiket yang masih tersedia
    public function getKuotaAktualAttribute(): int
    {
        return (int) $this->tiket()->sum('kuota_tersedia');
    }

    // Total tiket terjual
    public function getTotalTerjualAttribute(): int
    {
        return (int) $this->tiket()->sum('terjual');
    }

    // Sisa kapasitas event
    public function getSisaKapasitasAttribute(): int
    {
        return $this->kuota_aktual;
    }

    // URL Poster
    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? asset('images/' . $this->poster)
            : asset('images/default-event.jpg');
    }

    //pendaftaran
     public function pendaftaran()
    {
        return $this->hasMany(
            Pendaftaran::class,
            'id_event',
            'id_event'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | STATUS EVENT OTOMATIS
    |--------------------------------------------------------------------------
    */

    public function getStatusEventAttribute(?string $value): string
    {
        $tanggalSelesai = $this->tgl_selesai
            ? $this->tgl_selesai->format('Y-m-d')
            : null;

        $jamSelesai = $this->jam_selesai;

        if ($tanggalSelesai && $jamSelesai) {
            $waktuAkhirEvent = Carbon::parse(
                $tanggalSelesai . ' ' . $jamSelesai
            );

            if (Carbon::now()->greaterThan($waktuAkhirEvent)) {
                return 'closed';
            }
        }

        return $value;
    }
}