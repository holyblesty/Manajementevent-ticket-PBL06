<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengunjung extends Authenticatable
{
    use HasFactory, Notifiable;

    // Menentukan nama tabel yang digunakan oleh model ini

    /*
    |--------------------------------------------------------------------------
    | CONFIG TABLE
    |--------------------------------------------------------------------------
    */

    // Nama tabel
    protected $table = 'pengunjung';

    // Primary Key
    protected $primaryKey = 'id_pengunjung';

    // Auto Increment
    public $incrementing = true;

    protected $keyType = 'int';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'no_hp',
        'alamat',
        'foto',
        'role',
    ];

    /*
    |--------------------------------------------------------------------------
    | HIDDEN ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
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
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Satu pengunjung memiliki banyak pemesanan
    public function pesanans()
    {
        return $this->hasMany(
            Pemesanan::class,
            'id_pengunjung',
            'id_pengunjung'
        );
    }
}
