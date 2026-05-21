<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // 1. Pastikan nama tabel persis seperti di seeder
    protected $table = 'admin';

    // 2. JIKA di database kamu primary key-nya bukan 'id' (misal: 'id_admin'), 
    // hapus tanda ulasan (//) di bawah ini dan sesuaikan:
    // protected $primaryKey = 'id_admin';

    /**
     * Kolom yang boleh diisi secara massal
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'foto',
    ];

    /**
     * Kolom keamanan yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * FITUR PENYELAMAT: Beritahu Laravel secara tegas bahwa kolom password bernama 'password'
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}