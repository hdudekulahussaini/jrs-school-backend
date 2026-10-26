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
                'phone' => [
                    'label' => $topBar->phone,
                    'href' => $topBar->phone_href ?: ('tel:' . preg_replace('/[^0-9+]/', '', $topBar->phone)),
                    'highlight_color' => '#e31e24', // JRS Red
                ],
                'email' => [
                    'label' => $topBar->email,
                    'href' => $topBar->email_href ?: ('mailto:' . $topBar->email),
                ],
                'affiliation' => [
                    'label' => $topBar->cbse_affiliation_text,
                    'code' => $topBar->cbse_affiliation_code,
                ],
                'mandatory_disclosure' => [
                    'label' => $topBar->mandatory_disclosure_title,
                    'url' => $topBar->mandatory_disclosure_link,
                    'is_file' => !empty($topBar->mandatory_disclosure_file),
                ],
                'school_prospectus' => [
                    'label' => $topBar->prospectus_title,
                    'url' => $topBar->prospectus_link,
                    'is_file' => !empty($topBar->prospectus_file),
                ],
                'is_active' => (bool) $topBar->is_active,
            ],
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
