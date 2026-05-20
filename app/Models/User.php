<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',   // Tambahan sesuai ERD kamu
        'email',
        'password',
        'no_hp',      // Tambahan sesuai ERD kamu
        'alamat',     // Tambahan sesuai ERD kamu
        'role',       // Tambahan sesuai ERD kamu (admin / pengunjung)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi tambahan: Pengunjung bisa memiliki banyak pesanan
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_pengunjung', 'id');
    }
}