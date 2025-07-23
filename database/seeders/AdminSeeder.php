<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            // Buat data admin
            $admin = Admin::create([
                'nama' => 'Admin UNIB',
                'email' => 'admin@unib.ac.id',
                'foto_profil' => null
            ]);

            // Buat user admin
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'admin_id' => $admin->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
} 