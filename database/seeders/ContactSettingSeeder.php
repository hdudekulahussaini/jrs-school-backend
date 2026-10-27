<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSetting::updateOrCreate(
            ['id' => 1],
            [
                'address'       => 'JRS International School, Narapally, Near Uppal Depot, Hyderabad, Telangana',
                'phone'         => '+91 915740 43210',
                'email'         => 'info@jrsinternationalschool.com',
                'map_link'      => 'https://maps.google.com/?q=JRS+International+School+Narapally+Hyderabad',
                'facebook_url'  => 'https://www.facebook.com/jrsinternationalschool',
                'instagram_url' => 'https://www.instagram.com/jrsinternationalschool',
                'twitter_url'   => 'https://x.com/jrs_school',
                'youtube_url'   => 'https://www.youtube.com/@jrsinternationalschool',
                'linkedin_url'  => 'https://www.linkedin.com/company/jrs-international-school',
            ]
        );
    }
}
