<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CampusLifeSeeder::class,
            WhyChooseFeatureSeeder::class,
            PtaMemberSeeder::class,
        ]);
    }
}
