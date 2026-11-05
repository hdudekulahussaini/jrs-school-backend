<?php

namespace Database\Seeders;

use App\Models\NewsTicker;
use Illuminate\Database\Seeder;

class NewsTickerSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            '★ Admissions Open for Academic Year 2027–2028 (Nursery to Grade XII) — Enroll Today!',
            '★ Admissions Open for 11th & 12th Standard Also — Enroll Today!',
            '★ CBSE Curriculum with State-of-the-Art STEM, Robotics & AI Labs',
            '★ Download Official School Prospectus & Admission Guidelines (PDF)',
            '★ Campus Tours & Personalized Counseling Sessions Available at Narapally Campus',
            '★ Admissions Helpline: +91 92814 09674, +91 92814 09672 | Email: Jrsinternationalschool6@gmail.com',
        ];

        foreach ($announcements as $title) {
            NewsTicker::firstOrCreate(
                ['title' => $title],
                ['pdf_url' => null],
            );
        }
    }
}
