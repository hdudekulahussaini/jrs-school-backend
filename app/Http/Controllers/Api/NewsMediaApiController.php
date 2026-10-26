<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsMediaApiController extends Controller
{
    /**
     * Return complete News & Media page bundle for React frontend.
     */
    public function getPageData(): JsonResponse
    {
        $featured = NewsMedia::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('published_date', 'desc')
            ->get();

        $latest = NewsMedia::where('is_active', true)
            ->where('is_featured', false)
            ->orderBy('sort_order', 'asc')
            ->orderBy('published_date', 'desc')
            ->get();

        $all = NewsMedia::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('published_date', 'desc')
            ->get();

        $ctaBanner = [
            'badge' => 'NEWS',
            'title' => 'Stay Connected With JRS News & Updates',
            'buttons' => [
                [
                    'label' => 'View Gallery',
                    'link' => '/gallery',
                    'variant' => 'primary',
                ],
                [
                    'label' => 'School Events',
                    'link' => '/events',
                    'variant' => 'outline',
                ],
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'News & Media page data retrieved successfully',
            'data' => [
                'header' => [
                    'breadcrumb' => 'Home > News & Media',
                    'title' => 'News & Media',
                    'subtitle' => 'JRS INTERNATIONAL SCHOOL',
                    'description' => 'Explore our latest newspaper features, media coverage, achievements, and vibrant happenings from JRS International School, Hyderabad.',
                ],
                'achievements_section' => [
                    'badge' => 'LATEST UPDATES',
                    'title' => 'Our Achievements In The News',
                    'description' => 'Explore the latest news, achievements, events and special moments from JRS International School.',
                    'count' => $featured->count(),
                    'items' => $featured,
                ],
                'campus_news_section' => [
                    'badge' => 'FROM OUR CAMPUS',
                    'title' => 'Latest News',
                    'description' => 'Catch up on the latest campus stories, events, achievements and press coverage.',
                    'count' => $latest->count(),
                    'items' => $latest,
                ],
                'cta_banner' => $ctaBanner,
                'all_items' => $all,
            ],
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return list of active news/media items.
     */
    public function getItems(Request $request): JsonResponse
    {
        $query = NewsMedia::where('is_active', true);

        if ($request->filled('type')) {
            if ($request->type === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->type === 'latest') {
                $query->where('is_featured', false);
            }
        }

        $items = $query->orderBy('sort_order', 'asc')
            ->orderBy('published_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'News media items retrieved successfully',
            'count' => $items->count(),
            'data' => $items,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return single news/media article by id.
     */
    public function show(string $id): JsonResponse
    {
        $item = NewsMedia::where('is_active', true)->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'News article not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'News article retrieved successfully',
            'data' => $item,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
