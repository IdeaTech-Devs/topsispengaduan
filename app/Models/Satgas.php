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
    ];

    // Relasi many-to-many dengan Kasus
    public function kasus()
    {
        return $this->belongsToMany(Kasus::class, 'kasus_satgas', 'id_satgas', 'id_kasus')
                    ->using(KasusSatgas::class)
                    ->withPivot(['tanggal_tindak_lanjut', 'tanggal_tindak_selesai', 'status_tindak_lanjut']);
    }

    // Relasi dengan tabel pivot kasus_satgas
    public function kasus_satgas()
    {
        return $this->hasMany(KasusSatgas::class, 'id_satgas');
    }
}
