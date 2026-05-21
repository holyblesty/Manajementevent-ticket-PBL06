<?php

namespace App\Models;

// WAJIB MENGGUNAKAN ELEMEN AUTHENTICATABLE INI AGAR BISA DIPAKAI LOGIN GUARD
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Memaksa model agar membaca tabel 'admin' sesuai data di DatabaseSeeder
    protected $table = 'admin';

    // Beritahu Laravel kalau kolom login utamamu di database bernama 'username' (bukan email)
    // Beritahu Laravel kalau primary key dari tabel kamu adalah id (atau id_admin jika disesuaikan ERD)
    // protected $primaryKey = 'id_admin'; 

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignment)
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'foto',
    ];

    /**
     * Kolom keamanan yang disembunyikan saat data di-render
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}