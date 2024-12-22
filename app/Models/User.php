<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_kemahasiswaan',
        'id_satgas',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kemahasiswaan()
    {
        return $this->belongsTo(Kemahasiswaan::class, 'id_kemahasiswaan');
    }

    public function satgas()
    {
        return $this->belongsTo(Satgas::class, 'id_satgas');
    }

    public function hasRole($role)
    {
        switch ($role) {
            case 'kemahasiswaan':
                return $this->id_kemahasiswaan !== null;
            case 'satgas':
                return $this->id_satgas !== null;
            default:
                return false;
        }
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
