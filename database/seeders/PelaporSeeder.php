<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelapor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PelaporSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            $pelaporData = [
                [
                    'nama_lengkap' => 'Amanda Putri',
                    'nama_panggilan' => 'Amanda',
                    'status_pelapor' => 'staff',
                    'email' => 'amanda@domain.com',
                    'no_wa' => '081234567810',
                ],
                [
                    'nama_lengkap' => 'Budi Santoso',
                    'nama_panggilan' => 'Budi',
                    'status_pelapor' => 'staff',
                    'email' => 'budi@domain.com',
                    'no_wa' => '081234567811',
                ],
                [
                    'nama_lengkap' => 'Clara Wijaya',
                    'nama_panggilan' => 'Clara',
                    'status_pelapor' => 'pengunjung',
                    'email' => 'clara@domain.com',
                    'no_wa' => '081234567812',
                ],
                [
                    'nama_lengkap' => 'Dimas Arifin',
                    'nama_panggilan' => 'Dimas',
                    'status_pelapor' => 'pengunjung',
                    'email' => 'dimas@domain.com',
                    'no_wa' => '081234567813',
                ],
                [
                    'nama_lengkap' => 'Eka Saputra',
                    'nama_panggilan' => 'Eka',
                    'status_pelapor' => 'staff',
                    'email' => 'eka@domain.com',
                    'no_wa' => '081234567814',
                ]
            ];

            foreach ($pelaporData as $pelapor) {
                $pelaporRecord = Pelapor::create([
                    'nama_lengkap' => $pelapor['nama_lengkap'],
                    'nama_panggilan' => $pelapor['nama_panggilan'],
                    'status_pelapor' => $pelapor['status_pelapor'],
                    'email' => $pelapor['email'],
                    'no_wa' => $pelapor['no_wa']
                ]);

                User::create([
                    'name' => $pelapor['nama_lengkap'],
                    'email' => $pelapor['email'],
                    'password' => Hash::make('12345678'),
                    'role' => 'pelapor',
                    'pelapor_id' => $pelaporRecord->id_pelapor
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
