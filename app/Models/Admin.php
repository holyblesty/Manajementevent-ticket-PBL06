<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin'; // Sesuai dengan nama tabel di database Anda
    protected $primaryKey = 'Id_admin'; // Sesuaikan huruf kecil 'a'
    
    public $timestamps = false; // Karena di database Anda 'created_at' banyak yang NULL

    protected $fillable = [
        'username',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];
}