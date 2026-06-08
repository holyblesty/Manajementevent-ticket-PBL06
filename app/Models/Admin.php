<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin'; 
    
    // Sesuaikan dengan nama kolom asli di tabel Anda (huruf kecil semua)
    protected $primaryKey = 'id_admin'; 
    
    // Jika tipe data primary key bukan integer (misal string/UUID), 
    // tambahkan: public $incrementing = true; (biarkan default jika auto-increment)

    public $timestamps = false; 

    protected $fillable = [
        'username',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];
}