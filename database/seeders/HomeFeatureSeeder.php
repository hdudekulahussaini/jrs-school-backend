<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeFeature;

class HomeFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'title' => 'CBSE Curriculum',
                'description' => 'Strong academic foundation with modern teaching methodologies.',
                'icon' => 'bi bi-mortarboard-fill',
                'color' => '#e31e24',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Holistic Development',
                'description' => 'Nurturing intellectual, emotional, co-curricular and life skills.',
                'icon' => 'bi bi-stars',
                'color' => '#059669',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Best In-Class Infrastructure',
                'description' => 'Smart digital classrooms, high-tech science labs and spacious campus.',
                'icon' => 'bi bi-buildings-fill',
                'color' => '#4f46e5',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Personal Attention',
                'description' => 'Optimal teacher-to-student ratio ensuring individualized mentoring.',
                'icon' => 'bi bi-person-heart',
                'color' => '#db2777',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Safe & Secure Campus',
                'description' => '24/7 CCTV surveillance, vigilant staff and child-friendly premises.',
                'icon' => 'bi bi-shield-check',
                'color' => '#2563eb',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Eco Campus',
                'description' => 'Lush green surroundings fostering environmental awareness and wellness.',
                'icon' => 'bi bi-tree-fill',
                'color' => '#16a34a',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'STEM & Innovation',
                'description' => 'Robotics, AI, computer coding and hands-on scientific discovery.',
                'icon' => 'bi bi-lightbulb-fill',
                'color' => '#d97706',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Sports & Physical Education',
                'description' => 'Extensive grounds, dedicated athletic coaching and indoor sports.',
                'icon' => 'bi bi-trophy-fill',
                'color' => '#ea580c',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feat) {
            HomeFeature::updateOrCreate(
                ['title' => $feat['title']],
                $feat
            );
        }
    }
}
