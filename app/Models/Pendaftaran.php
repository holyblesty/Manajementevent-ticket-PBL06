<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE CONFIGURATION
    |--------------------------------------------------------------------------
    */

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'pendaftaran';

    // Primary key tabel
    protected $primaryKey = 'id_pendaftaran';

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
        'nama_pendaftar',
        'email',
        'no_hp',
        'jenis_tiket',
        'jumlah_tiket',
        'tanggal_daftar',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi: Pendaftaran terhubung ke satu Event
     *
     * Artinya:
     * 1 pendaftaran hanya milik 1 event
     */
    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }
}
