<?php

namespace Database\Seeders;

use App\Models\AdmissionEnquiry;
use Illuminate\Database\Seeder;

class AdmissionEnquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'academic_year'  => '2026-2027',
                'branch'         => 'JRS INTERNATIONAL SCHOOL',
                'admission_type' => 'DAY SCHOLAR',
                'grade'          => 'Class 1',
                'country_code'   => '+91',
                'parent_mobile'  => '9876543210',
                'student_dob'    => '2020-04-15',
                'status'         => 'pending',
                'notes'          => 'Parent enquired about transport facility from Uppal.',
            ],
            [
                'academic_year'  => '2026-2027',
                'branch'         => 'JRS INTERNATIONAL SCHOOL',
                'admission_type' => 'DAY SCHOLAR',
                'grade'          => 'Nursery',
                'country_code'   => '+91',
                'parent_mobile'  => '9988776655',
                'student_dob'    => '2023-01-10',
                'status'         => 'contacted',
                'notes'          => 'Spoke with father. Scheduled campus tour this Saturday 11 AM.',
            ],
            [
                'academic_year'  => '2026-2027',
                'branch'         => 'JRS INTERNATIONAL SCHOOL',
                'admission_type' => 'RESIDENTIAL',
                'grade'          => 'Class 6',
                'country_code'   => '+91',
                'parent_mobile'  => '9123456789',
                'student_dob'    => '2014-08-22',
                'status'         => 'admitted',
                'notes'          => 'Assessment test completed. Registration fee paid.',
            ],
        ];

        foreach ($samples as $sample) {
            AdmissionEnquiry::firstOrCreate(
                [
                    'parent_mobile' => $sample['parent_mobile'],
                    'grade'         => $sample['grade'],
                ],
                $sample
            );
        }
    }
}
