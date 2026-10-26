<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryApiController extends Controller
{
    /**
     * Return complete gallery page bundle for React frontend.
     */
    public function getPageData(): JsonResponse
    {
        $albums = GalleryAlbum::where('is_active', true)
            ->with(['activeItems' => function ($q) {
                $q->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Gallery page data retrieved successfully',
            'count' => $albums->count(),
            'data' => $albums,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return list of active gallery albums.
     */
    public function getAlbums(): JsonResponse
    {
        $albums = GalleryAlbum::where('is_active', true)
            ->withCount('activeItems')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Gallery albums retrieved successfully',
            'count' => $albums->count(),
            'data' => $albums,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return single album with its active items.
     */
    public function getAlbum(string $idOrSlug): JsonResponse
    {
        $album = GalleryAlbum::where('is_active', true)
            ->where(function ($q) use ($idOrSlug) {
                if (is_numeric($idOrSlug)) {
                    $q->where('id', $idOrSlug)->orWhere('slug', $idOrSlug);
                } else {
                    $q->where('slug', $idOrSlug);
                }
            })
            ->with(['activeItems' => function ($q) {
                $q->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
            }])
            ->first();

        if (!$album) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery album not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gallery album retrieved successfully',
            'data' => $album,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Return items, filterable by ?album_id=.
     */
    public function getItems(Request $request): JsonResponse
    {
        $query = GalleryItem::where('is_active', true)->with('album');

        if ($request->filled('album_id')) {
            $query->where('gallery_album_id', $request->album_id);
        }

        $items = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Gallery items retrieved successfully',
            'count' => $items->count(),
            'data' => $items,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
