<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::truncate();

        Facility::create([
            'title' => 'Smart Classrooms',
            'description' => 'Modern and interactive learning spaces',
            'icon' => 'monitor',
            'theme_color' => 'navy',
            'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Facility::create([
            'title' => 'Science & Computer Labs',
            'description' => 'Well-equipped labs for hands-on learning',
            'icon' => 'flask',
            'theme_color' => 'red',
            'image_path' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=800&auto=format&fit=crop',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Facility::create([
            'title' => 'Library',
            'description' => 'A world of knowledge and imagination',
            'icon' => 'book',
            'theme_color' => 'navy',
            'image_path' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=800&auto=format&fit=crop',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        Facility::create([
            'title' => 'Sports Facilities',
            'description' => 'Indoor & outdoor sports for all-round growth',
            'icon' => 'trophy',
            'theme_color' => 'red',
            'image_path' => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800&auto=format&fit=crop',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        Facility::create([
            'title' => 'Transport',
            'description' => 'Safe, reliable and secure transport',
            'icon' => 'bus',
            'theme_color' => 'navy',
            'image_path' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800&auto=format&fit=crop',
            'sort_order' => 5,
            'is_active' => true,
        ]);
    }
}
