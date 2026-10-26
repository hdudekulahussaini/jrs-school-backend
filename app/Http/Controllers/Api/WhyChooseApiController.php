<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseFeature;
use Illuminate\Http\JsonResponse;

class WhyChooseApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/why-choose
     */
    public function index(): JsonResponse
    {
        $all = WhyChooseFeature::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $cards = $all->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'icon' => $item->icon,
                'icon_color' => $item->icon_color,
                'sort_order' => $item->sort_order,
                'is_active' => (bool)$item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'section' => [
                'eyebrow' => 'WHY CHOOSE JRS',
                'title' => 'What Makes JRS Different?',
                'title_highlight' => 'Different?',
            ],
            'count' => $cards->count(),
            'cards' => $cards,
            'data' => $cards,
        ], 200);
    }
}
