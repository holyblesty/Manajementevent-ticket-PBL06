<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';
    
    protected $primaryKey = 'id_participant';

    // Kolom-kolom yang boleh diisi
    protected $fillable = ['id_registration', 'nama', 'kode', 'email', 'instansi', 'hadir'];

    // Menambahkan relasi ke Registration (Opsional tapi disarankan)
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'id_registration', 'id_registration');
    }
}