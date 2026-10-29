<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryAlbumController extends Controller
{
    /**
     * Display listing of gallery albums / photo gallery uploader.
     */
    public function index(Request $request)
    {
        $album = GalleryAlbum::first();
        if (!$album) {
            $album = GalleryAlbum::create([
                'title' => 'School Photo Gallery',
                'slug' => 'school-photo-gallery',
                'media_type' => 'image',
                'is_active' => true,
                'sort_order' => 1,
            ]);
        }

        $items = \App\Models\GalleryItem::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.gallery.albums.index', compact('album', 'items'));
    }

    /**
     * Show form to create a new album.
     */
    public function create()
    {
        return redirect()->route('admin.gallery-albums.index');
    }

    /**
     * Store gallery photos.
     */
    public function store(Request $request)
    {
        $album = GalleryAlbum::first();
        if (!$album) {
            $album = GalleryAlbum::create([
                'title' => 'School Photo Gallery',
                'slug' => 'school-photo-gallery',
                'media_type' => 'image',
                'is_active' => true,
                'sort_order' => 1,
            ]);
        }

        // Handle removed photos
        if ($request->filled('removed_item_ids')) {
            $removedIds = (array) $request->input('removed_item_ids');
            $itemsToDelete = \App\Models\GalleryItem::whereIn('id', $removedIds)->get();
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

        // Upload gallery photos
        if ($request->hasFile('gallery_photos')) {
            $uploadDir = public_path('uploads/gallery/items');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $maxSort = \App\Models\GalleryItem::max('sort_order') ?? 0;
            foreach ($request->file('gallery_photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $originalName = $photoFile->getClientOriginalName();
                    $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $photoFile->getClientOriginalExtension();
                    $photoFile->move($uploadDir, $filename);
                    $album->items()->create([
                        'caption' => pathinfo($originalName, PATHINFO_FILENAME),
                        'image_path' => '/uploads/gallery/items/' . $filename,
                        'sort_order' => ++$maxSort,
                        'is_active' => true,
                    ]);
                }
            }
        }

        flash()->success('Gallery photos saved successfully.', 'Gallery Saved');

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Gallery photos saved successfully.');
    }

    /**
     * Show form to edit an album.
     */
    public function edit(string $id)
    {
        $album = GalleryAlbum::with(['items' => function ($q) {
            $q->orderBy('sort_order', 'asc');
        }])->findOrFail($id);

        return view('admin.gallery.albums.edit', compact('album'));
    }

    /**
     * Update an album.
     */
    public function update(Request $request, string $id)
    {
        $album = GalleryAlbum::findOrFail($id);
        $validated = $request->validate(GalleryAlbum::validationRules($album->id));

        if ($request->has('is_active')) {
            $validated['is_active'] = (bool) $request->input('is_active');
        }

        // Handle removed items
        if ($request->filled('removed_item_ids')) {
            $removedIds = (array) $request->input('removed_item_ids');
            $itemsToDelete = $album->items()->whereIn('id', $removedIds)->get();
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

        // Upload new gallery photos
        if ($request->hasFile('gallery_photos')) {
            $uploadDir = public_path('uploads/gallery/items');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $maxSort = $album->items()->max('sort_order') ?? 0;
            foreach ($request->file('gallery_photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $originalName = $photoFile->getClientOriginalName();
                    $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $photoFile->getClientOriginalExtension();
                    $photoFile->move($uploadDir, $filename);
                    $album->items()->create([
                        'caption' => pathinfo($originalName, PATHINFO_FILENAME),
                        'image_path' => '/uploads/gallery/items/' . $filename,
                        'sort_order' => ++$maxSort,
                        'is_active' => true,
                    ]);
                }
            }
        }

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image && Str::startsWith($album->cover_image, '/uploads/gallery/albums/')) {
                $oldFile = public_path(ltrim($album->cover_image, '/'));
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('cover_image');
            $uploadDir = public_path('uploads/gallery/albums');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['cover_image'] = '/uploads/gallery/albums/' . $filename;
        }

        $album->update(array_filter($validated, fn($val) => $val !== null));

        flash()->success('Gallery photos updated successfully.', 'Gallery Updated');

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Gallery photos updated successfully.');
    }

    /**
     * Delete an album and its associated media files.
     */
    public function destroy(string $id)
    {
        $album = GalleryAlbum::with('items')->findOrFail($id);

        // Delete cover image if local
        if ($album->cover_image && Str::startsWith($album->cover_image, '/uploads/gallery/albums/')) {
            $coverFile = public_path(ltrim($album->cover_image, '/'));
            if (File::exists($coverFile)) {
                File::delete($coverFile);
            }
        }

        // Delete each item's file
        foreach ($album->items as $item) {
            if ($item->image_path && Str::startsWith($item->image_path, '/uploads/gallery/items/')) {
                $itemFile = public_path(ltrim($item->image_path, '/'));
                if (File::exists($itemFile)) {
                    File::delete($itemFile);
                }
            }
        }

        $album->delete();

        flash()->info('Gallery Album and its items removed successfully.', 'Album Removed');

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Gallery Album and its items removed successfully.');
    }

    /**
     * Quick status toggle.
     */
    public function toggle(string $id)
    {
        $album = GalleryAlbum::findOrFail($id);
        $album->is_active = !$album->is_active;
        $album->save();

        if ($album->is_active) {
            flash()->success('Album status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Album status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $album->is_active,
                'message' => 'Album status updated successfully.',
            ]);
        }

        return back()->with('success', 'Album status updated successfully.');
    }
}
