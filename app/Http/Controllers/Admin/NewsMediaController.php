<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsMediaController extends Controller
{
    /**
     * Display listing of news and media coverage items / photo uploader.
     */
    public function index(Request $request)
    {
        $items = NewsMedia::orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.gallery.media.index', compact('items'));
    }

    /**
     * Show form to create a new news/media article.
     */
    public function create()
    {
        return redirect()->route('admin.news-media.index');
    }

    /**
     * Store news/media photos.
     */
    public function store(Request $request)
    {
        // Handle removed clippings
        if ($request->filled('removed_item_ids')) {
            $removedIds = (array) $request->input('removed_item_ids');
            $itemsToDelete = NewsMedia::whereIn('id', $removedIds)->get();
            foreach ($itemsToDelete as $delItem) {
                if ($delItem->image_path && Str::startsWith($delItem->image_path, '/uploads/news-media/')) {
                    $path = public_path(ltrim($delItem->image_path, '/'));
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
                $delItem->delete();
            }
        }

        // Upload newly added news/media photos
        if ($request->hasFile('media_photos')) {
            $uploadDir = public_path('uploads/news-media');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $maxSort = NewsMedia::max('sort_order') ?? 0;
            foreach ($request->file('media_photos') as $file) {
                if ($file && $file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadDir, $filename);
                    NewsMedia::create([
                        'title' => pathinfo($originalName, PATHINFO_FILENAME),
                        'english_title' => pathinfo($originalName, PATHINFO_FILENAME),
                        'newspaper_name' => 'Press Coverage',
                        'published_date' => now(),
                        'image_path' => '/uploads/news-media/' . $filename,
                        'sort_order' => ++$maxSort,
                        'is_active' => true,
                    ]);
                }
            }
        }

        flash()->success('News & Media photos saved successfully.', 'Media Saved');

        return redirect()->route('admin.news-media.index')
            ->with('success', 'News & Media photos saved successfully.');
    }

    /**
     * Show form to edit news/media article.
     */
    public function edit(string $id)
    {
        return redirect()->route('admin.news-media.index');
    }

    /**
     * Update news/media article.
     */
    public function update(Request $request, string $id)
    {
        $item = NewsMedia::findOrFail($id);
        $validated = $request->validate(NewsMedia::validationRules($item->id));

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', $item->sort_order);

        if ($request->hasFile('image')) {
            if ($item->image_path && Str::startsWith($item->image_path, '/uploads/news-media/')) {
                $oldFile = public_path(ltrim($item->image_path, '/'));
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('image');
            $uploadDir = public_path('uploads/news-media');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = '/uploads/news-media/' . $filename;
        }

        $item->update($validated);

        flash()->success('News & Media article updated successfully.', 'Article Updated');

        return redirect()->route('admin.news-media.index')
            ->with('success', 'News & Media article updated successfully.');
    }

    /**
     * Delete news/media article.
     */
    public function destroy(string $id)
    {
        $item = NewsMedia::findOrFail($id);

        if ($item->image_path && Str::startsWith($item->image_path, '/uploads/news-media/')) {
            $file = public_path(ltrim($item->image_path, '/'));
            if (File::exists($file)) {
                File::delete($file);
            }
        }

        $item->delete();

        flash()->info('News & Media article deleted successfully.', 'Article Removed');

        return redirect()->route('admin.news-media.index')
            ->with('success', 'News & Media article deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(string $id)
    {
        $item = NewsMedia::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        if ($item->is_active) {
            flash()->success('Article status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Article status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $item->is_active,
                'message' => 'Status updated successfully.',
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
    }
}
