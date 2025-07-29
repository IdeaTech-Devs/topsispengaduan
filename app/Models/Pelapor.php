<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    use HasFactory;

    protected $table = 'pelapor';
    protected $primaryKey = 'id_pelapor';

    protected $fillable = [
        'nama_lengkap', 
        'nama_panggilan', 
        'status_pelapor',
        'email', 
        'no_wa'
    ];

    public function kasus()
    {
        return $this->hasMany(Kasus::class, 'pelapor_id', 'id_pelapor');
    }
}