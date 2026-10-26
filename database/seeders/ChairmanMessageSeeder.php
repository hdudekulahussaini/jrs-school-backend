<?php

namespace Database\Seeders;

use App\Models\ChairmanMessage;
use Illuminate\Database\Seeder;

class ChairmanMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChairmanMessage::firstOrCreate(
            ['id' => 1],
            [
                // Section 1: Address & Leadership Profile
                'section_badge' => "CHAIRMAN'S ADDRESS",
                'title' => 'Empowering Young Minds For A Changing World',
                'profile_badge' => 'FOUNDING LEADERSHIP',
                'name' => 'Chairman Of JRS',
                'sub_title' => 'JRS International School • Hyderabad',
                'quote' => '“Nurturing Tomorrow\'s Leaders with Global Competence & Indian Values”',
                'image_path' => null,
                'paragraph' => "Welcome to JRS International School. It gives me immense pride to introduce our institution as a place where education transcends the boundaries of textbooks and rote memorization, becoming an exhilarating voyage of curiosity, character formation, and discovery.\n\nIn today's dynamic global landscape, the role of schooling is not merely to prepare students for examinations, but to equip them with the resilience, creativity, critical thinking, and ethical depth necessary to solve real-world problems.\n\nAt JRS, we have seamlessly woven the timeless values of Indian ethos—respect, empathy, integrity, and mindfulness—with world-class pedagogical frameworks, smart interactive classrooms, and advanced science and computer laboratories.\n\nEvery child is uniquely gifted. Through personalized mentoring, an optimal 1:25 student-teacher ratio, and a vibrant co-curricular curriculum spanning skating, karate, music, arts, and robotics, we foster an environment where every young learner blossoms with joy and confidence.",
                'signoff_note' => 'WITH WARM WISHES & COMMITMENT,',
                'signoff_name' => 'Chairman',
                'signoff_sub' => 'JRS International School, Hyderabad',

                // Section 2: Strategic Commitment Banner
                'commitment_badge' => 'OUR STRATEGIC COMMITMENT',
                'commitment_title' => 'Building An Empowered Generation For Tomorrow',
                'commitment_description' => 'Under the chairman\'s visionary stewardship, JRS International School continues to upgrade educational infrastructure, introduce emerging digital technologies, and ensure every child receives the finest learning foundation in Hyderabad.',

                'is_active' => true,
            ]
        );
    }
}
