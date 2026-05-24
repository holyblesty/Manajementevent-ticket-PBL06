<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang sebenarnya di database
    protected $table = 'participants';
    
    // Menentukan Primary Key yang kita buat kustom
    protected $primaryKey = 'id_participant';

    // Kolom-kolom yang boleh diisi
    protected $fillable = ['id_registration', 'nama', 'kode', 'email', 'instansi', 'hadir'];
}