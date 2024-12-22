<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PelaporSeeder;
use Database\Seeders\KasusSeeder;
use Database\Seeders\KemahasiswaanSeeder;
use Database\Seeders\SatgasSeeder;
use Database\Seeders\KriteriaTopsisSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PelaporSeeder::class,
            KasusSeeder::class,
            KemahasiswaanSeeder::class,
            SatgasSeeder::class,
            KriteriaTopsisSeeder::class,
        ]);
    }
}
