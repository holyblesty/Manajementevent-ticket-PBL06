<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    // 🚨 TAMBAHKAN BARIS INI:
    // Pastikan ejaannya SAMA PERSIS dengan di phpMyAdmin (Id_Admin)
    protected $primaryKey = 'Id_Admin'; 

    protected $fillable = [
        'username',
        'password',
        'name',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}