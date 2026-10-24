<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PtaMember;

class PtaMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PtaMember::truncate();

        $members = [
            [
                'name' => 'Mrs. Jagadishwari Nataraj',
                'designation' => 'CHAIRMAN',
                'address' => 'Divya Enclave Vijaypuri Tarnaka, Hyderabad',
                'phone' => '9160300046',
                'sort_order' => 1,
            ],
            [
                'name' => 'Mrs Amaravathi',
                'designation' => 'MEMBER',
                'address' => 'Karthikeya Nagar Nacharam, Hyderabad',
                'phone' => '9346065525',
                'sort_order' => 2,
            ],
            [
                'name' => 'Mrs Jyothi',
                'designation' => 'MEMBER',
                'address' => '12-13-415/3 Tarnaka Secunderabad',
                'phone' => '9666312947',
                'sort_order' => 3,
            ],
            [
                'name' => 'Mrs Nagasunitha',
                'designation' => 'MEMBER',
                'address' => 'Muthvalliguda Hyderabad',
                'phone' => '8897503215',
                'sort_order' => 4,
            ],
            [
                'name' => 'Mrs P. Bhavani',
                'designation' => 'MEMBER',
                'address' => 'H.No. 1-1-118/A, Ramnagar Hyderabad',
                'phone' => '9949667899',
                'sort_order' => 5,
            ],
            [
                'name' => 'Mr. Saiyam',
                'designation' => 'MEMBER',
                'address' => 'Lal Bazar, Trimulgherry',
                'phone' => '9390212007',
                'sort_order' => 6,
            ],
            [
                'name' => 'Mrs Padmavathi',
                'designation' => 'MEMBER',
                'address' => 'Tarnaka, Hyderabad',
                'phone' => '9989063273',
                'sort_order' => 7,
            ],
            [
                'name' => 'Mrs Mary Shasikala',
                'designation' => 'MEMBER',
                'address' => '12-1-988/44/1 Lalitha Nagar, Hyderabad',
                'phone' => '9666018260',
                'sort_order' => 8,
            ],
            [
                'name' => 'Mr. Raman',
                'designation' => 'MEMBER',
                'address' => '12-1-332/1, Tarnaka, Hyderabad',
                'phone' => '9848126600',
                'sort_order' => 9,
            ],
            [
                'name' => 'Mrs Shradha',
                'designation' => 'MEMBER',
                'address' => '12-1-497/B/5, Lalaguda, Secunderabad',
                'phone' => '9885621457',
                'sort_order' => 10,
            ],
            [
                'name' => 'Mrs Kavita',
                'designation' => 'MEMBER',
                'address' => '12-13-415/3, Tarnaka, Secunderabad',
                'phone' => '9700344791',
                'sort_order' => 11,
            ],
        ];

        foreach ($members as $m) {
            PtaMember::create([
                'name' => $m['name'],
                'designation' => $m['designation'],
                'address' => $m['address'],
                'phone' => $m['phone'],
                'image_path' => null,
                'sort_order' => $m['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
