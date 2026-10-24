<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolEvent;

class SchoolEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Republic Day Celebrations',
                'event_date' => '2026-01-26',
                'badge_day' => '26',
                'badge_month' => 'JAN',
                'description' => 'Students showcased patriotic fervor in traditional costumes, march past and cultural performances.',
                'image_path' => '/images/events/republic-day.jpg',
                'link_url' => '/gallery',
                'link_text' => 'Explore event',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Annual Day Celebrations',
                'event_date' => '2026-02-11',
                'badge_day' => '11',
                'badge_month' => 'FEB',
                'description' => 'A spectacular evening of music, dance, theatrical drama, and honoring student excellence.',
                'image_path' => '/images/events/annual-day.jpg',
                'link_url' => '/gallery',
                'link_text' => 'Explore event',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Sports Day',
                'event_date' => '2026-08-28',
                'badge_day' => '28',
                'badge_month' => 'AUG',
                'description' => 'Showcasing athleticism, team spirit, athletic track events, and enthusiastic sportsmanship.',
                'image_path' => '/images/events/sports-day.jpg',
                'link_url' => '/gallery',
                'link_text' => 'Explore event',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($events as $evt) {
            SchoolEvent::updateOrCreate(
                ['title' => $evt['title']],
                $evt
            );
        }
    }
}
