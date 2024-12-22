<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemahasiswaan extends Model
{
    use HasFactory;

    protected $table = 'kemahasiswaan';
    protected $primaryKey = 'id_kemahasiswaan';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'fakultas',
        'foto_profil',
    ];

    public function kasus()
    {
        return $this->hasMany(Kasus::class, 'id_kemahasiswaan');
    }
}
