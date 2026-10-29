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
            AcademicJourneySeeder::class,
            HomeStatSeeder::class,
            BeyondClassroomCtaSeeder::class,
            AmenityCtaSeeder::class,
            CareerSeeder::class,
            CampusLifeSeeder::class,
            WhyChooseFeatureSeeder::class,
            PtaMemberSeeder::class,
            AdmissionBannerSeeder::class,
            ChairmanMessageSeeder::class,
            PrincipalMessageSeeder::class,
            EducationalSocietyMemberSeeder::class,
            SchoolManagementMemberSeeder::class,
            GallerySeeder::class,
            NewsMediaSeeder::class,
            TopBarSeeder::class,
            AdmissionStepSeeder::class,
            AdmissionCriterionSeeder::class,
            AdmissionFaqSeeder::class,
            ContactSettingSeeder::class,
            AdmissionHeroSeeder::class,
            AdmissionEnquirySeeder::class,
            ContactInquirySeeder::class,
            BreadcrumbBannerSeeder::class,
            MandatoryDisclosureSeeder::class,
            AdmissionPopupSeeder::class,
        ]);
    }
}
