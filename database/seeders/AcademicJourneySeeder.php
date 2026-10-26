<?php

namespace Database\Seeders;

use App\Models\AcademicJourney;
use Illuminate\Database\Seeder;

class AcademicJourneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journeys = [
            [
                'title' => 'Pre-Primary Programme',
                'age_group' => 'Early Years',
                'slug' => 'pre-primary-programme',
                'description' => 'We have adopted the inquiry and self-research-based Pre-primary program of international quality for the first few and most critical learning years of your child.',
                'icon' => 'baby',
                'image_path' => 'images/journey/pre-primary-learning.jpg',
                'link_url' => '/academics/pre-primary-programme',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Young Buddies',
                'age_group' => 'Age 2.5 to 3.5 years',
                'slug' => 'young-buddies',
                'description' => 'We provide experienced and trained staff to help toddlers develop key learning skills through sensory-based learning, healthy habits, and sports activities.',
                'icon' => 'users',
                'image_path' => 'images/journey/young-buddies.jpg',
                'link_url' => '/academics/young-buddies',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Butterflies Programme',
                'age_group' => 'Age 3.5 to 4.5 years',
                'slug' => 'butterflies-programme',
                'description' => 'At this age, children are more willing to learn, share and explore through languages, writing skills, memory-building, and story studios.',
                'icon' => 'sparkles',
                'image_path' => 'images/journey/butterflies-programme.jpg',
                'link_url' => '/academics/butterflies-programme',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Honey Bees Programme',
                'age_group' => 'Age 4.5 to 5.5 years',
                'slug' => 'honey-bees-programme',
                'description' => 'Just like the hardworking honeybee, children build overall skills through hands-on learning, field trips, reading, writing, and early Math and Science.',
                'icon' => 'heart',
                'image_path' => 'images/journey/middle-school-students.jpg',
                'link_url' => '/academics/honey-bees-programme',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($journeys as $item) {
            AcademicJourney::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
