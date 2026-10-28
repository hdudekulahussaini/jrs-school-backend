<?php

namespace Database\Seeders;

use App\Models\TopBar;
use Illuminate\Database\Seeder;

class TopBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TopBar::truncate();

        TopBar::create([
            'phone' => '+91 915740 43210',
            'phone_2' => '+91 915740 43211',
            'email' => 'info@jrsinternationalschool.com',
            'cbse_affiliation_text' => 'CBSE Affiliated School',
            'prospectus_title' => 'School Prospectus',
            'prospectus_url' => 'https://jrsinternationalschool.com/school-prospectus.pdf',
            'prospectus_file' => null,
            'is_active' => true,
        ]);
    }
}
