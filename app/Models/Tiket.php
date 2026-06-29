<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tiket extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'tiket';

    // Primary key
    protected $primaryKey = 'id_tiket';

    // Tidak menggunakan created_at dan updated_at
    public $timestamps = false;

    // Field yang boleh diisi
    protected $fillable = [
        'id_event',
        'jenis_tiket',
        'harga',
        'kuota_total',
        'kuota_tersedia',
    ];

    protected $attributes = [
        'kuota_tersedia' => 0,
        'harga' => 0,
    ];

    /**
     * Scope untuk mengambil tiket yang masih tersedia
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('kuota_tersedia', '>', 0);
    }
    /**
     * Relasi tiket ke event
     * Satu tiket dimiliki satu event
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    /**
     * Relasi tiket ke pemesanan
     * Satu tiket memiliki banyak pemesanan
     */
    public function pesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_tiket', 'id_tiket');
    }

    /**
     * Relasi tiket ke pendaftaran
     * Satu tiket memiliki banyak pendaftaran
     */
    public function pendaftaran()
    {
        return $this->hasMany(
            Pendaftaran::class,
            'id_tiket',
            'id_tiket'
        );
    }

    /**
     * Menghitung jumlah tiket yang masih tersedia
     */
    public function getSisaAttribute(): int
    {
        return $this->kuota_tersedia;
    }

    /**
     * Mengecek apakah tiket masih tersedia
     */
    public function isAvailable(): bool
    {
        return $this->kuota_tersedia > 0;
    }
}
