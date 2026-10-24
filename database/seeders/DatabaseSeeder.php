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
            VisionMissionSeeder::class,
            NewsTickerSeeder::class,
            HeroSliderSeeder::class,
            FacilitySeeder::class,
            AcademicProgramSeeder::class,
            BeyondClassroomSeeder::class,
            SchoolEventSeeder::class,
            HomeFeatureSeeder::class,
            CampusLifeSeeder::class,
            WhyChooseFeatureSeeder::class,
            PtaMemberSeeder::class,
        ]);
    }
}
