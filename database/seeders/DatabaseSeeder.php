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
<<<<<<< HEAD
            AcademicJourneySeeder::class,
            HomeStatSeeder::class,
            BeyondClassroomCtaSeeder::class,
            CareerSeeder::class,
=======
            CampusLifeSeeder::class,
            WhyChooseFeatureSeeder::class,
            PtaMemberSeeder::class,
>>>>>>> 04ab64343de79bd33c3d967ec6538c01b8d40678
        ]);
    }
}
