<?php

namespace Database\Seeders;

use App\Models\AcademicJourney;
use Illuminate\Database\Seeder;

class AcademicJourneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journeys = [
            [
                'title' => 'Pre-Primary Programme',
                'age_group' => 'Early Years',
                'lead_text' => 'Inquiry and self-research-based Pre-primary foundation of international quality for the critical early learning years of your child.',
                'description' => 'Children are encouraged to explore phonics, build confidence through guided play, and develop foundational social communication.',
                'highlights' => [
                    'Phonics-based English language & communication',
                    'Montessori sensorial and tactile exploration',
                    'Early numeracy, number sense and playful logic',
                    'Creative expression through music and movement'
                ],
                'icon' => 'bi bi-emoji-smile-fill',
                'image_path' => 'images/journey/pre-primary-learning.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Young Buddies',
                'age_group' => 'Age 2.5 to 3.5 years',
                'lead_text' => 'Experienced and trained staff to help toddlers develop key learning skills through sensory-based learning, healthy habits, and sports activities.',
                'description' => 'Building emotional security, vocabulary, early gross motor coordination, and curiosity in child-centric play spaces.',
                'highlights' => [
                    'Sensory integration & tactile play activities',
                    'Early speech & storytelling circles',
                    'Gross and fine motor skills training',
                    'Social peer bonding and sharing habits'
                ],
                'icon' => 'bi bi-people-fill',
                'image_path' => 'images/journey/young-buddies.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Butterflies Programme',
                'age_group' => 'Age 3.5 to 4.5 years',
                'lead_text' => 'At this age, children are more willing to learn, share and explore. Our staff is trained to teach children different languages, and writing skills and engage them in memory-building activities.',
                'description' => 'Through singing, sports, dancing, and story studios children are encouraged to build their extra-curricular activities. Montessori methods are adopted in teaching.',
                'highlights' => [
                    'Montessori methods adopted in teaching',
                    'Different languages, writing skills & memory-building',
                    'Story studios, singing, sports, and dancing',
                    'Co-curricular and extra-curricular talent building',
                    'Encouraging sharing, active learning, and exploration'
                ],
                'icon' => 'bi bi-stars',
                'image_path' => 'images/journey/butterflies-programme.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Honey Bees Programme',
                'age_group' => 'Age 4.5 to 5.5 years',
                'lead_text' => 'Just like the hardworking honeybee, children build overall skills through hands-on learning, field trips, reading, writing, and early Math and Science.',
                'description' => 'Preparing confident young scholars for formal primary school through bilingual literacy, logical reasoning, and experiential experiments.',
                'highlights' => [
                    'Advanced phonics and independent reading readiness',
                    'Experiential STEM investigations and observations',
                    'Structured sports, yoga, and physical education',
                    'Environmental awareness and community field trips'
                ],
                'icon' => 'bi bi-heart-fill',
                'image_path' => 'images/journey/middle-school-students.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($journeys as $item) {
            AcademicJourney::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
