<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdmissionStep;

class AdmissionStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            [
                'step_number'  => 1,
                'title'        => 'Meet The Admission Officer',
                'description'  => 'Visit the school campus and meet our admission officer for guidance.',
                'icon'         => 'bi bi-person-badge-fill',
            ],
            [
                'step_number'  => 2,
                'title'        => 'Procure The Application Form',
                'description'  => 'Collect the application form from the school or download it as provided.',
                'icon'         => 'bi bi-file-earmark-text-fill',
            ],
            [
                'step_number'  => 3,
                'title'        => 'Register With Us',
                'description'  => 'Submit the completed application form with the required details.',
                'icon'         => 'bi bi-person-vcard-fill',
            ],
            [
                'step_number'  => 4,
                'title'        => 'Appear For The Admission Test',
                'description'  => 'The student needs to appear for the admission test as per the grade.',
                'icon'         => 'bi bi-pencil-square',
            ],
            [
                'step_number'  => 5,
                'title'        => 'Appear For The Personal Interview',
                'description'  => 'The student and parents may be called for a personal interview.',
                'icon'         => 'bi bi-chat-quote-fill',
            ],
            [
                'step_number'  => 6,
                'title'        => 'Pay Fee',
                'description'  => 'Upon selection, complete the fee payment to confirm admission.',
                'icon'         => 'bi bi-credit-card-2-front-fill',
            ],
        ];

        foreach ($steps as $data) {
            AdmissionStep::updateOrCreate(
                ['step_number' => $data['step_number']],
                $data
            );
        }
    }
}
