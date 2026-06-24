<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengunjung extends Authenticatable // <--- Class diubah
{
    use HasFactory, Notifiable;

    // PENTING: Memberitahu Laravel nama tabelnya sekarang
    protected $table = 'pengunjung';

    // PENTING: Memberitahu Laravel bahwa primary key tabel ini adalah id_pengunjung
    protected $primaryKey = 'id_pengunjung';

    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
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

    /**
     * Relasi: Pengunjung bisa memiliki banyak pesanan
     * Sesuaikan foreign key dengan kolom di tabel 'pemesanan'
     */
    public function pesanans()
    {
        // Parameter: (ModelTujuan, 'foreign_key_di_tabel_pemesanan', 'local_key_di_tabel_users')
        return $this->hasMany(Pemesanan::class, 'id_pengunjung', 'id_pengunjung');
    }
}
