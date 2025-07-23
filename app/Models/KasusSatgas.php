<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KasusSatgas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kasus_satgas';
    
    protected $fillable = [
        'kasus_id',
        'satgas_id',
        'status_penanganan',
        'catatan_penanganan',
        'mulai_penanganan',
        'selesai_penanganan'
    ];

    protected $dates = [
        'mulai_penanganan',
        'selesai_penanganan',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class, 'kasus_id', 'id');
    }

    public function satgas()
    {
        return $this->belongsTo(Satgas::class, 'satgas_id', 'id_satgas');
    }

    public function getStatusPenangananTextAttribute()
    {
        return ucfirst(strtolower($this->status_penanganan));
    }
} 