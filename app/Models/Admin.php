<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // 1. Beritahu Laravel bahwa nama tabelnya adalah 'admin' (bukan 'admins')
    protected $table = 'admin';

    // 2. Beritahu Laravel bahwa Primary Key-nya adalah 'Id_Admin' sesuai ERD kamu
    protected $primaryKey = 'Id_Admin';

    // 3. Jika primary key kamu bukan integer biasa melainkan auto-increment
    public $incrementing = true;

    // 4. Daftarkan kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'username',
        'password',
    ];

    // 5. Sembunyikan password saat data di-convert ke Array atau JSON demi keamanan
    protected $hidden = [
        'password',
        'remember_token',
    ];
}