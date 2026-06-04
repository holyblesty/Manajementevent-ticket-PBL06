<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'id_event',
        'id_tiket',
        'jumlah_tiket',
        'total_harga',
        'biaya_layanan',
        'grand_total',
        'metode_pembayaran',
        'bank_pilihan',
        'status',
        'tanggal_pesanan',
    ];

    protected $casts = [
        'total_harga'    => 'decimal:2',
        'biaya_layanan'  => 'decimal:2',
        'grand_total'    => 'decimal:2',
        'tanggal_pesanan'=> 'datetime',
    ];

    public static function generateKode(): string
    {
        return 'EVT-' . strtoupper(Str::random(8));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket', 'id_tiket');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'id_pesanan', 'id_pesanan');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'confirmed' => '<span class="badge-success">Dikonfirmasi</span>',
            'cancelled'  => '<span class="badge-danger">Dibatalkan</span>',
            default      => '<span class="badge-warning">Menunggu</span>',
        };
    }
}