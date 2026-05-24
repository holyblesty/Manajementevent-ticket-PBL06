<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang sebenarnya di database
    protected $table = 'registrations';
    
    // Menentukan Primary Key yang kita buat kustom
    protected $primaryKey = 'id_registration';

    // Kolom-kolom yang boleh diisi (mass assignable)
    protected $fillable = ['id_event', 'nama_tim', 'kontak'];

    // Relasi: Satu registrasi bisa punya banyak peserta
    public function participants()
    {
        return $this->hasMany(Participant::class, 'id_registration', 'id_registration');
    }
}