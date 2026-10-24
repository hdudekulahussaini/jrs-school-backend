<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\JsonResponse;

class VisionMissionApiController extends Controller
{
    /**
     * Public GET endpoint: GET /api/vision-mission
     */
    public function index(): JsonResponse
    {
        $items = VisionMission::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->limit(2)
            ->get();

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'eyebrow' => $item->eyebrow,
                'title' => $item->title,
                'description' => $item->description,
                'icon' => $item->icon,
                'image_url' => $item->image_url,
                'sort_order' => $item->sort_order,
                'is_active' => (bool)$item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'data' => $data,
        ], 200);
    }
}
