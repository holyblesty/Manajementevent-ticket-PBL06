<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    // Gunakan primary key sesuai database Anda
    protected $primaryKey = 'Id_Admin'; 

    // Hanya isi dengan kolom yang BENAR-BENAR ADA di database
    protected $fillable = [
        'username',
        'password',
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