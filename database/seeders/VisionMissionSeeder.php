<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisionMission;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisionMission::truncate();

        VisionMission::create([
            'type' => 'vision',
            'eyebrow' => 'OUR VISION',
            'title' => 'To Be A Foremost Learning Institution In Hyderabad.',
            'description' => 'To create a nurturing environment where every student can learn, explore, innovate and lead, becoming confident individuals who contribute positively to society.',
            'image_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1200&q=80',
            'icon' => 'eye',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        VisionMission::create([
            'type' => 'mission',
            'eyebrow' => 'OUR MISSION',
            'title' => 'Education Beyond The Classroom.',
            'description' => 'To provide a balanced education combining academic excellence, human values, creativity, innovation and real-world skills, preparing every child for a brighter future.',
            'image_path' => 'https://images.unsplash.com/photo-1581093458791-9f3c3900df4b?auto=format&fit=crop&w=1200&q=80',
            'icon' => 'rocket',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
