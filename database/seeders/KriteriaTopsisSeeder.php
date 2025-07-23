<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KriteriaTopsis;
use App\Models\NilaiKriteriaTopsis;

class KriteriaTopsisSeeder extends Seeder
{
    public function run()
    {
        // Jenis Sarana (30%)
        $jenisSarana = KriteriaTopsis::create([
            'nama_kriteria' => 'jenis_sarana',
            'bobot' => 0.30,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $jenisSarana->id_kriteria, 'item' => 'Ruang Periksa', 'nilai' => 5],
            ['id_kriteria' => $jenisSarana->id_kriteria, 'item' => 'Ruang Tindakan', 'nilai' => 4],
            ['id_kriteria' => $jenisSarana->id_kriteria, 'item' => 'Farmasi', 'nilai' => 3],
            ['id_kriteria' => $jenisSarana->id_kriteria, 'item' => 'Laboratorium', 'nilai' => 2],
            ['id_kriteria' => $jenisSarana->id_kriteria, 'item' => 'Lainnya', 'nilai' => 1],
        ]);

        // Tingkat Urgensi (25%)
        $urgensi = KriteriaTopsis::create([
            'nama_kriteria' => 'tingkat_urgensi',
            'bobot' => 0.25,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $urgensi->id_kriteria, 'item' => 'Tinggi', 'nilai' => 3],
            ['id_kriteria' => $urgensi->id_kriteria, 'item' => 'Sedang', 'nilai' => 2],
            ['id_kriteria' => $urgensi->id_kriteria, 'item' => 'Rendah', 'nilai' => 1],
        ]);

        // Kondisi Sarana (20%)
        $kondisi = KriteriaTopsis::create([
            'nama_kriteria' => 'kondisi_sarana',
            'bobot' => 0.20,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $kondisi->id_kriteria, 'item' => 'Rusak Berat', 'nilai' => 3],
            ['id_kriteria' => $kondisi->id_kriteria, 'item' => 'Rusak Ringan', 'nilai' => 2],
            ['id_kriteria' => $kondisi->id_kriteria, 'item' => 'Masih Layak', 'nilai' => 1],
        ]);

        // Lokasi (15%)
        $lokasi = KriteriaTopsis::create([
            'nama_kriteria' => 'lokasi',
            'bobot' => 0.15,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $lokasi->id_kriteria, 'item' => 'Lantai 1', 'nilai' => 3],
            ['id_kriteria' => $lokasi->id_kriteria, 'item' => 'Lantai 2', 'nilai' => 2],
            ['id_kriteria' => $lokasi->id_kriteria, 'item' => 'Lainnya', 'nilai' => 1],
        ]);

        // Bukti Kerusakan (10%)
        $bukti = KriteriaTopsis::create([
            'nama_kriteria' => 'bukti_kerusakan',
            'bobot' => 0.10,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $bukti->id_kriteria, 'item' => 'Ada Foto', 'nilai' => 2],
            ['id_kriteria' => $bukti->id_kriteria, 'item' => 'Tidak Ada Foto', 'nilai' => 1],
        ]);
    }
} 