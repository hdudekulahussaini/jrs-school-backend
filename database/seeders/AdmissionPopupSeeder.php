<?php

namespace Database\Seeders;

use App\Models\AdmissionPopup;
use Illuminate\Database\Seeder;

class AdmissionPopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdmissionPopup::updateOrCreate(
            ['id' => 1],
            [
                'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1200&auto=format&fit=crop',
            ]
        );
    }
}
