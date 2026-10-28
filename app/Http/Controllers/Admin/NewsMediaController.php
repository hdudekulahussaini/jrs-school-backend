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
     * Display listing of news and media coverage items.
     */
    public function index(Request $request)
    {
        $query = NewsMedia::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('english_title', 'like', "%{$term}%")
                  ->orWhere('newspaper_name', 'like', "%{$term}%")
                  ->orWhere('location', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('type')) {
            if ($request->type === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->type === 'latest') {
                $query->where('is_featured', false);
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $items = $query->orderBy('sort_order', 'asc')
            ->orderBy('published_date', 'desc')
            ->paginate(12)
            ->withQueryString();

        $totalCount = NewsMedia::count();
        $featuredCount = NewsMedia::where('is_featured', true)->count();
        $latestCount = NewsMedia::where('is_featured', false)->count();

        return view('admin.gallery.media.index', compact('items', 'totalCount', 'featuredCount', 'latestCount'));
    }

    /**
     * Show form to create a new news/media article.
     */
    public function create()
    {
        $nextOrder = (NewsMedia::max('sort_order') ?? 0) + 1;
        return view('admin.gallery.media.create', compact('nextOrder'));
    }

    /**
     * Store newly created news/media article.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(NewsMedia::validationRules());
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/news-media');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = '/uploads/news-media/' . $filename;
        }

        NewsMedia::create($validated);

        flash()->success('News & Media article published successfully.', 'Article Published');

        return redirect()->route('admin.news-media.index')
            ->with('success', 'News & Media article published successfully.');
    }

    /**
     * Show form to edit news/media article.
     */
    public function edit(string $id)
    {
        $item = NewsMedia::findOrFail($id);
        return view('admin.gallery.media.edit', compact('item'));
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
