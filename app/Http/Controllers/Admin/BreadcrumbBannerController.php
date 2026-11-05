<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreadcrumbBannerRequest;
use App\Models\BreadcrumbBanner;
use App\Models\BreadcrumbBannerStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BreadcrumbBannerController extends Controller
{
    /**
     * [READ - Index] Listing of all breadcrumb banners.
     */
    public function index(Request $request)
    {
        $query = BreadcrumbBanner::with('stats');

        // Search filter
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('page_name', 'like', "%{$term}%")
                  ->orWhere('page_slug', 'like', "%{$term}%")
                  ->orWhere('title', 'like', "%{$term}%")
                  ->orWhere('highlighted_title', 'like', "%{$term}%")
                  ->orWhere('breadcrumb_title', 'like', "%{$term}%");
            });
        }

        $banners = $query->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = BreadcrumbBanner::count();
        $supportedPages = BreadcrumbBanner::supportedPages();

        return view('admin.breadcrumb-banners.index', compact(
            'banners',
            'totalCount',
            'supportedPages'
        ));
    }

    /**
     * [CREATE - Form] Display form to create a new breadcrumb banner.
     */
    public function create()
    {
        $existingSlugs = BreadcrumbBanner::pluck('page_slug')->all();
        $supportedPages = collect(BreadcrumbBanner::supportedPages())
            ->reject(fn (array $page): bool => in_array($page['slug'], $existingSlugs, true))
            ->values()
            ->all();

        return view('admin.breadcrumb-banners.create', compact('supportedPages'));
    }

    /**
     * [CREATE - Store] Persist a new banner.
     */
    public function store(BreadcrumbBannerRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
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

        // Remove non-model keys before create
        $statsInput = $request->input('stats', []);
        unset($data['stats'], $data['background_image_path']);

        $banner = BreadcrumbBanner::create($data);

        // Save stat cards if provided (only for About banner)
        if ($banner->isAboutBanner() && is_array($statsInput) && count($statsInput) > 0) {
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

        flash()->success('Breadcrumb banner for "' . $banner->page_name . '" created successfully.', 'Banner Created');

        return redirect()->route('admin.breadcrumb-banners.index')
            ->with('success', 'Breadcrumb banner for "' . $banner->page_name . '" created successfully.');
    }

    /**
     * [READ - Show] Redirect to edit form.
     */
    public function show($id)
    {
        return redirect()->route('admin.breadcrumb-banners.edit', $id);
    }

    /**
     * [UPDATE - Form] Display form to edit an existing breadcrumb banner.
     */
    public function edit($id)
    {
        $banner = BreadcrumbBanner::with('stats')->findOrFail($id);
        $supportedPages = BreadcrumbBanner::supportedPages();
        $existingSlugs = BreadcrumbBanner::where('id', '!=', $id)->pluck('page_slug')->toArray();

        return view('admin.breadcrumb-banners.edit', compact('banner', 'supportedPages', 'existingSlugs'));
    }

    /**
     * [UPDATE - Save] Update an existing breadcrumb banner.
     */
    public function update(BreadcrumbBannerRequest $request, $id)
    {
        $banner = BreadcrumbBanner::findOrFail($id);
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $uploadDir = public_path('uploads/banners');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Remove old file if it was uploaded locally
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
        } else {
            // Keep current background image when no new file or path is provided
            unset($data['background_image']);
        }

        $statsInput = $request->input('stats', []);
        unset($data['stats'], $data['background_image_path']);

        $banner->update($data);

        // Sync stat cards (only for About banner)
        $banner->stats()->delete();
        if ($banner->isAboutBanner() && is_array($statsInput) && count($statsInput) > 0) {
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

        flash()->success('Breadcrumb banner for "' . $banner->page_name . '" updated successfully.', 'Banner Updated');

        return redirect()->route('admin.breadcrumb-banners.index')
            ->with('success', 'Breadcrumb banner for "' . $banner->page_name . '" updated successfully.');
    }

    /**
     * [DELETE] Remove a breadcrumb banner.
     */
    public function destroy($id)
    {
        $banner = BreadcrumbBanner::findOrFail($id);

        // Delete local image if uploaded
        if ($banner->background_image && Str::startsWith($banner->background_image, '/uploads/banners/')) {
            $oldFile = public_path(ltrim($banner->background_image, '/'));
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $pageName = $banner->page_name;
        $banner->delete();

        flash()->info('Breadcrumb banner for "' . $pageName . '" deleted successfully.', 'Banner Deleted');

        return redirect()->route('admin.breadcrumb-banners.index')
            ->with('success', 'Breadcrumb banner for "' . $pageName . '" deleted successfully.');
    }

    /**
     * Quick status toggle (Active <-> Inactive).
     */
    public function toggle($id)
    {
        $banner = BreadcrumbBanner::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Breadcrumb banners are permanent and always active.',
            ]);
        }

        return redirect()->back()
            ->with('info', 'Breadcrumb banner for "' . $banner->page_name . '" is permanent and always active.');
    }
}
