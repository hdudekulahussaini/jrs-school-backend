<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BeyondClassroom;

class BeyondClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'title' => 'Sports',
                'category' => 'Fitness & Teamwork',
                'description' => 'Developing physical stamina, athletic discipline, teamwork, and sportsmanship across diverse track, court, and field games.',
                'icon' => 'trophy',
                'color' => '#15803d',
                'image_path' => '/images/beyond/sports.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Music',
                'category' => 'Vocal & Instruments',
                'description' => 'Cultivating musical sensibilities through instrumental training, percussion, vocals, and rhythmic harmony.',
                'icon' => 'music',
                'color' => '#0284c7',
                'image_path' => '/images/beyond/music.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Dance',
                'category' => 'Rhythm & Grace',
                'description' => 'Expressing creative passion and cultural tradition through classical, contemporary, and folk choreography.',
                'icon' => 'dance',
                'color' => '#db2777',
                'image_path' => '/images/beyond/dance.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Karate',
                'category' => 'Discipline & Defense',
                'description' => 'Building self-defense skills, mental focus, resilience, and ethical martial arts conduct.',
                'icon' => 'shield',
                'color' => '#d97706',
                'image_path' => '/images/beyond/karate.webp',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Science & Activities',
                'category' => 'Research & Labs',
                'description' => 'Inspiring curiosity, scientific inquiry, experiment-based problem solving, and hands-on technological exploration.',
                'icon' => 'flask',
                'color' => '#2563eb',
                'image_path' => '/images/beyond/science-lab.jpg',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Skating',
                'category' => 'Balance & Speed',
                'description' => 'Fostering agility, spatial awareness, neuromuscular coordination, and high-energy roller skating confidence.',
                'icon' => 'skating',
                'color' => '#0891b2',
                'image_path' => '/images/beyond/skating.jpg',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($activities as $act) {
            BeyondClassroom::updateOrCreate(
                ['title' => $act['title']],
                $act
            );
        }
    }
}
