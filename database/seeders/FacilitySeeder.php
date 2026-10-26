<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds for Amenities / State-of-the-Art Facilities.
     */
    public function run(): void
    {
        Facility::truncate();

        $amenities = [
            [
                'title' => 'Athletics Track, Swimming Pool and Meditation Hall',
                'description' => 'State-of-the-art synthetic running track, international-standard swimming pool, and serene meditation hall for student physical and mental wellness.',
                'icon' => 'waves',
                'theme_color' => 'navy',
                'image_path' => '/images/beyond/sports.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Spacious playgrounds for football, cricket, basketball and volleyball',
                'description' => 'Expansive manicured sporting arenas, multi-sport courts, and professional training grounds for major athletic pursuits.',
                'icon' => 'trophy',
                'theme_color' => 'navy',
                'image_path' => '/images/beyond/sports.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Canteen for the use of day scholars and staff',
                'description' => 'Hygienic dining facility serving wholesome, nutritious meals and fresh refreshments daily under strict food safety norms.',
                'icon' => 'utensils',
                'theme_color' => 'navy',
                'image_path' => '/images/journey/butterflies-programme.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Transport facilities for students and staff',
                'description' => 'Extensive fleet of modern buses equipped with GPS tracking, CCTV surveillance, and certified conductors.',
                'icon' => 'bus',
                'theme_color' => 'navy',
                'image_path' => '/images/journey/primary.png',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Secure campus with widespread CCTV coverage',
                'description' => '24/7 security monitoring with high-definition CCTV coverage across all gates, corridors, playgrounds, and common zones.',
                'icon' => 'shield',
                'theme_color' => 'navy',
                'image_path' => '/images/beyond/karate.webp',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Medical facilities and First aid',
                'description' => 'Dedicated on-campus infirmary staffed with a qualified full-time nurse, emergency first-aid equipment, and immediate doctor-on-call support.',
                'icon' => 'heart-pulse',
                'theme_color' => 'navy',
                'image_path' => '/images/journey/butterflies-programme.jpg',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'World Class Infrastructure with elegant Ambience',
                'description' => 'Aesthetically designed campus with spacious sunlit corridors, modern architectural acoustics, and lush green campus environments.',
                'icon' => 'building',
                'theme_color' => 'navy',
                'image_path' => '/images/journey/primary.png',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Excellent computing facilities with Internet and Wi-Fi',
                'description' => 'High-speed fiber optic Wi-Fi network and cutting-edge computer stations with filtered educational browsing for digital empowerment.',
                'icon' => 'wifi',
                'theme_color' => 'navy',
                'image_path' => '/images/beyond/science-lab.jpg',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($amenities as $item) {
            Facility::create($item);
        }
    }
}
