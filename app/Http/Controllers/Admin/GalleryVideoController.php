<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryVideoController extends Controller
{
    /**
     * Display listing of gallery videos / video uploader.
     */
    public function index(Request $request)
    {
        $album = GalleryAlbum::where('media_type', 'video')->first();
        if (!$album) {
            $album = GalleryAlbum::create([
                'title' => 'School Video Gallery',
                'slug' => 'school-video-gallery',
                'media_type' => 'video',
                'is_active' => true,
                'sort_order' => 10,
            ]);
        }

        $items = GalleryItem::where(function ($q) use ($album) {
            $q->where('gallery_album_id', $album->id)
              ->orWhereNotNull('video_url');
        })->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.gallery.videos.index', compact('album', 'items'));
    }

    /**
     * Store uploaded videos and video links.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gallery_videos' => 'nullable|array',
            'gallery_videos.*' => 'file|mimes:mp4,webm,ogg,mov,mkv,m4v,avi,wmv|max:102400', // max 100MB
            'new_video_urls' => 'nullable|array',
            'new_video_urls.*' => 'nullable|string|max:500',
            'removed_item_ids' => 'nullable|array',
            'removed_item_ids.*' => 'integer',
        ]);

        $album = GalleryAlbum::where('media_type', 'video')->first();
        if (!$album) {
            $album = GalleryAlbum::create([
                'title' => 'School Video Gallery',
                'slug' => 'school-video-gallery',
                'media_type' => 'video',
                'is_active' => true,
                'sort_order' => 10,
            ]);
        }

        // Handle removed video items
        if ($request->filled('removed_item_ids')) {
            $removedIds = (array) $request->input('removed_item_ids');
            $itemsToDelete = GalleryItem::whereIn('id', $removedIds)->get();
            foreach ($itemsToDelete as $delItem) {
                if ($delItem->video_url && Str::startsWith($delItem->video_url, '/uploads/')) {
                    $path = public_path(ltrim($delItem->video_url, '/'));
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
                if ($delItem->image_path && Str::startsWith($delItem->image_path, '/uploads/')) {
                    $imgPath = public_path(ltrim($delItem->image_path, '/'));
                    if (File::exists($imgPath)) {
                        File::delete($imgPath);
                    }
                }
                $delItem->delete();
            }
        }

        $maxSort = GalleryItem::where('gallery_album_id', $album->id)->max('sort_order') ?? 0;

        // Handle uploaded video files
        if ($request->hasFile('gallery_videos')) {
            $uploadDir = public_path('uploads/gallery/videos');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            foreach ($request->file('gallery_videos') as $videoFile) {
                if ($videoFile && $videoFile->isValid()) {
                    $originalName = $videoFile->getClientOriginalName();
                    $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                    $filename = time() . '_' . Str::random(6) . '_' . Str::slug($baseName) . '.' . $videoFile->getClientOriginalExtension();
                    $videoFile->move($uploadDir, $filename);

                    $album->items()->create([
                        'caption' => ucwords(str_replace(['-', '_'], ' ', $baseName)),
                        'video_url' => '/uploads/gallery/videos/' . $filename,
                        'image_path' => null,
                        'sort_order' => ++$maxSort,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Handle added video links/URLs
        if ($request->filled('new_video_urls')) {
            foreach ((array) $request->input('new_video_urls') as $url) {
                $url = trim($url);
                if (!empty($url)) {
                    $caption = 'Video ' . ($maxSort + 1);
                    if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $m)) {
                        $caption = 'YouTube Video (' . $m[1] . ')';
                    } elseif (Str::contains($url, 'vimeo.com')) {
                        $caption = 'Vimeo Video';
                    }

                    $album->items()->create([
                        'caption' => $caption,
                        'video_url' => $url,
                        'image_path' => null,
                        'sort_order' => ++$maxSort,
                        'is_active' => true,
                    ]);
                }
            }
        }

        if (function_exists('flash')) {
            flash()->success('Gallery videos saved successfully.', 'Videos Saved');
        }

        return redirect()->route('admin.gallery-videos.index')
            ->with('success', 'Gallery videos saved successfully.');
    }
}
