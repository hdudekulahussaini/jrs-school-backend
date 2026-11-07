<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampusLife;

class CampusLifeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            [
                'title' => 'Eco-Friendly Campus',
                'icon' => 'bi bi-tree-fill',
                'image_path' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=800&auto=format&fit=crop',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Smart Classrooms & STEM Labs',
                'icon' => 'bi bi-lightbulb-fill',
                'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'CBSE & Cultural Ethos',
                'icon' => 'bi bi-book-half',
                'image_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Sports, Karate & Skating',
                'icon' => 'bi bi-trophy-fill',
                'image_path' => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=800&auto=format&fit=crop',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($cards as $card) {
            CampusLife::firstOrCreate(
                ['title' => $card['title']],
                $card
            );
        }
    }
}
