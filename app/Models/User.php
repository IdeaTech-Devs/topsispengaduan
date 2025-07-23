<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'admin_id',
        'satgas_id',
        'pelapor_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function satgas()
    {
        return $this->belongsTo(Satgas::class, 'satgas_id', 'id_satgas');
    }

    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class, 'pelapor_id', 'id_pelapor');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
} 