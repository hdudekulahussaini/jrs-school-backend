<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrincipalMessage;

class PrincipalMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paragraph = "Welcome to JRS International School, where we are committed to “Empowering Minds and Enriching Lives.” We believe that every child has unique potential, and meaningful education is about discovering, nurturing and transforming that potential into purpose.\n\nAt JRS, we go beyond academic excellence to develop curious thinkers, confident communicators, compassionate individuals and responsible global citizens. Through strong academics, innovative pedagogy, technology-enabled learning, AI, robotics and experiential opportunities, we create an environment where students are encouraged to question, explore, create and lead.\n\nOur focus extends beyond the classroom. We nurture character, values, leadership, creativity, collaboration and resilience, preparing our students not simply for examinations, but for life.\n\nWith the partnership of our dedicated teachers and supportive parents, we strive to provide every learner with the confidence, knowledge and values needed to embrace the opportunities of tomorrow.";

        PrincipalMessage::firstOrCreate(
            ['name' => 'Mrs. Marlene Mannas'],
            [
                'desk_title' => 'FROM THE DESK OF',
                'desk_subtitle' => 'The Principal, JRS International School',
                'official_address_badge' => 'OFFICIAL ADDRESS',
                'academic_year' => 'Academic Year 2026 – 2027',

                'section_badge' => "PRINCIPAL'S MESSAGE",
                'title' => 'Empowering Minds And Enriching Lives',
                'salutation' => 'Dear Parents, Students And Well-Wishers,',

                'card_badge' => 'PRINCIPAL',
                'profile_badge' => 'ACADEMIC LEADERSHIP',
                'name' => 'Mrs. Marlene Mannas',
                'sub_title' => 'Principal, JRS International School',
                'image_path' => null,

                'paragraph' => $paragraph,
                'quote' => '“At JRS, we don\'t just prepare students for the future—we empower them to shape it.”',

                'signoff_note' => 'WARM REGARDS,',
                'signoff_signature' => 'Marlene Mannas',
                'signoff_name' => 'Mrs. Marlene Mannas',
                'signoff_sub' => 'Principal, JRS International School',

                'is_active' => true,
            ]
        );
    }
}
