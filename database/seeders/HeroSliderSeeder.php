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
            'badge_title' => 'NURTURING BRIGHT MINDS • BUILDING A BETTER TOMORROW',
            'title' => 'Empowering',
            'highlight_text' => 'Future Leaders',
            'description' => 'At JRS International School, we inspire curiosity, creativity and compassion. A place where every child discovers their potential and shines in their own unique way.',
            'primary_button_text' => 'Admissions 2026-27',
            'primary_button_url' => null,
            'secondary_button_text' => 'Take a Virtual Tour',
            'secondary_button_url' => 'https://jrs-school.vercel.app/#tour',
            'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1920&auto=format&fit=crop',
            'contact_phone' => '+91 91574 04321',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HeroSlider::create([
            'badge_title' => 'WORLD-CLASS CBSE CURRICULUM • HOLISTIC EDUCATION',
            'title' => 'Inspiring Excellence in',
            'highlight_text' => 'Every Student',
            'description' => 'State-of-the-art smart classrooms, world-class athletic facilities, and dedicated mentorship helping students excel academically and beyond.',
            'primary_button_text' => 'Explore Campus',
            'primary_button_url' => null,
            'secondary_button_text' => 'Contact Admissions',
            'secondary_button_url' => 'https://jrs-school.vercel.app/#contact',
            'image_path' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1920&auto=format&fit=crop',
            'contact_phone' => '+91 91574 04321',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
