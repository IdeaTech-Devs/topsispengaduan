<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKriteriaTopsis extends Model
{
    protected $table = 'nilai_kriteria_topsis';
    protected $primaryKey = 'id_nilai';
    public $timestamps = true;
    
    protected $fillable = [
        'id_kriteria',
        'item',
        'nilai'
    ];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaTopsis::class, 'id_kriteria');
    }
} 