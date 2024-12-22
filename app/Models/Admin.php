<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'foto_profil'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_admin', 'id_admin');
    }
} 