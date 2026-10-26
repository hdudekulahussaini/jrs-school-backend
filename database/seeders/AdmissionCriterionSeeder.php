<?php

namespace Database\Seeders;

use App\Models\AdmissionCriterion;
use Illuminate\Database\Seeder;

class AdmissionCriterionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            [
                'step_number' => 1,
                'badge_tag'   => 'Early Years (Age 2+)',
                'title'       => 'Nursery Admission',
                'description' => 'You can apply for a place in our Nursery by filling in an application form available from the school office or online. Children are admitted to Nursery the term after their second birthday.',
                'icon'        => 'bi bi-stars',
                'note'        => null,
                'points'      => [
                    'Proof of address & birth certificate required',
                    'Campus visits welcome to meet our caring staff',
                ],
            ],
            [
                'step_number' => 2,
                'badge_tag'   => 'Grades 1 to 12',
                'title'       => 'Competency Level Test (CLT)',
                'description' => 'Applicants seeking admission to Grades 1 to 12 will be required to appear for a Competency Level Test (CLT).',
                'icon'        => 'bi bi-clipboard-check-fill',
                'note'        => 'Note: The sole purpose of CLT is to rightly assess the grade for which the child is eligible rather than to grant or refuse admission.',
                'points'      => [],
            ],
            [
                'step_number' => 3,
                'badge_tag'   => 'Fair & Transparent',
                'title'       => 'Seat Allocation & Waitlist Policy',
                'description' => 'Admission will be offered only on a first-come, first-served basis. If no seats are available at the time the application is received, the applicant will be placed on the waitlist.',
                'icon'        => 'bi bi-people-fill',
                'note'        => null,
                'points'      => [
                    'Offered strictly on a first-come, first-served basis',
                    'Parents/Guardians notified promptly once a seat opens',
                ],
            ],
            [
                'step_number' => 4,
                'badge_tag'   => 'Guidance & Appeals',
                'title'       => 'Admissions Appeals & Support',
                'description' => 'Information on admissions appeals and procedural guidelines is readily available from the school office. Our team is here to assist you at every stage of the application.',
                'icon'        => 'bi bi-file-earmark-text-fill',
                'note'        => null,
                'points'      => [
                    'Appeals assistance available at school office',
                    'Transparent review and parent guidance',
                ],
            ],
        ];

        foreach ($criteria as $item) {
            AdmissionCriterion::updateOrCreate(
                ['step_number' => $item['step_number']],
                $item
            );
        }
    }
}
