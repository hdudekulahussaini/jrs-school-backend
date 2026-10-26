<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use Illuminate\Database\Seeder;

class ContactInquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'parent_name' => 'Ramesh Reddy',
                'phone'       => '+91 98765 43210',
                'grade'       => 'Grade 4',
                'email'       => 'ramesh.reddy@example.com',
                'message'     => 'We recently shifted to Uppal and would like to know about curriculum details, sports coaching, and transport timings.',
                'status'      => 'pending',
                'notes'       => null,
            ],
            [
                'parent_name' => 'Sunita Rao',
                'phone'       => '+91 91234 56780',
                'grade'       => 'Nursery',
                'email'       => 'sunita.rao@example.com',
                'message'     => 'Looking for preschool and nursery admission for the upcoming academic year. Please schedule an appointment with the counselor.',
                'status'      => 'contacted',
                'notes'       => 'Called parent and briefed about age criteria and curriculum.',
            ],
            [
                'parent_name' => 'Mohammed Farhan',
                'phone'       => '+91 99887 76655',
                'grade'       => 'Grade 8',
                'email'       => 'farhan.m@example.com',
                'message'     => 'Enquiring about CBSE syllabus transfer from another state and required transfer certificate documents.',
                'status'      => 'resolved',
                'notes'       => 'Sent transfer document checklist via email.',
            ],
        ];

        foreach ($samples as $sample) {
            ContactInquiry::firstOrCreate(
                [
                    'phone'       => $sample['phone'],
                    'parent_name' => $sample['parent_name'],
                ],
                $sample
            );
        }
    }
}
