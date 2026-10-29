<?php

namespace Database\Seeders;

use App\Models\MandatoryDisclosure;
use Illuminate\Database\Seeder;

class MandatoryDisclosureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entries = [
            // ==========================================
            // TABLE TYPE: Table 1 - General Information
            // ==========================================
            [
                'category' => 'general_info',
                's_no'     => '1',
                'title'    => 'Name of the School',
                'value'    => 'JRS INTERNATIONAL SCHOOL',
            ],
            [
                'category' => 'general_info',
                's_no'     => '2',
                'title'    => 'Affiliation No. (if applicable)',
                'value'    => '3630478',
            ],
            [
                'category' => 'general_info',
                's_no'     => '3',
                'title'    => 'School Code (if applicable)',
                'value'    => '56725',
            ],
            [
                'category' => 'general_info',
                's_no'     => '4',
                'title'    => 'Complete Address with Pin Code',
                'value'    => 'Sy. No. 129, Narapally, Korremula Road, Ghatkesar Mandal, Medchal-Malkajgiri District, Hyderabad, Telangana - 500088.',
            ],
            [
                'category' => 'general_info',
                's_no'     => '5',
                'title'    => 'Principal Name & Qualification',
                'value'    => 'Mrs. Marlene Mannas, M.A., B.Ed., PPTC, ECE',
            ],
            [
                'category' => 'general_info',
                's_no'     => '6',
                'title'    => 'School Email ID',
                'value'    => 'Jrsinternationalschool6@gmail.com',
            ],
            [
                'category' => 'general_info',
                's_no'     => '7',
                'title'    => 'Contact Details (Landline / Mobile)',
                'value'    => '+91 92814 09674, +91 92814 09672 / 08415-295555',
            ],

            // ==========================================
            // FEATURE / DOCUMENT TYPE: Table 2 - Documents & Information
            // ==========================================
            [
                'category' => 'document',
                's_no'     => '1',
                'title'    => 'Copies of Affiliation/Upgradation Letter and recent Extension of Affiliation, if any',
            ],
            [
                'category' => 'document',
                's_no'     => '2',
                'title'    => 'Copies of Societies/Trust/Company Registration/Renewal Certificate, as applicable',
            ],
            [
                'category' => 'document',
                's_no'     => '3',
                'title'    => 'Copy of No Objection Certificate (NOC) issued, if applicable, by the State Govt./UT',
            ],
            [
                'category' => 'document',
                's_no'     => '4',
                'title'    => 'Copies of Recognition Certificate under RTE Act, 2009, and its renewal if applicable',
            ],
            [
                'category' => 'document',
                's_no'     => '5',
                'title'    => 'Copy of valid Building Safety Certificate as per the National Building Code',
            ],
            [
                'category' => 'document',
                's_no'     => '6',
                'title'    => 'Copy of valid Fire Safety Certificate issued by the competent authority',
            ],
            [
                'category' => 'document',
                's_no'     => '7',
                'title'    => 'Copy of the DEO Certificate submitted by the school for Affiliation / Upgradation / Extension of Affiliation or Self Certification by School',
            ],
            [
                'category' => 'document',
                's_no'     => '8',
                'title'    => 'Copies of valid Water, Health and Sanitation Certificates',
            ],
            [
                'category' => 'document',
                's_no'     => '9',
                'title'    => 'Copies of valid Certificate of Land (as per CBSE Affiliation Norms)',
            ],

            // ==========================================
            // ==========================================
            // TABLE TYPE: Table 3 - School Infrastructure
            // ==========================================
            [
                'category'     => 'infrastructure',
                's_no'         => '1',
                'title'        => 'Total Campus Area of the School',
                'value'        => '12,477 Sq. Mtr. (3.08 Acres)',
                'button_label' => 'Land Certificate',
                'file_path'    => null,
                'file_url'     => 'https://jrsschool.com/docs/land-certificate.pdf',
            ],
            [
                'category'     => 'infrastructure',
                's_no'         => '2',
                'title'        => 'No. and Size of Classrooms (Sq. Mtr.)',
                'value'        => '22 Classrooms (48 Sq. Mtr. each)',
                'button_label' => null,
                'file_path'    => null,
                'file_url'     => null,
            ],
            [
                'category'     => 'infrastructure',
                's_no'         => '3',
                'title'        => 'No. and Size of Laboratories including Computer Labs (Sq. Mtr.)',
                'value'        => '4 Laboratories (46 Sq. Mtr. each)',
                'button_label' => null,
                'file_path'    => null,
                'file_url'     => null,
            ],
            [
                'category'     => 'infrastructure',
                's_no'         => '4',
                'title'        => 'Internet Facility',
                'value'        => 'Yes',
                'button_label' => null,
                'file_path'    => null,
                'file_url'     => null,
            ],
            [
                'category'     => 'infrastructure',
                's_no'         => '5',
                'title'        => 'No. of Girls Toilets',
                'value'        => '20',
                'button_label' => null,
                'file_path'    => null,
                'file_url'     => null,
            ],
            [
                'category'     => 'infrastructure',
                's_no'         => '6',
                'title'        => 'No. of Boys Toilets',
                'value'        => '20',
                'button_label' => null,
                'file_path'    => null,
                'file_url'     => null,
            ],
            [
                'category'     => 'infrastructure',
                's_no'         => '7',
                'title'        => 'Link of YouTube Video of inspection of school infrastructure',
                'value'        => null,
                'button_label' => 'Watch Video',
                'file_path'    => null,
                'file_url'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],

            // ==========================================
            // FEATURE / DOCUMENT TYPE: Table 4 - School Management Committee
            // ==========================================
            [
                'category'     => 'smc',
                's_no'         => '1',
                'title'        => 'SCHOOL MANAGEMENT COMMITTEE (SMC) DETAILS & LIST OF MEMBERS',
                'value'        => null,
                'button_label' => 'View SMC Details',
                'file_path'    => null,
                'file_url'     => 'https://jrsschool.com/docs/smc-committee-members.pdf',
                'sort_order'   => 1,
                'is_active'    => true,
            ],
            [
                'category'     => 'smc',
                's_no'         => '2',
                'title'        => 'PARENTS TEACHERS ASSOCIATION (PTA) COMMITTEE DETAILS',
                'value'        => null,
                'button_label' => 'View PTA Committee',
                'file_path'    => null,
                'file_url'     => 'https://jrsschool.com/docs/pta-members-list.pdf',
                'sort_order'   => 2,
                'is_active'    => true,
            ],
        ];

        foreach ($entries as $entry) {
            if ($entry['category'] === 'general_info') {
                $entry['button_label'] = null;
                $entry['file_path'] = null;
                $entry['file_url'] = null;
            } elseif ($entry['category'] === 'document') {
                $entry['value'] = null;
                $entry['button_label'] = null;
                $entry['file_url'] = null;
            }

            MandatoryDisclosure::updateOrCreate(
                [
                    'category' => $entry['category'],
                    's_no'     => $entry['s_no'],
                ],
                $entry
            );
        }
    }
}
