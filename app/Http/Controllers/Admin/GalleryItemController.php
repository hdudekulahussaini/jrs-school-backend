<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryItemController extends Controller
{
    /**
     * Display listing of media items with album filtering.
     */
    public function index(Request $request)
    {
        $query = GalleryItem::with('album');

        if ($request->filled('album_id')) {
            $query->where('gallery_album_id', $request->album_id);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('caption', 'like', "%{$term}%")
                  ->orWhereHas('album', function ($aq) use ($term) {
                      $aq->where('title', 'like', "%{$term}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $items = $query->orderBy('gallery_album_id', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(24)
            ->withQueryString();

        $albums = GalleryAlbum::orderBy('sort_order', 'asc')->get();
        $totalCount = GalleryItem::count();
        $activeCount = GalleryItem::where('is_active', true)->count();
        $selectedAlbum = $request->filled('album_id') ? GalleryAlbum::find($request->album_id) : null;

        return view('admin.gallery.items.index', compact('items', 'albums', 'totalCount', 'activeCount', 'selectedAlbum'));
    }

    /**
     * Show form to upload new media.
     */
    public function create(Request $request)
    {
        $albums = GalleryAlbum::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $selectedAlbumId = $request->input('album_id');

        $nextOrder = 1;
        if ($selectedAlbumId) {
            $nextOrder = (GalleryItem::where('gallery_album_id', $selectedAlbumId)->max('sort_order') ?? 0) + 1;
        }

        return view('admin.gallery.items.create', compact('albums', 'selectedAlbumId', 'nextOrder'));
    }

    /**
     * Store newly created media items (supports single or bulk images).
     */
    public function store(Request $request)
    {
        $request->validate([
            'gallery_album_id' => 'required|exists:gallery_albums,id',
            'caption' => 'nullable|string|max:190',
            'video_url' => 'nullable|url|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'sort_order' => 'nullable|integer',
        ]);

        $albumId = $request->gallery_album_id;
        $caption = $request->caption;
        $videoUrl = $request->video_url;
        $isActive = $request->has('is_active');
        $startOrder = $request->input('sort_order', (GalleryItem::where('gallery_album_id', $albumId)->max('sort_order') ?? 0) + 1);

        $uploadDir = public_path('uploads/gallery/items');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $files = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
        } elseif ($request->hasFile('image')) {
            $files = [$request->file('image')];
        }

        if (empty($files) && empty($videoUrl)) {
            return back()->withErrors(['image' => 'Please select at least one image to upload or provide a video URL.'])->withInput();
        }

        // If no files but video URL is provided
        if (empty($files) && !empty($videoUrl)) {
            GalleryItem::create([
                'gallery_album_id' => $albumId,
                'caption' => $caption,
                'image_path' => '/images/beyond/sports.jpg', // Default video thumbnail
                'video_url' => $videoUrl,
                'sort_order' => $startOrder,
                'is_active' => $isActive,
            ]);
        } else {
            $currentOrder = $startOrder;
            foreach ($files as $idx => $file) {
                $filename = time() . '_' . $idx . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);

                GalleryItem::create([
                    'gallery_album_id' => $albumId,
                    'caption' => (count($files) > 1 && empty($caption)) ? null : $caption,
                    'image_path' => '/uploads/gallery/items/' . $filename,
                    'video_url' => $videoUrl,
                    'sort_order' => $currentOrder++,
                    'is_active' => $isActive,
                ]);
            }
        }

        return redirect()->route('admin.gallery-items.index', ['album_id' => $albumId])
            ->with('success', 'Media items added to gallery successfully.');
    }

    /**
     * Show form to edit a single media item.
     */
    public function edit(string $id)
    {
        $item = GalleryItem::with('album')->findOrFail($id);
        $albums = GalleryAlbum::orderBy('sort_order', 'asc')->get();

        return view('admin.gallery.items.edit', compact('item', 'albums'));
    }

    /**
     * Update a single media item.
     */
    public function update(Request $request, string $id)
    {
        $item = GalleryItem::findOrFail($id);

        $validated = $request->validate([
            'gallery_album_id' => 'required|exists:gallery_albums,id',
            'caption' => 'nullable|string|max:190',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'video_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $item->gallery_album_id = $validated['gallery_album_id'];
        $item->caption = $validated['caption'];
        $item->video_url = $validated['video_url'];
        $item->sort_order = $request->input('sort_order', $item->sort_order);
        $item->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($item->image_path && Str::startsWith($item->image_path, '/uploads/gallery/items/')) {
                $oldFile = public_path(ltrim($item->image_path, '/'));
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('image');
            $uploadDir = public_path('uploads/gallery/items');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $item->image_path = '/uploads/gallery/items/' . $filename;
        }

        $item->save();

        return redirect()->route('admin.gallery-items.index', ['album_id' => $item->gallery_album_id])
            ->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Delete a single media item.
     */
    public function destroy(string $id)
    {
        $item = GalleryItem::findOrFail($id);
        $albumId = $item->gallery_album_id;

        if ($item->image_path && Str::startsWith($item->image_path, '/uploads/gallery/items/')) {
            $file = public_path(ltrim($item->image_path, '/'));
            if (File::exists($file)) {
                File::delete($file);
            }
        }

        $item->delete();

        return redirect()->route('admin.gallery-items.index', ['album_id' => $albumId])
            ->with('success', 'Gallery item deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(string $id)
    {
        $item = GalleryItem::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $item->is_active,
                'message' => 'Item status updated.',
            ]);
        }

        return back()->with('success', 'Item status updated.');
    }
}
