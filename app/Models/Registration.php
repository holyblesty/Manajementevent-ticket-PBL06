<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';
    
    protected $primaryKey = 'id_registration';

    // Menghapus 'nama_tim' karena kita fokus ke individu
    protected $fillable = ['id_event', 'kontak'];

    public function participants()
    {
        return $this->hasMany(Participant::class, 'id_registration', 'id_registration');
    }
}