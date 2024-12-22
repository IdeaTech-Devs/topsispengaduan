<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Satgas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SatgasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // Data Satgas
            $satgasData = [
                [
                    'nama' => 'Ahmad Prasetyo',
                    'email' => 'ahmad.satgas@unib.ac.id',
                    'telepon' => '08567891234',
                ],
                [
                    'nama' => 'Budi Hartanto',
                    'email' => 'budi.satgas@unib.ac.id',
                    'telepon' => '08765432109',
                ],
                [
                    'nama' => 'Clara Maharani',
                    'email' => 'clara.satgas@unib.ac.id',
                    'telepon' => '08123456789',
                ],
                [
                    'nama' => 'Dwi Santika',
                    'email' => 'dwi.satgas@unib.ac.id',
                    'telepon' => '08323456789',
                ],
                [
                    'nama' => 'Eka Pradana',
                    'email' => 'eka.satgas@unib.ac.id',
                    'telepon' => '08234567890',
                ],
                [
                    'nama' => 'Fitriani Syafira',
                    'email' => 'fitri.satgas@unib.ac.id',
                    'telepon' => '08734567891',
                ],
                [
                    'nama' => 'Galih Perdana',
                    'email' => 'galih.satgas@unib.ac.id',
                    'telepon' => '08523456790',
                ],
                [
                    'nama' => 'Hendra Saputra',
                    'email' => 'hendra.satgas@unib.ac.id',
                    'telepon' => '08123459876',
                ],
                [
                    'nama' => 'Indra Maulana',
                    'email' => 'indra.satgas@unib.ac.id',
                    'telepon' => '08512345678',
                ],
                [
                    'nama' => 'Joko Setiawan',
                    'email' => 'joko.satgas@unib.ac.id',
                    'telepon' => '08234567812',
                ]
            ];

            // Loop untuk insert data satgas dan user
            foreach ($satgasData as $satgas) {
                $satgasRecord = Satgas::create([
                    'nama' => $satgas['nama'],
                    'email' => $satgas['email'],
                    'telepon' => $satgas['telepon'],
                    'foto_profil' => null
                ]);

                // Buat user untuk satgas
                User::create([
                    'email' => $satgas['email'],
                    'password' => Hash::make('12345678'),
                    'role' => 'satgas',
                    'id_admin' => null,
                    'id_kemahasiswaan' => null,
                    'id_satgas' => $satgasRecord->id_satgas
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
