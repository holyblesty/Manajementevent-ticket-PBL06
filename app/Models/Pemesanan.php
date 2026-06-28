<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pemesanan extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE CONFIGURATION
    |--------------------------------------------------------------------------
    */

    // Menentukan nama tabel yang digunakan model ini
    protected $table = 'pemesanan';

    // Primary key dari tabel pemesanan
    protected $primaryKey = 'id_pesanan';

    // Nonaktifkan timestamps (created_at & updated_at tidak digunakan)
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'id_event',
        'id_pengunjung',
        'id_tiket',
        'tgl_pesan',
        'tgl_bayar',
        'metode_pembayaran',
        'total_harga',
        'jumlah_tiket',
        'kode_registrasi',
        'sts_transaksi'
    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTING
    |--------------------------------------------------------------------------
    */

    // Konversi otomatis tipe data saat diakses
    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | HELPER FUNCTION
    |--------------------------------------------------------------------------
    */

    /**
     * Generate kode registrasi unik untuk setiap pemesanan
     * Format: EVT-XXXXXXXX (8 karakter random uppercase)
     */
    public static function generateKode(): string
    {
        return 'EVT-' . strtoupper(Str::random(8));
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi: Pemesanan dimiliki oleh satu pengunjung
     */
    public function pengunjung()
    {
        return $this->belongsTo(
            Pengunjung::class,
            'id_pengunjung',
            'id_pengunjung'
        );
    }

    /**
     * Relasi: Pemesanan terhubung ke satu event
     */
    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }

    /**
     * Relasi: Pemesanan terhubung ke satu jenis tiket
     */
    public function tiket()
    {
        return $this->belongsTo(
            Tiket::class,
            'id_tiket',
            'id_tiket'
        );
    }
}
