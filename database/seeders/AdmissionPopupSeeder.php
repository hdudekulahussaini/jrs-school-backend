<?php

namespace Database\Seeders;

use App\Models\AdmissionPopup;
use Illuminate\Database\Seeder;

class AdmissionPopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdmissionPopup::updateOrCreate(
            ['id' => 1],
            [
                'is_active' => true,
                'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1200&auto=format&fit=crop',
                'badge_text' => 'ADMISSIONS OPEN',
                'cbse_affiliation_text' => 'CBSE AFFILIATION: 3630478 • SCHOOL CODE: 56725',
                'school_name' => 'JRS International School',
                'school_location' => 'Narapally, Near Uppal, Hyderabad',
                'academic_year_badge' => 'Academic Year 2027 – 2028',
                'title_prefix' => 'Admissions Open For',
                'academic_year_highlight' => '2027 – 2028',
                'description' => 'Enrolling students from Nursery to Grade XII (Admissions open for 11th & 12th Standard also). Give your child the foundation for academic excellence, character development, and global leadership.',
                'features' => [
                    'CBSE Curriculum with experiential, inquiry-based learning',
                    'STEM, Robotics & Cognospace innovation labs',
                    'World-Class Sports & Co-curricular clubs',
                    'Safe GPS-Enabled Fleet & 100% CCTV secured campus',
                ],
                'phone_number' => '+91 92814 09674',
            ]
        );
    }
}
