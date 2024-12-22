<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaTopsis extends Model
{
    protected $table = 'kriteria_topsis';
    protected $primaryKey = 'id_kriteria';
    
    protected $fillable = [
        'nama_kriteria',
        'bobot',
        'jenis'
    ];

    public function nilaiKriteria()
    {
        return $this->hasMany(NilaiKriteriaTopsis::class, 'id_kriteria');
    }
} 