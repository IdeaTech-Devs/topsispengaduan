<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kasus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kasus';
    protected $primaryKey = 'id';  // Pastikan ini sesuai dengan kolom primary key di database

    protected $fillable = [
        'pelapor_id',
        'no_pengaduan',
        'judul_pengaduan',
        'deskripsi',
        'lokasi_fasilitas',
        'jenis_fasilitas',
        'tingkat_urgensi',
        'status',
        'catatan_admin',
        'catatan_satgas',
        'foto_bukti',
        'foto_penanganan',
        'tanggal_pengaduan', 
        'tanggal_penanganan',
        'tanggal_selesai'
    ];

    protected $dates = [
        'tanggal_pengaduan',
        'tanggal_penanganan',
        'tanggal_selesai',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_penanganan' => 'datetime',
        'tanggal_selesai' => 'datetime'
    ];

    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class, 'pelapor_id', 'id_pelapor');
    }

    public function satgas()
    {
        return $this->belongsToMany(Satgas::class, 'kasus_satgas', 'kasus_id', 'satgas_id')
            ->withPivot(['status_penanganan', 'catatan_penanganan', 'mulai_penanganan', 'selesai_penanganan'])
            ->withTimestamps();
    }

    public function kasusSatgas()
    {
        return $this->hasMany(KasusSatgas::class, 'kasus_id');
    }

    public function getStatusTextAttribute()
    {
        return ucfirst(strtolower($this->status));
    }

    public function getTingkatUrgensiTextAttribute()
    {
        return ucfirst(strtolower($this->tingkat_urgensi));
    }
}