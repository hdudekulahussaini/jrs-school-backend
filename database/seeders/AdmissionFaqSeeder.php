<?php

namespace Database\Seeders;

use App\Models\AdmissionFaq;
use Illuminate\Database\Seeder;

class AdmissionFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is the admission procedure?',
                'answer'   => 'The admission procedure begins with obtaining and filling out the application form either online or at the school office, followed by an interaction/competency assessment, document verification, and fee payment.',
            ],
            [
                'question' => 'Is admission guaranteed?',
                'answer'   => 'Admission is offered strictly on a first-come, first-served basis, subject to availability of seats and meeting the admission criteria.',
            ],
            [
                'question' => 'What curriculum will the school follow?',
                'answer'   => 'JRS International School follows a comprehensive, child-centered curriculum adhering to CBSE and international educational standards designed for holistic development.',
            ],
            [
                'question' => 'Can I make an early application for admission?',
                'answer'   => 'Yes, parents are encouraged to apply early as admissions are processed on a first-come, first-served basis and seat availability in each grade is limited.',
            ],
            [
                'question' => 'What is the fee structure?',
                'answer'   => 'Our fee structure is transparent and includes tuition, activities, and campus facilities. Please visit the school admissions office or contact us for a detailed grade-wise breakdown.',
            ],
            [
                'question' => 'Can I get fee concessions?',
                'answer'   => 'Fee concessions and scholarships may be considered on merit, sibling enrollment, or specific circumstances as per the school trust guidelines.',
            ],
            [
                'question' => 'How many terms will the school have?',
                'answer'   => 'The academic year is divided into two comprehensive terms: Term 1 (June to October) and Term 2 (November to April).',
            ],
            [
                'question' => 'What will be the school timings?',
                'answer'   => 'School operates from 8:30 AM to 3:30 PM for Primary and Secondary grades, with customized shorter timings for Pre-Primary/Early Years.',
            ],
            [
                'question' => 'Will the school authorities be taking adequate measures to ensure hygiene in the school?',
                'answer'   => 'Yes, we maintain the highest standards of hygiene with regular campus sanitization, clean drinking water filtration systems, and well-maintained washroom facilities.',
            ],
            [
                'question' => 'What is the kind of security offered to the students?',
                'answer'   => 'The campus features 24/7 CCTV surveillance, biometric access control, trained security personnel, visitor logging, and strict bus transport tracking.',
            ],
            [
                'question' => "How often will there be PTM's?",
                'answer'   => 'Parent-Teacher Meetings (PTMs) are scheduled at the end of each term and after major periodic assessments, typically every 6 to 8 weeks.',
            ],
            [
                'question' => 'Other than a PTM, when can a parent interact with the teacher?',
                'answer'   => 'Parents can schedule prior appointments through the school ERP portal or contact teachers during designated weekday visiting hours.',
            ],
            [
                'question' => 'How many students will be there per division?',
                'answer'   => 'To ensure personalized attention, class sizes are strictly maintained at an optimal student-teacher ratio of 25 to 30 students per division.',
            ],
        ];

        foreach ($faqs as $item) {
            AdmissionFaq::updateOrCreate(
                ['question' => $item['question']],
                $item
            );
        }
    }
}
