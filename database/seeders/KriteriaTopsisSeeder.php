<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KriteriaTopsis;
use App\Models\NilaiKriteriaTopsis;

class KriteriaTopsisSeeder extends Seeder
{
    public function run()
    {
        // Jenis Masalah (30%)
        $jenismasalah = KriteriaTopsis::create([
            'nama_kriteria' => 'jenis_masalah',
            'bobot' => 0.30,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $jenismasalah->id_kriteria, 'item' => 'kekerasan seksual', 'nilai' => 5],
            ['id_kriteria' => $jenismasalah->id_kriteria, 'item' => 'bullying', 'nilai' => 4],
            ['id_kriteria' => $jenismasalah->id_kriteria, 'item' => 'cyberbullying', 'nilai' => 4],
            ['id_kriteria' => $jenismasalah->id_kriteria, 'item' => 'diskriminasi', 'nilai' => 3],
            ['id_kriteria' => $jenismasalah->id_kriteria, 'item' => 'pelecehan verbal', 'nilai' => 2],
            ['id_kriteria' => $jenismasalah->id_kriteria, 'item' => 'lainnya', 'nilai' => 1],
        ]);

        // Urgensi (25%)
        $urgensi = KriteriaTopsis::create([
            'nama_kriteria' => 'urgensi',
            'bobot' => 0.25,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $urgensi->id_kriteria, 'item' => 'segera', 'nilai' => 3],
            ['id_kriteria' => $urgensi->id_kriteria, 'item' => 'dalam beberapa hari', 'nilai' => 2],
            ['id_kriteria' => $urgensi->id_kriteria, 'item' => 'tidak mendesak', 'nilai' => 1],
        ]);

        // Dampak (20%)
        $dampak = KriteriaTopsis::create([
            'nama_kriteria' => 'dampak',
            'bobot' => 0.20,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $dampak->id_kriteria, 'item' => 'sangat besar', 'nilai' => 3],
            ['id_kriteria' => $dampak->id_kriteria, 'item' => 'sedang', 'nilai' => 2],
            ['id_kriteria' => $dampak->id_kriteria, 'item' => 'kecil', 'nilai' => 1],
        ]);

        // Unsur (15%)
        $unsur = KriteriaTopsis::create([
            'nama_kriteria' => 'unsur',
            'bobot' => 0.15,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $unsur->id_kriteria, 'item' => 'dosen', 'nilai' => 5],
            ['id_kriteria' => $unsur->id_kriteria, 'item' => 'mahasiswa', 'nilai' => 4],
            ['id_kriteria' => $unsur->id_kriteria, 'item' => 'tenaga kependidikan', 'nilai' => 3],
            ['id_kriteria' => $unsur->id_kriteria, 'item' => 'bukan dosen/mahasiswa/tenaga pendidik/warga kampus universitas bengkulu', 'nilai' => 2],
            ['id_kriteria' => $unsur->id_kriteria, 'item' => 'lainnya', 'nilai' => 1],
        ]);

        // Bukti (10%)
        $bukti = KriteriaTopsis::create([
            'nama_kriteria' => 'bukti',
            'bobot' => 0.10,
            'jenis' => 'benefit'
        ]);

        NilaiKriteriaTopsis::insert([
            ['id_kriteria' => $bukti->id_kriteria, 'item' => 'ada bukti', 'nilai' => 2],
            ['id_kriteria' => $bukti->id_kriteria, 'item' => 'tidak ada bukti', 'nilai' => 1],
        ]);
    }
} 