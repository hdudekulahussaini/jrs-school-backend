<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CareerSection;
use App\Models\JobOpening;
use App\Models\CareerBenefit;
use App\Models\CareerOpportunity;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed the Teaching at JRS Overview section (from screenshot)
        CareerSection::updateOrCreate(
            ['id' => 1],
            [
                'badge' => 'TEACHING AT JRS',
                'title' => 'Grow. Teach. Inspire. Make A Difference.',
                'highlight_1' => 'Inspire.',
                'highlight_2' => 'Difference.',
                'description' => 'We believe that the teacher community at JRS is our unique asset. Here, teachers are given the push to innovate, create, and approach teaching methodology through interactive and research-based methods. Teacher Development programs are constantly conducted to enhance our teachers with the latest developments in the field of education. Teacher seminars, events, and workshops are organized on-campus periodically through professional training centers.',
                'image_path' => '/images/careers/teaching-at-jrs.png',
                'apply_email' => 'careers@jrsschool.com',
                'apply_phone' => '+91 98765 43210',
                'is_active' => true,
            ]
        );

        // 2. Seed Work Culture & Benefits items (from Why Join JRS? screenshot)
        CareerBenefit::truncate();

        $benefits = [
            [
                'icon' => 'users',
                'title' => 'Collaborative Community',
                'description' => 'Work with passionate educators and supportive leadership.',
                'badge' => 'WORK CULTURE & BENEFITS',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'graduation-cap',
                'title' => 'Continuous Growth',
                'description' => 'Access to training, seminars and professional development programs.',
                'badge' => 'WORK CULTURE & BENEFITS',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'lightbulb',
                'title' => 'Innovative Teaching',
                'description' => 'Use modern tools and research-based methods in the classroom.',
                'badge' => 'WORK CULTURE & BENEFITS',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'icon' => 'star',
                'title' => 'Make A Difference',
                'description' => 'Be part of a mission to create confident, ethical and future-ready students.',
                'badge' => 'WORK CULTURE & BENEFITS',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($benefits as $benefit) {
            CareerBenefit::create($benefit);
        }

        // 3. Seed Career Opportunities & How To Apply section (from screenshot)
        CareerOpportunity::updateOrCreate(
            ['id' => 1],
            [
                'badge' => 'CAREER OPPORTUNITIES',
                'title' => 'Who Are Passionate About Their Field –',
                'highlight_title' => 'A Great Future Awaits You At JRS',
                'description' => "At JRS we are looking for professionals who understand and believe in our philosophy. People who are genuinely interested in creating students who are world-ready, in sync with today's technology and backed by the Indian value system.",
                'card_badge' => 'APPLICATION PROCESS',
                'card_title' => 'How To Apply',
                'card_description' => 'If you are looking for an opportunity to work at JRS International School, please send your resume to:',
                'email' => 'hrjrshyd@gmail.com',
                'checklist_title' => 'Please Ensure You Mention:',
                'checklist_items' => [
                    'Contact number',
                    'Experience, subjects taught along with the curriculum followed by the school or the position & nature of work in the prior organization.',
                    'Your resume should mention educational degrees and the subjects you graduated in.'
                ],
                'is_active' => true,
            ]
        );

        // 4. Seed default job openings
        JobOpening::truncate();

        $openings = [
            [
                'title' => 'Primary English Educator',
                'department' => 'Academics - Primary Wing',
                'job_type' => 'Full-Time',
                'experience' => '2-4 Years',
                'qualification' => 'B.A. / M.A. in English with B.Ed',
                'description' => 'Seeking a passionate English educator to guide primary learners with creative communication, phonics, and holistic language skills.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'TGT Mathematics Teacher',
                'department' => 'Academics - Middle & High School',
                'job_type' => 'Full-Time',
                'experience' => '3-5 Years',
                'qualification' => 'B.Sc / M.Sc Mathematics with B.Ed',
                'description' => 'Responsible for teaching curriculum mathematics, analytical problem solving, and preparing students for competitive Olympiads.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Physical Education & Sports Coach',
                'department' => 'Sports & Athletics',
                'job_type' => 'Full-Time',
                'experience' => '2+ Years',
                'qualification' => 'B.P.Ed / M.P.Ed',
                'description' => 'Training students across track, swimming, basketball, and athletic wellness with modern physical training regimens.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Computer Science & STEM Instructor',
                'department' => 'Digital & Innovation',
                'job_type' => 'Full-Time',
                'experience' => '2-5 Years',
                'qualification' => 'BCA / MCA / B.Tech Computer Science',
                'description' => 'Leading hands-on coding, robotics, basic AI literacy, and computer applications in state-of-the-art labs.',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($openings as $opening) {
            JobOpening::create($opening);
        }
    }
}
