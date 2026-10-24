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
                'description' => 'Strong academic foundation',
                'icon' => 'graduation-cap',
                'color' => '#e31e24',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Holistic Development',
                'description' => 'Academic, co-curricular & life skills',
                'icon' => 'sparkles',
                'color' => '#059669',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Experienced Faculty',
                'description' => 'Dedicated & qualified teachers',
                'icon' => 'award',
                'color' => '#f59e0b',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Safe & Inclusive',
                'description' => 'Nurturing and secure environment',
                'icon' => 'shield-check',
                'color' => '#2563eb',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Modern Infrastructure',
                'description' => 'World-class learning environment',
                'icon' => 'building-2',
                'color' => '#4f46e5',
                'sort_order' => 5,
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
