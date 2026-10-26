<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationalSocietyMember;

class EducationalSocietyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Mr. C. R. Jagadish',
                'designation' => 'PRESIDENT',
                'address' => 'Karthikeya Nagar, Nacharam, Hyderabad',
                'phone' => '9542664980',
            ],
            [
                'name' => 'Ms. V. Jyothi',
                'designation' => 'VICE-PRESIDENT',
                'address' => '12-13-415/3 Tarnaka, Secunderabad',
                'phone' => '9666312947',
            ],
            [
                'name' => 'Ms. C. Amaravathi',
                'designation' => 'GENERAL SECRETARY',
                'address' => 'Karthikeya Nagar, Nacharam, Hyderabad',
                'phone' => '9346065525',
            ],
            [
                'name' => 'Dr. C. Suman Kumar',
                'designation' => 'JOINT-SECRETARY',
                'address' => 'Boduppal, Hyderabad',
                'phone' => '9926811371',
            ],
            [
                'name' => 'Ms. V. Vedavathi',
                'designation' => 'TREASURER',
                'address' => 'Divya Enclave Vijaypuri, Tarnaka, Hyderabad',
                'phone' => '9160300046',
            ],
            [
                'name' => 'Mr. Sreepathi Rao',
                'designation' => 'EXECUTIVE-MEMBER',
                'address' => 'Uppal, Hyderabad',
                'phone' => '9963701615',
            ],
            [
                'name' => 'Mr. Sudharshan Rao',
                'designation' => 'EXE-MEMBER',
                'address' => 'L.B Nagar, Hyderabad',
                'phone' => '8520047067',
            ],
            [
                'name' => 'Mr. Baskar Reddy',
                'designation' => 'EXE-MEMBER',
                'address' => 'Venkatadri Township, Chowdarguda, Hyderabad',
                'phone' => '9908330490',
            ],
        ];

        foreach ($members as $data) {
            EducationalSocietyMember::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
