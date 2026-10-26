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
                'title' => 'Art & Painting',
                'category' => 'Creative Expression',
                'description' => 'Nurturing aesthetic imagination, visual storytelling, and self-expression through color, sketching, and canvas painting.',
                'icon' => 'palette',
                'color' => '#e11d48',
                'image_path' => '/images/journey/butterflies-programme.jpg',
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
                'title' => 'Yoga',
                'category' => 'Mind & Wellness',
                'description' => 'Promoting holistic mental clarity, mindfulness, posture alignment, and inner equilibrium through guided asanas.',
                'icon' => 'heart',
                'color' => '#059669',
                'image_path' => '/images/events/annual-day.jpg',
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
            [
                'title' => 'Games & Sports',
                'category' => 'Fitness & Teamwork',
                'description' => 'Developing physical stamina, athletic discipline, teamwork, and sportsmanship across diverse track, court, and field games.',
                'icon' => 'trophy',
                'color' => '#15803d',
                'image_path' => '/images/beyond/sports.jpg',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Project Work',
                'category' => 'Research & Labs',
                'description' => 'Inspiring curiosity, scientific inquiry, experiment-based problem solving, and hands-on technological exploration.',
                'icon' => 'flask',
                'color' => '#2563eb',
                'image_path' => '/images/beyond/science-lab.jpg',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'title' => 'Excursions & Trips',
                'category' => 'Experiential Tours',
                'description' => 'Broadening real-world horizons through educational field visits, ecological nature trips, and cultural tours.',
                'icon' => 'compass',
                'color' => '#d97706',
                'image_path' => '/images/events/republic-day.jpg',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'title' => 'Clubs & Activities',
                'category' => 'Leadership & Social',
                'description' => 'Encouraging collaborative leadership, public speaking, literary debates, and social responsibility.',
                'icon' => 'users',
                'color' => '#7c3aed',
                'image_path' => '/images/journey/middle-school-students.jpg',
                'sort_order' => 10,
                'is_active' => true,
            ],
        ];

        // Replace older single names like 'Sports' and 'Science & Activities' with the updated titles
        BeyondClassroom::whereIn('title', ['Sports', 'Science & Activities'])->delete();

        foreach ($activities as $act) {
            BeyondClassroom::updateOrCreate(
                ['title' => $act['title']],
                $act
            );
        }
    }
}
