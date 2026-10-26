<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolManagementMember;

class SchoolManagementMemberSeeder extends Seeder
{
    /**
     * Run the database seeds for School Management Committee (SMC).
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Mrs. Jagadishwari Devi',
                'designation' => 'CHAIRMAN',
                'address' => 'Divya Enclave Vijaypuri Tarnaka, Hyderabad',
                'phone' => '9160300046',
            ],
            [
                'name' => 'Mr. C. R. Jagadish',
                'designation' => 'MEMBER',
                'address' => 'Karthikeya Nagar Nacharam, Hyderabad',
                'phone' => '9542664980',
            ],
            [
                'name' => 'Mrs. Jyothi',
                'designation' => 'MEMBER',
                'address' => '12-13-415/3 Tarnaka, Secunderabad',
                'phone' => '9666312947',
            ],
            [
                'name' => 'Mr. Vijay Bhaskar',
                'designation' => 'MEMBER',
                'address' => 'Venkatadri Township Chowdarguda, Hyderabad',
                'phone' => '9908330490',
            ],
            [
                'name' => 'Mr. Ashok',
                'designation' => 'MEMBER',
                'address' => 'Sai Enclave, Narapally, Hyderabad',
                'phone' => '9949845482',
            ],
            [
                'name' => 'Mrs B. Sheetal',
                'designation' => 'MEMBER',
                'address' => 'Venkatadri Township Chowdarguda, Hyderabad',
                'phone' => '8309981778',
            ],
            [
                'name' => 'Mrs Nagasunitha',
                'designation' => 'MEMBER',
                'address' => 'Muthvelliguda, Hyderabad',
                'phone' => '8897503215',
            ],
            [
                'name' => 'Dr. VinayShree',
                'designation' => 'MEMBER',
                'address' => 'Siddhartha School Boduppal, Hyderabad',
                'phone' => '9502499979',
            ],
            [
                'name' => 'Mr. Narsing Rao',
                'designation' => 'MEMBER',
                'address' => 'Sivaji Vidya Peeth School, Hyderabad',
                'phone' => '9963701615',
            ],
            [
                'name' => 'Dr Srinivas',
                'designation' => 'MEMBER',
                'address' => 'Venkatadri Township Chowdarguda, Hyderabad',
                'phone' => '9912712798',
            ],
            [
                'name' => 'Dr. Anil Kumar',
                'designation' => 'MEMBER',
                'address' => 'Boduppal, Hyderabad',
                'phone' => '9926811371',
            ],
        ];

        foreach ($members as $data) {
            SchoolManagementMember::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
