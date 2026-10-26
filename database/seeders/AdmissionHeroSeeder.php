<?php

namespace Database\Seeders;

use App\Models\AdmissionHero;
use Illuminate\Database\Seeder;

class AdmissionHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdmissionHero::updateOrCreate(
            ['id' => 1],
            [
                'location_tag'  => 'NARAPALLY, HYDERABAD',
                'title'         => 'Admission Open For',
                'academic_year' => '2026 – 2027',
                'description'   => 'Give your child the right foundation for a brighter future. Apply early for personalized guidance, campus tour, and direct interaction with academic mentors.',
                'phone'         => '+91 915740 43210',
                'email'         => 'info@jrsinternationalschool.com',
                'features'      => [
                    [
                        'title'    => 'CBSE Curriculum',
                        'subtitle' => 'National standards',
                        'icon'     => 'bi bi-mortarboard-fill',
                    ],
                    [
                        'title'    => 'Holistic Growth',
                        'subtitle' => 'Arts, sports & STEM',
                        'icon'     => 'bi bi-stars',
                    ],
                    [
                        'title'    => 'Top Faculty',
                        'subtitle' => 'Caring mentorship',
                        'icon'     => 'bi bi-award-fill',
                    ],
                ],
                'trust_badges'  => [
                    '100% Confidential',
                    'Quick 24-hr Response',
                ],
                'enquiry_academic_years' => [
                    '2026-2027',
                    '2027-2028',
                ],
                'enquiry_admission_types'=> [
                    'DAY SCHOLAR',
                    'DAY BOARDING',
                    'RESIDENTIAL',
                ],
            ]
        );
    }
}
