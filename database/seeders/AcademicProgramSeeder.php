<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicProgram;

class AcademicProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'stage_badge' => 'STAGE 01 • EARLY YEARS',
                'title' => 'Pre-Primary',
                'subtitle' => 'NURSERY, LKG & UKG',
                'description' => 'Feel grounded and supported in an environment where early learners are encouraged to participate, share ideas, explore phonics, and build confidence through play.',
                'highlights' => [
                    'Phonics-based English language & early communication',
                    'Montessori-inspired sensorial and tactile activities',
                    'Early numeracy, number sense and playful logical thinking',
                ],
                'button_text' => 'Explore More',
                'button_url' => 'https://jrs-school.vercel.app/academics',
                'image_path' => '/images/programs/pre-primary.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'stage_badge' => 'STAGE 02 • PRIMARY WING',
                'title' => 'Primary School',
                'subtitle' => 'CLASSES I TO V • CBSE / NCERT',
                'description' => 'Building strong scholastic foundations through hands-on inquiry, experiential STEM learning, bilingual communication, and well-rounded character development.',
                'highlights' => [
                    'Integrated CBSE-aligned NCERT syllabus framework',
                    'Experiential STEM learning and scientific experiments',
                    'Bilingual communication, reading, and creative writing',
                ],
                'button_text' => 'Explore More',
                'button_url' => 'https://jrs-school.vercel.app/academics',
                'image_path' => '/images/programs/primary-school.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'stage_badge' => 'STAGE 03 • MIDDLE WING',
                'title' => 'Middle School',
                'subtitle' => 'CLASSES VI TO VIII • CBSE & IIT/NIT FOUNDATION',
                'description' => 'Encouraging independent analytical thinking, teamwork, advanced science laboratory inquiry, and specialized competitive exam readiness.',
                'highlights' => [
                    'Rigorous CBSE syllabus emphasizing core conceptual depth',
                    'Specialized IIT/NIT and Olympiad foundation preparation',
                    'Practical experiments in modern Science and Computer labs',
                ],
                'button_text' => 'Explore More',
                'button_url' => 'https://jrs-school.vercel.app/academics',
                'image_path' => '/images/programs/middle-school.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($programs as $prog) {
            AcademicProgram::updateOrCreate(
                ['title' => $prog['title']],
                $prog
            );
        }
    }
}
