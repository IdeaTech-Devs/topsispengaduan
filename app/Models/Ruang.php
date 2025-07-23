<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang';
    protected $primaryKey = 'id_ruang';

    protected $fillable = [
        'nama_ruang',
        'lokasi',
        'kode_ruang'
    ];

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'ruang_id', 'id_ruang');
    }
} 