<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CampusLife;
use Illuminate\Http\JsonResponse;

class CampusLifeApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/campus-tour or /api/campus-life
     */
    public function index(): JsonResponse
    {
        $items = CampusLife::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'subtitle' => $item->subtitle,
                'icon' => $item->icon,
                'image_url' => $item->image_full_url,
                'sort_order' => $item->sort_order,
                'is_active' => (bool)$item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'section' => [
                'eyebrow' => 'CAMPUS TOUR & LIFE AT JRS',
                'title' => 'Experience The Spirit Of JRS International School',
                'title_highlight' => 'JRS International School',
                'description' => 'Explore our state-of-the-art campus, modern facilities, and vibrant learning spaces where every student discovers their unique passions and potential.',
                'cta_primary' => [
                    'text' => 'Book a Campus Visit',
                    'url' => 'https://jrs-school.vercel.app/#tour',
                ],
                'cta_secondary' => [
                    'text' => 'Admissions 2026-27',
                    'url' => 'https://jrs-school.vercel.app/admissions',
                ],
            ],
            'count' => $data->count(),
            'data' => $data,
        ], 200);
    }
}
