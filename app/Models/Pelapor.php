<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    protected $table = 'pelapor';
    protected $primaryKey = 'id_pelapor';

    protected $fillable = [
        'nama_lengkap', 
        'nama_panggilan', 
        'unsur', 
        'melapor_sebagai', 
        'bukti_identitas', 
        'fakultas', 
        'departemen_prodi', 
        'unit_kerja', 
        'email', 
        'no_wa', 
        'hubungan_korban'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Konstanta untuk validasi dan referensi di form
    const UNSUR_LIST = [
        'dosen',
        'mahasiswa',
        'tenaga kependidikan',
        'warga kampus',
        'bukan dosen/mahasiswa/tenaga pendidik/warga kampus universitas bengkulu',
        'lainnya'
    ];

    const MELAPOR_LIST = [
        'korban',
        'perwakilan korban',
        'saksi',
        'lainnya'
    ];

    const HUBUNGAN_LIST = [
        'diri sendiri',
        'teman',
        'keluarga',
        'lainnya'
    ];

    // Rules validasi
    public static $rules = [
        'nama_lengkap' => 'required|string|max:100',
        'nama_panggilan' => 'required|string|max:50',
        'unsur' => 'required|string|max:100',
        'melapor_sebagai' => 'required|string|max:50',
        'bukti_identitas' => 'required|string|max:100',
        'fakultas' => 'required|string|max:50',
        'departemen_prodi' => 'nullable|string|max:50',
        'unit_kerja' => 'nullable|string|max:50',
        'email' => 'required|email|max:100',
        'no_wa' => 'required|string|max:15',
        'hubungan_korban' => 'required|string|max:50',
    ];

    public function kasus()
    {
        return $this->hasMany(Kasus::class, 'id_pelapor', 'id_pelapor');
    }

    public function getBuktiIdentitasUrlAttribute()
    {
        return $this->bukti_identitas ? asset('storage/' . $this->bukti_identitas) : null;
    }
}