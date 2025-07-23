<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'ruang_id',
        'nama_fasilitas',
        'jenis_fasilitas',
        'kode_fasilitas',
        'deskripsi'
    ];

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id', 'id_ruang');
    }
} 