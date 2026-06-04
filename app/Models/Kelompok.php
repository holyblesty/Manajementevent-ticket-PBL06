<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'tblkelompok';

    public $timestamps = false;

    protected $fillable = [
        'nama_kelompok',
        'jumlah_anggota',
        'event_id'
    ];
}