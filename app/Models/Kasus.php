<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Kasus extends Model
{
    use HasFactory;

    protected $table = 'kasus';
    protected $primaryKey = 'id_kasus';

    protected $fillable = [
        'id_kemahasiswaan', 
        'id_pelapor', 
        'kode_pengaduan', 
        'jenis_masalah', 
        'urgensi', 
        'dampak', 
        'status_pengaduan', 
        'tanggal_konfirmasi', 
        'tanggal_pengaduan', 
        'deskripsi_kasus', 
        'bukti_kasus', 
        'asal_fakultas',
        'penangan_kasus',
        'catatan_penanganan'
    ];

    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_PERLU_KONFIRMASI = 'perlu dikonfirmasi';
    const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    const STATUS_PROSES_SATGAS = 'proses satgas';

    const JENIS_MASALAH = [
        'bullying' => 'Bullying',
        'kekerasan seksual' => 'Kekerasan Seksual',
        'pelecehan verbal' => 'Pelecehan Verbal',
        'diskriminasi' => 'Diskriminasi',
        'cyberbullying' => 'Cyberbullying',
        'lainnya' => 'Lainnya'
    ];

    const URGENSI = [
        'segera' => 'Segera',
        'dalam beberapa hari' => 'Dalam Beberapa Hari',
        'tidak mendesak' => 'Tidak Mendesak'
    ];

    const DAMPAK = [
        'sangat besar' => 'Sangat Besar',
        'sedang' => 'Sedang',
        'kecil' => 'Kecil'
    ];

    protected $dates = [
        'tanggal_konfirmasi',
        'tanggal_pengaduan',
        'created_at',
        'updated_at'
    ];

    public function getTanggalPengaduanFormattedAttribute()
    {
        return $this->tanggal_pengaduan ? date('d F Y', strtotime($this->tanggal_pengaduan)) : '-';
    }

    public function getTanggalKonfirmasiFormattedAttribute()
    {
        return $this->tanggal_konfirmasi ? date('d F Y', strtotime($this->tanggal_konfirmasi)) : '-';
    }

    // Relasi dengan model Pelapor
    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class, 'id_pelapor');
    }

    // Relasi dengan model Kemahasiswaan (asumsi akan dibuat)
    public function kemahasiswaan()
    {
        return $this->belongsTo(Kemahasiswaan::class, 'id_kemahasiswaan', 'id_kemahasiswaan');
    }

    // Fungsi untuk generate kode pengaduan
    public static function generateKodePengaduan()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $kode = '';
        
        do {
            // Generate 6 karakter random
            $kode = '';
            for ($i = 0; $i < 6; $i++) {
                $kode .= $characters[rand(0, strlen($characters) - 1)];
            }
            
            // Cek apakah kode sudah ada di database
            $exists = self::where('kode_pengaduan', $kode)->exists();
        } while ($exists);

        return $kode;
    }

    public function satgas()
    {
        return $this->belongsToMany(Satgas::class, 'kasus_satgas', 'id_kasus', 'id_satgas')
            ->using(KasusSatgas::class)
            ->withPivot(['tanggal_tindak_lanjut', 'tanggal_tindak_selesai', 'status_tindak_lanjut']);
    }

    // Relasi dengan tabel pivot kasus_satgas

    public function kasusSatgas()
    {
    return $this->hasMany(KasusSatgas::class, 'id_kasus', 'id_kasus');
    }
}