<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satgas extends Model
{
    use HasFactory;

    protected $table = 'satgas';
    protected $primaryKey = 'id_satgas';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'foto_profil'
    ];

    public function kasus()
    {
        return $this->belongsToMany(Kasus::class, 'kasus_satgas', 'satgas_id', 'kasus_id')
            ->withPivot(['status_penanganan', 'catatan_penanganan', 'mulai_penanganan', 'selesai_penanganan'])
            ->withTimestamps();
    }

    public function kasusSatgas()
    {
        return $this->hasMany(KasusSatgas::class, 'satgas_id', 'id_satgas');
    }
}
