<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // Buat data admin terlebih dahulu
            $admin = Admin::create([
                'nama' => 'Admin UNIB',
                'email' => 'admin@unib.ac.id',
                'telepon' => '08123456789',
                'foto_profil' => null
            ]);

            // Buat user admin yang berelasi dengan data admin
            User::create([
                'email' => 'admin@unib.ac.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'id_admin' => $admin->id_admin,
                'id_kemahasiswaan' => null,
                'id_satgas' => null
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
} 