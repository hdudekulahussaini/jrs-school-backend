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
     * Display listing of gallery albums.
     */
    public function index(Request $request)
    {
        $query = GalleryAlbum::withCount('items');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('badge', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('media_type')) {
            $query->where('media_type', $request->media_type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $albums = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(12)
            ->withQueryString();

        $totalCount = GalleryAlbum::count();
        $activeCount = GalleryAlbum::where('is_active', true)->count();
        $totalItemsCount = \App\Models\GalleryItem::count();

        return view('admin.gallery.albums.index', compact('albums', 'totalCount', 'activeCount', 'totalItemsCount'));
    }

    /**
     * Show form to create a new album.
     */
    public function create()
    {
        $nextOrder = (GalleryAlbum::max('sort_order') ?? 0) + 1;
        return view('admin.gallery.albums.create', compact('nextOrder'));
    }

    /**
     * Store a newly created album.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(GalleryAlbum::validationRules());
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $uploadDir = public_path('uploads/gallery/albums');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['cover_image'] = '/uploads/gallery/albums/' . $filename;
        }

        GalleryAlbum::create($validated);

        flash()->success('Gallery Album created successfully.', 'Album Created');

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Gallery Album created successfully.');
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

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', $album->sort_order);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
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

        $album->update($validated);

        flash()->success('Gallery Album updated successfully.', 'Album Updated');

        return redirect()->route('admin.gallery-albums.index')
            ->with('success', 'Gallery Album updated successfully.');
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
