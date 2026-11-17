<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeStat;
use Illuminate\Http\JsonResponse;

class HomeStatApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/stats
     */
    public function getActiveStats(): JsonResponse
    {
        $stats = HomeStat::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $stats->count(),
            'data' => $stats
        ], 200);
    }
}
