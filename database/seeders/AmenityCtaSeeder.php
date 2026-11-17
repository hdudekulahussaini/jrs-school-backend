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
                'is_active' => true,
            ]
        );
    }
}
