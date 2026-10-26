<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeStat;

class HomeStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats = [
            [
                'value' => '2021',
                'title' => 'Year of Establishment',
                'description' => 'Founded with a vision for world-class holistic education.',
                'icon' => 'graduation-cap',
                'color' => '#eab308',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'value' => '1000+',
                'title' => 'Happy Students',
                'description' => 'Nurturing bright young minds across all grade levels.',
                'icon' => 'users',
                'color' => '#eab308',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'value' => '50+',
                'title' => 'Experienced Faculty',
                'description' => 'Dedicated and passionate educators shaping tomorrow.',
                'icon' => 'award',
                'color' => '#eab308',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'value' => '100+',
                'title' => 'Co-curricular Activities',
                'description' => 'Wide array of sports, arts, robotics, and clubs.',
                'icon' => 'trophy',
                'color' => '#eab308',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            HomeStat::updateOrCreate(
                ['title' => $stat['title']],
                $stat
            );
        }
    }
}
