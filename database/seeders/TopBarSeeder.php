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
            'phone_href' => 'tel:+9191574043210',
            'email' => 'info@jrsinternationalschool.com',
            'email_href' => 'mailto:info@jrsinternationalschool.com',
            'cbse_affiliation_text' => 'CBSE Affiliated School',
            'cbse_affiliation_code' => 'Affiliation No. 3630372',
            'mandatory_disclosure_title' => 'Mandatory Disclosure',
            'mandatory_disclosure_url' => 'https://jrsinternationalschool.com/mandatory-disclosure.pdf',
            'mandatory_disclosure_file' => null,
            'prospectus_title' => 'School Prospectus',
            'prospectus_url' => 'https://jrsinternationalschool.com/school-prospectus.pdf',
            'prospectus_file' => null,
            'is_active' => true,
        ]);
    }
}
