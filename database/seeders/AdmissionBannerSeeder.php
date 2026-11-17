<?php

namespace Database\Seeders;

use App\Models\AdmissionBanner;
use Illuminate\Database\Seeder;

class AdmissionBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdmissionBanner::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Give Your Child A Strong Foundation',
                'title_highlight' => 'For Tomorrow',
                'description' => 'Join JRS International School and be a part of a nurturing environment that shapes confident, responsible and future-ready individuals.',
                'primary_button_text' => 'Enquire for Admission',
                'secondary_button_text' => 'Take a Campus Tour',
                'secondary_button_link' => 'https://jrs-school.vercel.app/#tour',
                'image_path' => 'images/beyond/science-lab.jpg',
                'is_active' => true,
            ]
        );
    }
}
