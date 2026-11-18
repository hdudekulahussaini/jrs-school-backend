<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PtaMember;
use Illuminate\Http\JsonResponse;

class PtaMemberApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/pta or /api/pta-members
     */
    public function index(): JsonResponse
    {
        $members = PtaMember::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $data = $members->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'designation' => $item->designation,
                'address' => $item->address,
                'phone' => $item->phone,
                'image_path' => $item->image_path,
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
