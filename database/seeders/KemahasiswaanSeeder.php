<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kemahasiswaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KemahasiswaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // Data Kemahasiswaan
            $kemahasiswaanData = [
                [
                    'nama' => 'Arya Ramadhani',
                    'email' => 'arya@unib.ac.id',
                    'telepon' => '08223456789',
                    'fakultas' => 'Ekonomi dan Bisnis'
                ],
                [
                    'nama' => 'Bella Santoso',
                    'email' => 'bella@unib.ac.id',
                    'telepon' => '08312345678',
                    'fakultas' => 'Hukum'
                ],
                [
                    'nama' => 'Cahya Fitriani',
                    'email' => 'cahya@unib.ac.id',
                    'telepon' => '08523456789',
                    'fakultas' => 'Pertanian'
                ],
                [
                    'nama' => 'Dani Kurniawan',
                    'email' => 'dani@unib.ac.id',
                    'telepon' => '08765432109',
                    'fakultas' => 'Ilmu Sosial dan Ilmu Politik'
                ],
                [
                    'nama' => 'Erna Suryani',
                    'email' => 'erna@unib.ac.id',
                    'telepon' => '08898765432',
                    'fakultas' => 'Keguruan dan Ilmu Pendidikan'
                ],
                [
                    'nama' => 'Farhan Hakim',
                    'email' => 'farhan@unib.ac.id',
                    'telepon' => '08987654321',
                    'fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'
                ],
                [
                    'nama' => 'Gina Mardiana',
                    'email' => 'gina@unib.ac.id',
                    'telepon' => '08123456789',
                    'fakultas' => 'Kedokteran dan Ilmu Kesehatan'
                ]
            ];

            // Loop untuk insert data kemahasiswaan dan user
            foreach ($kemahasiswaanData as $kemahasiswaan) {
                $kemahasiswaanRecord = Kemahasiswaan::create([
                    'nama' => $kemahasiswaan['nama'],
                    'email' => $kemahasiswaan['email'],
                    'telepon' => $kemahasiswaan['telepon'],
                    'foto_profil' => null,
                    'fakultas' => $kemahasiswaan['fakultas']
                ]);

                // Buat user untuk kemahasiswaan
                User::create([
                    'email' => $kemahasiswaan['email'],
                    'password' => Hash::make('12345678'),
                    'role' => 'kemahasiswaan',
                    'id_admin' => null,
                    'id_kemahasiswaan' => $kemahasiswaanRecord->id_kemahasiswaan,
                    'id_satgas' => null
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
