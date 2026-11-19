<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Dati di base necessari anche in produzione. */
    public function run(): void
    {
        $this->call([
            ProvinceSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            AdSlotSeeder::class,
        ]);
    }
}
