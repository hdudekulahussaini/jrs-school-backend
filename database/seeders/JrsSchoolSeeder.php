<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\NewsTicker;
use App\Models\HeroSlide;
use App\Models\SchoolEvent;
use App\Models\AcademicStage;
use App\Models\Facility;
use App\Models\SchoolStat;
use App\Models\SchoolSetting;
use App\Models\AdmissionEnquiry;
use App\Models\ContactMessage;

class JrsSchoolSeeder extends Seeder
{
    /**
     * Seed initial content for JRS International School.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@jrsschool.com'],
            [
                'name' => 'JRS School Administrator',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. News Tickers
        $tickers = [
            [
                'title' => 'Admissions Open for Academic Year 2026–2027 (Nursery to Grade XII) — Enroll Today!',
                'link_url' => '/admissions',
                'is_highlighted' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'CBSE Curriculum with State-of-the-Art STEM, Robotics & AI Labs',
                'link_url' => '/academics',
                'is_highlighted' => true,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Download Official School Prospectus & Admission Guidelines (PDF)',
                'link_url' => 'https://jrsinternationalschooluppal.com/wp-content/uploads/2022/01/Brochure-2020-JRS.pdf',
                'is_highlighted' => false,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Campus Tours & Personalized Counseling Sessions Available at Narapally Campus',
                'link_url' => '/contact',
                'is_highlighted' => true,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Admissions Helpline: +91 91009 55555 / +91 91009 66666 | Email: admissions@jrsinternationalschool.com',
                'link_url' => 'tel:+919100955555',
                'is_highlighted' => false,
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($tickers as $ticker) {
            NewsTicker::updateOrCreate(['title' => $ticker['title']], $ticker);
        }

        // 3. Hero Slides
        $heroSlides = [
            [
                'badge_text' => 'NURTURING BRIGHT MINDS • BUILDING A BETTER TOMORROW',
                'title_line1' => 'Empowering',
                'title_line2' => 'Future Leaders',
                'description' => 'At JRS International School, we inspire curiosity, creativity and compassion. A place where every child discovers their potential and shines in their own unique way.',
                'cta_primary_text' => 'Admissions 2026-27',
                'cta_primary_link' => '/admissions',
                'cta_secondary_text' => 'Take a Virtual Tour',
                'cta_secondary_link' => '#virtual-tour',
                'image_url' => '/images/hero image.png',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'badge_text' => 'HOLISTIC CBSE CURRICULUM • WORLD-CLASS CAMPUS',
                'title_line1' => 'Inspiring Excellence',
                'title_line2' => 'In Every Child',
                'description' => 'State-of-the-art STEM labs, sprawling sports fields, and passionate educators dedicated to shaping globally confident leaders.',
                'cta_primary_text' => 'Explore Academics',
                'cta_primary_link' => '/academics',
                'cta_secondary_text' => 'Enquire Now',
                'cta_secondary_link' => '/admissions#enquiry-form',
                'image_url' => '/images/heroslider3.png',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($heroSlides as $slide) {
            HeroSlide::updateOrCreate(['title_line1' => $slide['title_line1'], 'title_line2' => $slide['title_line2']], $slide);
        }

        // 4. Academic Stages
        $stages = [
            [
                'stage_number' => 'STAGE 01 • EARLY YEARS',
                'title' => 'Pre-Primary',
                'subtitle' => 'NURSERY, LKG & UKG',
                'description' => 'Feel grounded and supported in an environment where early learners are encouraged to participate, share ideas, explore phonics, and build confidence through play.',
                'key_features' => [
                    'Phonics-based English language & early communication',
                    'Montessori-inspired sensorial and tactile activities',
                    'Early numeracy, number sense and playful logical thinking'
                ],
                'image_url' => '/images/pre-primary-learning.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'stage_number' => 'STAGE 02 • PRIMARY FOUNDATION',
                'title' => 'Primary School',
                'subtitle' => 'GRADE I TO GRADE V',
                'description' => 'Instilling core academic concepts, creative thinking, inquiry-based scientific exploration, and foundational communicative strength in young scholars.',
                'key_features' => [
                    'Core literacy, numeracy, and conceptual scientific inquiry',
                    'Integrated STEM & hands-on environmental exploration',
                    'Creative expressions through music, fine arts, and drama'
                ],
                'image_url' => '/images/primary-school-study.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'stage_number' => 'STAGE 03 • MIDDLE YEARS',
                'title' => 'Middle School',
                'subtitle' => 'GRADE VI TO GRADE VIII',
                'description' => 'Empowering teenagers with deep analytical comprehension, scientific rigor, leadership opportunities, and specialized coaching for competitive excellence.',
                'key_features' => [
                    'Advanced science laboratories & computer programming',
                    'Critical thinking, analytical debates, and collaborative problem solving',
                    'Sports training, leadership clubs, and community initiatives'
                ],
                'image_url' => '/images/about-students.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($stages as $stage) {
            AcademicStage::updateOrCreate(['title' => $stage['title']], $stage);
        }

        // 5. Facilities
        $facilities = [
            [
                'title' => 'Smart Classrooms',
                'description' => 'Interactive digital boards, ergonomic seating, and audio-visual pedagogical systems for engaging lessons.',
                'icon_name' => 'monitor',
                'image_url' => '/images/smart-classroom.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Science & Robotics Labs',
                'description' => 'Advanced Physics, Chemistry, Biology, and AI Robotics labs enabling hands-on STEM experiments.',
                'icon_name' => 'flask-conical',
                'image_url' => '/images/science-lab.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Library & Knowledge Hub',
                'description' => 'Extensive collection of books, reference materials, periodicals, and e-learning terminals.',
                'icon_name' => 'book-open',
                'image_url' => '/images/library.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Sports & Athletics Arena',
                'description' => 'Full-size football turf, cricket practice nets, basketball court, skating rink, and indoor games.',
                'icon_name' => 'trophy',
                'image_url' => '/images/sports-ground.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Safe & Secure Transport',
                'description' => 'Fleet of GPS-tracked AC buses equipped with CCTV cameras, speed governors, and trained attendants.',
                'icon_name' => 'bus',
                'image_url' => '/images/bus-transport.jpg',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(['title' => $facility['title']], $facility);
        }

        // 6. School Stats
        $stats = [
            ['label' => 'Year Established', 'value' => '2021', 'icon' => 'calendar', 'sort_order' => 1],
            ['label' => 'Happy Students', 'value' => '1000+', 'icon' => 'users', 'sort_order' => 2],
            ['label' => 'Expert Educators', 'value' => '50+', 'icon' => 'award', 'sort_order' => 3],
            ['label' => 'Co-curricular Activities', 'value' => '100+', 'icon' => 'sparkles', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            SchoolStat::updateOrCreate(['label' => $stat['label']], $stat);
        }

        // 7. What's Happening Events
        $events = [
            [
                'title' => 'Grand Annual Day & Cultural Fest 2026',
                'category' => 'Cultural Celebration',
                'event_date' => '2026-11-15',
                'description' => 'A vibrant showcase of musical melodies, classical dance performances, and theatrical stage plays presented by students from Nursery to Grade XII.',
                'image_url' => '/images/event1.jpg',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Inter-School Sports Carnival & Athletics Meet',
                'category' => 'Sports',
                'event_date' => '2026-11-28',
                'description' => 'Fierce competition and true sportsmanship across track and field events, basketball, cricket, and martial arts championships.',
                'image_url' => '/images/event2.jpg',
                'is_featured' => true,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'STEM & Robotics Innovation Expo',
                'category' => 'Academics & Tech',
                'event_date' => '2026-12-05',
                'description' => 'Young student inventors presenting AI prototypes, sustainable energy solutions, and automated robotics to parents and visiting tech leaders.',
                'image_url' => '/images/event3.jpg',
                'is_featured' => true,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($events as $event) {
            SchoolEvent::updateOrCreate(['title' => $event['title']], $event);
        }

        // 8. General Settings
        $settings = [
            'school_name' => 'JRS International School',
            'tagline' => 'Empowering Future Leaders',
            'phone' => '+91 915740 43210',
            'email' => 'info@jrsinternationalschool.com',
            'admissions_phone_1' => '+91 91009 55555',
            'admissions_phone_2' => '+91 91009 66666',
            'admissions_email' => 'admissions@jrsinternationalschool.com',
            'campus_address' => 'Survey No. 44 & 45, Narapally, Near Uppal, Hyderabad, Telangana - 500098',
            'affiliation_text' => 'CBSE Affiliated Senior Secondary School',
            'prospectus_url' => 'https://jrsinternationalschooluppal.com/wp-content/uploads/2022/01/Brochure-2020-JRS.pdf',
            'academic_year' => '2026-2027',
        ];

        foreach ($settings as $key => $value) {
            SchoolSetting::set($key, $value);
        }

        // 9. Sample Admission Enquiries
        $enquiries = [
            [
                'parent_name' => 'Rajesh Sharma',
                'student_name' => 'Aarav Sharma',
                'email' => 'rajesh.sharma@example.com',
                'phone' => '+91 98765 43210',
                'grade_applying' => 'Grade I',
                'academic_year' => '2026-2027',
                'city' => 'Hyderabad',
                'message' => 'Interested in campus tour and bus transport details for Uppal route.',
                'status' => 'new',
                'admin_notes' => 'Called parent on 23rd Oct, requested weekend tour.',
            ],
            [
                'parent_name' => 'Sunita Reddy',
                'student_name' => 'Ananya Reddy',
                'email' => 'sunita.reddy@example.com',
                'phone' => '+91 98480 12345',
                'grade_applying' => 'Nursery',
                'academic_year' => '2026-2027',
                'city' => 'Narapally',
                'message' => 'Looking for early childhood curriculum details and admission fee structure.',
                'status' => 'contacted',
                'admin_notes' => 'Fee prospectus sent via WhatsApp and email.',
            ],
            [
                'parent_name' => 'Mohammed Farhan',
                'student_name' => 'Zayd Farhan',
                'email' => 'm.farhan@example.com',
                'phone' => '+91 97001 88990',
                'grade_applying' => 'Grade VI',
                'academic_year' => '2026-2027',
                'city' => 'Secunderabad',
                'message' => 'Transferring from another CBSE school due to relocation. Want to know about sports coaching.',
                'status' => 'scheduled_tour',
                'admin_notes' => 'Campus tour scheduled for Saturday 11:00 AM.',
            ],
        ];

        foreach ($enquiries as $enquiry) {
            AdmissionEnquiry::updateOrCreate(
                ['email' => $enquiry['email'], 'student_name' => $enquiry['student_name']],
                $enquiry
            );
        }

        // 10. Sample Contact Message
        ContactMessage::updateOrCreate(
            ['email' => 'contact.parent@example.com'],
            [
                'name' => 'Kavitha Rao',
                'phone' => '+91 99887 66554',
                'subject' => 'Uniform and Book Store Inquiry',
                'message' => 'Kindly let us know the schedule for school uniform measurements and textbook collection.',
                'status' => 'unread',
            ]
        );
    }
}
