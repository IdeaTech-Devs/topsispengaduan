<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class KasusSatgas extends Pivot
{
    protected $table = 'kasus_satgas';
    
    public $timestamps = false;
    
    protected $fillable = [
        'id_kasus',
        'id_satgas',
        'tanggal_tindak_lanjut',
        'tanggal_tindak_selesai',
        'status_tindak_lanjut'
    ];

    protected $casts = [
        'tanggal_tindak_lanjut' => 'date',
        'tanggal_tindak_selesai' => 'date'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class, 'id_kasus', 'id_kasus');
    }

    public function satgas()
    {
        return $this->belongsTo(Satgas::class, 'id_satgas', 'id_satgas');
    }

    public function kasusSatgas()
    {
    return $this->hasMany(KasusSatgas::class, 'id_kasus', 'id_kasus');
    }


} 