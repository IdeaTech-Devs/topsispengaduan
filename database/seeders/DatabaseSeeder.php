<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            SatgasSeeder::class,
            PelaporSeeder::class,
            KriteriaTopsisSeeder::class,
            KasusSeeder::class,
        ]);
    }
}
