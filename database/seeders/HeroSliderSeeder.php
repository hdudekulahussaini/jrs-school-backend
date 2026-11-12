<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlider;

class HeroSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSlider::truncate();

        HeroSlider::create([
            'primary_button_text' => 'Admissions 2027-28',
            'secondary_button_text' => 'Take a Virtual Tour',
            'secondary_button_url' => 'https://jrs-school.vercel.app/#tour',
            'experience_badge_image' => 'images/experience-badge-38.svg',
            'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1920&auto=format&fit=crop',
            'background_images' => [
                'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1920&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1920&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1920&auto=format&fit=crop',
            ],
        ]);
    }
}
