<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopBar;
use Illuminate\Http\JsonResponse;

class TopBarApiController extends Controller
{
    /**
     * Return active header Top Bar configuration for React frontend.
     */
    public function getTopBar(): JsonResponse
    {
        $topBar = TopBar::where('is_active', true)->first();

        if (!$topBar) {
            return response()->json([
                'success' => false,
                'message' => 'Top Bar is currently disabled or not configured',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Top Bar configuration retrieved successfully',
            'data' => [
                'id' => $topBar->id,
                'phone' => $topBar->phone,
                'phone_2' => $topBar->phone_2,
                'email' => $topBar->email,
                'cbse_affiliation_text' => $topBar->cbse_affiliation_text,
                'prospectus_title' => $topBar->prospectus_title,
                'prospectus_url' => $topBar->prospectus_url,
                'prospectus_file' => $topBar->prospectus_file,
                'is_active' => (bool) $topBar->is_active,
            ],
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
