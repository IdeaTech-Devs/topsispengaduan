<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruang;

class RuangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_ruang' => 'Ruang Kelas 301',
                'lokasi' => 'Gedung A Lantai 3',
                'kode_ruang' => 'A301',
            ],
            [
                'nama_ruang' => 'Perpustakaan Lantai 2',
                'lokasi' => 'Gedung Perpustakaan',
                'kode_ruang' => 'PERPUS2',
            ],
            [
                'nama_ruang' => 'Ruang Seminar 1',
                'lokasi' => 'Gedung B Lantai 1',
                'kode_ruang' => 'B101',
            ]
        ];
        foreach ($data as $item) {
            Ruang::create($item);
        }
    }
} 