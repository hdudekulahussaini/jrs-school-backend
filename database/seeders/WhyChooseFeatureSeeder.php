<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhyChooseFeature;

class WhyChooseFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhyChooseFeature::truncate();

        // Feature Cards
        $cards = [
            [
                'title' => 'Academic Excellence',
                'description' => 'CBSE/NCERT curriculum with a strong academic foundation.',
                'icon' => 'bi bi-trophy-fill',
                'icon_color' => 'red',
            ],
            [
                'title' => 'Holistic Development',
                'description' => 'Balance of academics, values, co-curricular and life skills.',
                'icon' => 'bi bi-share-fill',
                'icon_color' => 'blue',
            ],
            [
                'title' => 'Best In-Class Infrastructure',
                'description' => 'Modern classrooms, labs, library and activity spaces.',
                'icon' => 'bi bi-buildings-fill',
                'icon_color' => 'amber',
            ],
            [
                'title' => 'Personal Attention',
                'description' => '1:25 teacher-student ratio for focused learning.',
                'icon' => 'bi bi-person-heart',
                'icon_color' => 'purple',
            ],
            [
                'title' => 'Safe & Secure Learning',
                'description' => 'A caring and secure environment for every student.',
                'icon' => 'bi bi-shield-check',
                'icon_color' => 'emerald',
            ],
            [
                'title' => '1:25 Student-Teacher Ratio',
                'description' => 'Optimal classroom strength ensuring individualized mentoring.',
                'icon' => 'bi bi-people-fill',
                'icon_color' => 'blue',
            ],
            [
                'title' => 'Professional Development',
                'description' => 'Continuous training and empowerment for our faculty.',
                'icon' => 'bi bi-laptop',
                'icon_color' => 'purple',
            ],
            [
                'title' => 'Qualitative Assessment',
                'description' => 'Comprehensive evaluation focusing on continuous improvement.',
                'icon' => 'bi bi-patch-check-fill',
                'icon_color' => 'amber',
            ],
            [
                'title' => 'Resource & Media Center',
                'description' => 'Extensive library, digital archives and reading resources.',
                'icon' => 'bi bi-book-half',
                'icon_color' => 'emerald',
            ],
            [
                'title' => 'Field Trips & Excursions',
                'description' => 'Experiential learning beyond classrooms.',
                'icon' => 'bi bi-bus-front-fill',
                'icon_color' => 'blue',
            ],
            [
                'title' => 'Career Guidance & Counseling',
                'description' => 'Personalized future pathway planning for students.',
                'icon' => 'bi bi-compass-fill',
                'icon_color' => 'red',
            ],
            [
                'title' => 'Visual & Performing Arts',
                'description' => 'Nurturing music, dance, theater and creative expression.',
                'icon' => 'bi bi-palette-fill',
                'icon_color' => 'purple',
            ],
            [
                'title' => 'Sports Education',
                'description' => 'Athletics, skating, karate and team sports for physical vitality.',
                'icon' => 'bi bi-award-fill',
                'icon_color' => 'amber',
            ],
        ];

        foreach ($cards as $index => $card) {
            WhyChooseFeature::create([
                'type' => 'card',
                'title' => $card['title'],
                'description' => $card['description'],
                'icon' => $card['icon'],
                'icon_color' => $card['icon_color'],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
