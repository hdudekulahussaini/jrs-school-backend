<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AmenityCta;

class AmenityCtaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AmenityCta::updateOrCreate(
            ['id' => 1],
            [
                'badge' => 'JOIN THE JRS JOURNEY',
                'title' => 'We Invite Everyone To Join Us On Our Journey Towards Excellence.',
                'highlight_text' => 'Excellence.',
                'description' => 'Experience our vibrant learning atmosphere, state-of-the-art facilities, and nurturing environment firsthand.',
                'primary_button_text' => 'Book a Campus Tour &rarr;',
                'primary_button_url' => '/campus-tour',
                'secondary_button_text' => 'Contact School',
                'secondary_button_url' => '/contact',
                'image_path' => '/images/amenities/cta-banner.png',
                'bg_color' => '#031c3f',
                'is_active' => true,
            ]
        );
    }
}
