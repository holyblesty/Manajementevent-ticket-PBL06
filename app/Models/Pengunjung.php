<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengunjung extends Authenticatable // <--- Class diubah
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | CONFIG TABLE
    |--------------------------------------------------------------------------
    */

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'pengunjung';

    // Menentukan primary key tabel
    protected $primaryKey = 'id_pengunjung';

    // Primary key bertipe integer dan auto increment
    public $incrementing = true;
    protected $keyType = 'int';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    // Field yang boleh diisi secara mass assignment (create / update)
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
    ];

    /*
    |--------------------------------------------------------------------------
    | HIDDEN ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    // Field yang disembunyikan saat data di-convert ke array / JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTING
    |--------------------------------------------------------------------------
    */

    /**
     * Konversi otomatis tipe data atribut
     * Contoh: password akan otomatis di-hash
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi: satu pengunjung bisa memiliki banyak pemesanan
     *
     * Artinya:
     * 1 pengunjung → banyak data di tabel pemesanan
     */
    public function pesanans()
    {
        // hasMany(ModelTujuan, foreign_key_di_tabel_pemesanan, primary_key_di_tabel_pengunjung)
        return $this->hasMany(
            Pemesanan::class,
            'id_pengunjung',
            'id_pengunjung'
        );
    }
}
