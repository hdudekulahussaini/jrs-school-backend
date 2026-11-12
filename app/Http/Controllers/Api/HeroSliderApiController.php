<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\JsonResponse;

class HeroSliderApiController extends Controller
{
    /**
     * Public endpoint for React frontend: GET /api/hero-slider
     * Returns buttons and the experience badge synchronized across each rotating background photo,
     * along with the parent hero object.
     */
    public function getActiveSliders(): JsonResponse
    {
        $hero = HeroSlider::first();

        if (!$hero) {
            return response()->json([
                'success' => true,
                'count' => 0,
                'data' => [],
                'hero' => null,
            ], 200);
        }

        $changed = false;
        if ($hero->primary_button_text === 'Admissions 2026-27' || empty($hero->primary_button_text)) {
            $hero->primary_button_text = 'Admissions 2027-28';
            $changed = true;
        }
        if (empty($hero->experience_badge_image)) {
            $hero->experience_badge_image = 'images/experience-badge-38.svg';
            $changed = true;
        }
        if ($changed) {
            $hero->save();
        }

        $slides = $hero->slides;

        return response()->json([
            'success' => true,
            'count' => count($slides),
            'data' => $slides,
            'hero' => [
                'id' => $hero->id,
                'primary_button_text' => $hero->primary_button_text,
                'secondary_button_text' => $hero->secondary_button_text,
                'secondary_button_url' => $hero->secondary_button_url,
                'experience_badge_image' => $hero->experience_badge_image,
                'experience_badge_image_url' => $hero->experience_badge_image_url,
                'background_images' => $hero->background_images ?? [],
                'background_images_full_urls' => $hero->background_images_full_urls,
            ],
        ], 200);
    }
}
