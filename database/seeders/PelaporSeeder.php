<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PelaporSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('pelapor')->insert([
            [
                'nama_lengkap' => 'Amanda Putri',
                'nama_panggilan' => 'Amanda',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Teknik',
                'email' => 'amanda@domain.com',
                'no_wa' => '081234567810',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nama_panggilan' => 'Budi',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Teknik',
                'email' => 'budi@domain.com',
                'no_wa' => '081234567811',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Clara Wijaya',
                'nama_panggilan' => 'Clara',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Teknik',
                'email' => 'clara@domain.com',
                'no_wa' => '081234567812',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Dimas Arifin',
                'nama_panggilan' => 'Dimas',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Teknik',
                'email' => 'dimas@domain.com',
                'no_wa' => '081234567813',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Eka Saputra',
                'nama_panggilan' => 'Eka',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Teknik',
                'email' => 'eka@domain.com',
                'no_wa' => '081234567814',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Fitri Maulana',
                'nama_panggilan' => 'Fitri',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Ilmu Sosial dan Ilmu Politik',
                'email' => 'fitri@domain.com',
                'no_wa' => '081234567815',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Gita Anjani',
                'nama_panggilan' => 'Gita',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Kedokteran dan Ilmu Kesehatan',
                'email' => 'gita@domain.com',
                'no_wa' => '081234567816',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Harry Wibowo',
                'nama_panggilan' => 'Harry',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Ekonomi dan Bisnis',
                'email' => 'harry@domain.com',
                'no_wa' => '081234567817',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Indah Lestari',
                'nama_panggilan' => 'Indah',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Hukum',
                'email' => 'indah@domain.com',
                'no_wa' => '081234567818',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_lengkap' => 'Joko Prasetyo',
                'nama_panggilan' => 'Joko',
                'unsur' => 'Mahasiswa',
                'melapor_sebagai' => 'Mahasiswa',
                'bukti_identitas' => 'public/assets/img/bukti_identitas.png',
                'fakultas' => 'Pertanian',
                'email' => 'joko@domain.com',
                'no_wa' => '081234567819',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
