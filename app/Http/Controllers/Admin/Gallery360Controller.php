<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Gallery360Controller extends Controller
{
    /**
     * Display listing of 360 deg campus photos.
     */
    public function index(Request $request)
    {
        $album = GalleryAlbum::firstOrCreate(
            ['slug' => '360-degree-campus'],
            [
                'title' => '360 Deg Campus',
                'badge' => '360 DEGREE VIRTUAL TOUR',
                'highlight_text' => '360° Campus',
                'description' => 'Take an immersive 360-degree virtual tour of our classrooms, labs, playgrounds, and amenities.',
                'media_type' => 'image',
                'sort_order' => 20,
                'is_active' => true,
            ]
        );

        $items = $album->items()->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.gallery.360.index', compact('album', 'items'));
    }

    /**
     * Store 360 deg campus photos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gallery_photos' => 'nullable|array',
            'gallery_photos.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:15360',
            'removed_item_ids' => 'nullable|array',
            'removed_item_ids.*' => 'integer',
        ]);

        $album = GalleryAlbum::firstOrCreate(
            ['slug' => '360-degree-campus'],
            [
                'title' => '360 Deg Campus',
                'badge' => '360 DEGREE VIRTUAL TOUR',
                'highlight_text' => '360° Campus',
                'description' => 'Take an immersive 360-degree virtual tour of our classrooms, labs, playgrounds, and amenities.',
                'media_type' => 'image',
                'sort_order' => 20,
                'is_active' => true,
            ]
        );

        // Handle removed photos
        if ($request->filled('removed_item_ids')) {
            $removedIds = (array) $request->input('removed_item_ids');
            $itemsToDelete = GalleryItem::where('gallery_album_id', $album->id)->whereIn('id', $removedIds)->get();
            foreach ($itemsToDelete as $delItem) {
                if ($delItem->image_path && Str::startsWith($delItem->image_path, '/uploads/')) {
                    $path = public_path(ltrim($delItem->image_path, '/'));
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
                $delItem->delete();
            }
        }

        // Upload new 360 photos
        if ($request->hasFile('gallery_photos')) {
            $uploadDir = public_path('uploads/gallery/360');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $maxSort = GalleryItem::where('gallery_album_id', $album->id)->max('sort_order') ?? 0;

            foreach ($request->file('gallery_photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $originalName = $photoFile->getClientOriginalName();
                    $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                    $filename = time() . '_' . Str::random(6) . '_' . Str::slug($baseName) . '.' . $photoFile->getClientOriginalExtension();
                    $photoFile->move($uploadDir, $filename);

                    $album->items()->create([
                        'caption' => ucwords(str_replace(['-', '_'], ' ', $baseName)),
                        'image_path' => '/uploads/gallery/360/' . $filename,
                        'sort_order' => ++$maxSort,
                        'is_active' => true,
                    ]);
                }
            }
        }

        if (function_exists('flash')) {
            flash()->success('360 Deg Campus photos saved successfully.', 'Photos Saved');
        }

        return redirect()->route('admin.gallery-360.index')
            ->with('success', '360 Deg Campus photos saved successfully.');
    }
}
