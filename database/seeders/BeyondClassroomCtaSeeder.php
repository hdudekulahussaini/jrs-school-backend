<?php

namespace Database\Seeders;

use App\Models\BeyondClassroomCta;
use Illuminate\Database\Seeder;

class BeyondClassroomCtaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeyondClassroomCta::updateOrCreate(
            ['id' => 1],
            [
                'badge' => 'Admissions Open 2026-27',
                'title' => 'Give Your Child A Strong Foundation',
                'highlight_text' => 'For Tomorrow',
                'description' => 'Join JRS International School and be a part of a nurturing environment that shapes confident, responsible and future-ready individuals.',
                'primary_button_text' => 'Enquire for Admission',
                'primary_button_url' => '/admissions',
                'secondary_button_text' => 'Take a Campus Tour',
                'secondary_button_url' => '/campus-tour',
                'image_path' => '/images/beyond/cta-banner.png',
                'bg_color' => '#031c3f',
                'is_active' => true,
            ]
        );
    }
}
