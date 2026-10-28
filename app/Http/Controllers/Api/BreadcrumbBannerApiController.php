<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreadcrumbBannerRequest;
use App\Http\Resources\BreadcrumbBannerResource;
use App\Models\BreadcrumbBanner;
use App\Models\BreadcrumbBannerStat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BreadcrumbBannerApiController extends Controller
{
    /**
     * Public GET /api/breadcrumb-banners
     * Listing of all breadcrumb banners (active by default for frontend, or ?all=1).
     */
    public function index(Request $request): JsonResponse
    {
        $query = BreadcrumbBanner::with('stats');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('page_name', 'like', "%{$term}%")
                  ->orWhere('page_slug', 'like', "%{$term}%")
                  ->orWhere('title', 'like', "%{$term}%")
                  ->orWhere('breadcrumb_title', 'like', "%{$term}%");
            });
        }

        $banners = $query->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $banners->count(),
            'data' => BreadcrumbBannerResource::collection($banners),
        ], 200);
    }

    /**
     * Public GET /api/breadcrumb-banners/page/{slug}
     * Returns the dynamic breadcrumb banner data for a specific page slug.
     * Used by React frontend: https://jrs-school.vercel.app/
     */
    public function getBySlug(string $slug): JsonResponse
    {
        $banner = BreadcrumbBanner::findBySlugOrAlias($slug);

        if ($banner) {
            return response()->json([
                'success' => true,
                'data' => new BreadcrumbBannerResource($banner),
            ], 200);
        }

        // Check if slug belongs to known supported pages or aliases and return fallback defaults
        $normalized = trim(ltrim($slug, '/'));
        $supported = collect(BreadcrumbBanner::supportedPages())->firstWhere('slug', $normalized);
        if (!$supported) {
            $aliases = [
                'amenities' => 'facilities',
                'facilities' => 'amenities',
                'beyond-classroom' => 'beyond',
                'principals-message' => 'principal',
                'chairmans-message' => 'chairman',
                'news-media' => 'media',
                'gallery/360-degree-campus' => '360-degree-campus',
                '360-degree-campus' => 'gallery/360-degree-campus',
                'admissions-overview' => 'admissions',
            ];
            if (isset($aliases[$normalized])) {
                $supported = collect(BreadcrumbBanner::supportedPages())->firstWhere('slug', $aliases[$normalized]);
            }
        }

        if ($supported) {
            return response()->json([
                'success' => true,
                'is_default' => true,
                'data' => [
                    'id' => null,
                    'page_name' => $supported['name'],
                    'page_slug' => $supported['slug'],
                    'breadcrumb_title' => $supported['breadcrumb_title'],
                    'title' => $supported['title'],
                    'highlighted_title' => $supported['highlighted_title'] ?? null,
                    'subtitle' => $supported['subtitle'] ?? null,
                    'description' => $supported['description'] ?? null,
                    'background_image' => asset('images/amenities/cta-banner.png'),
                    'primary_button' => [
                        'text' => $supported['primary_button_text'] ?? null,
                        'url' => $supported['primary_button_url'] ?? null,
                    ],
                    'secondary_button' => [
                        'text' => $supported['secondary_button_text'] ?? null,
                        'url' => $supported['secondary_button_url'] ?? null,
                    ],
                    'stats' => $supported['stats'] ?? [],
                    'is_active' => true,
                ],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No breadcrumb banner found for page slug: ' . $slug,
            'data' => null,
        ], 404);
    }

    /**
     * GET /api/breadcrumb-banners/{idOrSlug}
     * Find a banner by numeric ID or unique slug.
     */
    public function show(string $idOrSlug): JsonResponse
    {
        $banner = is_numeric($idOrSlug)
            ? BreadcrumbBanner::with('stats')->find($idOrSlug)
            : BreadcrumbBanner::with('stats')->where('page_slug', $idOrSlug)->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Breadcrumb banner not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new BreadcrumbBannerResource($banner),
        ], 200);
    }

    /**
     * POST /api/breadcrumb-banners
     * REST API endpoint to create a new breadcrumb banner.
     */
    public function store(BreadcrumbBannerRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $uploadDir = public_path('uploads/banners');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'banner_' . Str::slug($request->page_slug) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['background_image'] = '/uploads/banners/' . $filename;
        } elseif (!empty($request->background_image_path)) {
            $data['background_image'] = $request->background_image_path;
        }

        $statsInput = $request->input('stats', []);
        unset($data['stats'], $data['background_image_path'], $data['is_active']);

        $banner = BreadcrumbBanner::create($data);

        if (is_array($statsInput) && count($statsInput) > 0) {
            foreach ($statsInput as $index => $stat) {
                if (!empty($stat['value']) && !empty($stat['label'])) {
                    BreadcrumbBannerStat::create([
                        'breadcrumb_banner_id' => $banner->id,
                        'icon' => $stat['icon'] ?? 'sparkles',
                        'value' => $stat['value'],
                        'label' => $stat['label'],
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }

        $banner->load('stats');

        return response()->json([
            'success' => true,
            'message' => 'Breadcrumb banner created successfully',
            'data' => new BreadcrumbBannerResource($banner),
        ], 201);
    }

    /**
     * PUT/PATCH /api/breadcrumb-banners/{id}
     * REST API endpoint to update an existing breadcrumb banner (by numeric ID or page slug).
     */
    public function update(BreadcrumbBannerRequest $request, $id): JsonResponse
    {
        $banner = is_numeric($id)
            ? BreadcrumbBanner::find($id)
            : BreadcrumbBanner::where('page_slug', $id)->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Breadcrumb banner not found',
            ], 404);
        }

        $data = $request->validated();
        unset($data['is_active']);

        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $uploadDir = public_path('uploads/banners');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            if ($banner->background_image && Str::startsWith($banner->background_image, '/uploads/banners/')) {
                $oldFile = public_path(ltrim($banner->background_image, '/'));
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $filename = 'banner_' . Str::slug($request->page_slug) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['background_image'] = '/uploads/banners/' . $filename;
        } elseif (!empty($request->background_image_path)) {
            $data['background_image'] = $request->background_image_path;
        }

        $statsInput = $request->input('stats', []);
        unset($data['stats'], $data['background_image_path']);

        $banner->update($data);

        // Update stats
        if ($request->has('stats')) {
            $banner->stats()->delete();
            if (is_array($statsInput) && count($statsInput) > 0) {
                foreach ($statsInput as $index => $stat) {
                    if (!empty($stat['value']) && !empty($stat['label'])) {
                        BreadcrumbBannerStat::create([
                            'breadcrumb_banner_id' => $banner->id,
                            'icon' => $stat['icon'] ?? 'sparkles',
                            'value' => $stat['value'],
                            'label' => $stat['label'],
                            'sort_order' => $index + 1,
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }

        $banner->load('stats');

        return response()->json([
            'success' => true,
            'message' => 'Breadcrumb banner updated successfully',
            'data' => new BreadcrumbBannerResource($banner),
        ], 200);
    }

    /**
     * DELETE /api/breadcrumb-banners/{id}
     * REST API endpoint to delete a breadcrumb banner (by numeric ID or page slug).
     */
    public function destroy($id): JsonResponse
    {
        $banner = is_numeric($id)
            ? BreadcrumbBanner::find($id)
            : BreadcrumbBanner::where('page_slug', $id)->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Breadcrumb banner not found',
            ], 404);
        }

        if ($banner->background_image && Str::startsWith($banner->background_image, '/uploads/banners/')) {
            $oldFile = public_path(ltrim($banner->background_image, '/'));
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Breadcrumb banner deleted successfully',
        ], 200);
    }

    /**
     * GET /api/breadcrumb-banners/pages
     * Returns list of supported website pages and their current configuration status.
     */
    public function pages(): JsonResponse
    {
        $existing = BreadcrumbBanner::pluck('id', 'page_slug')->toArray();
        $pages = collect(BreadcrumbBanner::supportedPages())->map(function ($page) use ($existing) {
            return [
                'name' => $page['name'],
                'slug' => $page['slug'],
                'has_banner' => isset($existing[$page['slug']]),
                'banner_id' => $existing[$page['slug']] ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $pages,
        ], 200);
    }
}
