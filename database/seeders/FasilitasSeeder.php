<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;
use App\Models\Ruang;

class FasilitasSeeder extends Seeder
{
    public function run()
    {
        $ruangA301 = Ruang::where('kode_ruang', 'A301')->first();
        $perpus2 = Ruang::where('kode_ruang', 'PERPUS2')->first();
        $seminar1 = Ruang::where('kode_ruang', 'B101')->first();

        $data = [
            [
                'ruang_id' => $ruangA301->id_ruang,
                'nama_fasilitas' => 'AC',
                'jenis_fasilitas' => 'Elektronik',
                'kode_fasilitas' => 'A301-AC',
                'deskripsi' => 'AC utama ruang kelas 301',
            ],
            [
                'ruang_id' => $ruangA301->id_ruang,
                'nama_fasilitas' => 'Proyektor',
                'jenis_fasilitas' => 'Elektronik',
                'kode_fasilitas' => 'A301-PRO',
                'deskripsi' => 'Proyektor ruang kelas 301',
            ],
            [
                'ruang_id' => $perpus2->id_ruang,
                'nama_fasilitas' => 'Atap',
                'jenis_fasilitas' => 'Bangunan',
                'kode_fasilitas' => 'PERPUS2-ATAP',
                'deskripsi' => 'Atap area baca lantai 2',
            ],
            [
                'ruang_id' => $seminar1->id_ruang,
                'nama_fasilitas' => 'Proyektor',
                'jenis_fasilitas' => 'Elektronik',
                'kode_fasilitas' => 'B101-PRO',
                'deskripsi' => 'Proyektor ruang seminar 1',
            ]
        ];
        foreach ($data as $item) {
            Fasilitas::create($item);
        }
    }
} 