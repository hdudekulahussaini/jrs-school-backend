<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreadcrumbBannerRequest;
use App\Models\BreadcrumbBanner;
use App\Models\BreadcrumbBannerStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BreadcrumbBannerController extends Controller
{
    /**
     * Normalize legacy slugs and clean up non-header pages.
     */
    protected function ensureTableExists(): void
    {
        // Migrate legacy slugs and remove non-header pages if present
        if (Schema::hasTable('breadcrumb_banners')) {
            BreadcrumbBanner::where('page_slug', 'principals-message')->update(['page_slug' => 'principal', 'page_name' => 'Principal']);
            BreadcrumbBanner::where('page_slug', 'chairmans-message')->update(['page_slug' => 'chairman', 'page_name' => 'Chairman of JRS']);
            BreadcrumbBanner::where('page_slug', 'amenities')->update(['page_slug' => 'facilities', 'page_name' => 'Amenities']);
            BreadcrumbBanner::where('page_slug', 'beyond-classroom')->update(['page_slug' => 'beyond', 'page_name' => 'Beyond Classroom']);
            BreadcrumbBanner::where('page_slug', 'news-media')->update(['page_slug' => 'media', 'page_name' => 'Media']);

            // Keep strictly only the 15 supported header navigation pages
            $supportedSlugs = collect(BreadcrumbBanner::supportedPages())->pluck('slug')->toArray();
            BreadcrumbBanner::whereNotIn('page_slug', $supportedSlugs)->delete();
        }

        // Auto-clear old primary buttons if any exist
        if (Schema::hasTable('breadcrumb_banners') && BreadcrumbBanner::whereNotNull('primary_button_text')->exists()) {
            BreadcrumbBanner::whereNotNull('primary_button_text')->update([
                'primary_button_text' => null,
                'primary_button_url' => null,
            ]);
        }

        // Drop sort_order and is_active columns from table if they exist
        if (Schema::hasTable('breadcrumb_banners')) {
            $columnsToDrop = [];
            if (Schema::hasColumn('breadcrumb_banners', 'sort_order')) {
                $columnsToDrop[] = 'sort_order';
            }
            if (Schema::hasColumn('breadcrumb_banners', 'is_active')) {
                $columnsToDrop[] = 'is_active';
            }
            if (!empty($columnsToDrop)) {
                Schema::table('breadcrumb_banners', function (\Illuminate\Database\Schema\Blueprint $table) use ($columnsToDrop) {
                    $table->dropColumn($columnsToDrop);
                });
            }
        }
    }

    /**
     * [READ - Index] Listing of all breadcrumb banners.
     */
    public function index(Request $request)
    {
        $this->ensureTableExists();

        $query = BreadcrumbBanner::with('stats');

        // Search filter
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('page_name', 'like', "%{$term}%")
                  ->orWhere('page_slug', 'like', "%{$term}%")
                  ->orWhere('title', 'like', "%{$term}%")
                  ->orWhere('highlighted_title', 'like', "%{$term}%")
                  ->orWhere('breadcrumb_title', 'like', "%{$term}%")
                  ->orWhere('subtitle', 'like', "%{$term}%");
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
        $this->ensureTableExists();

        $supportedPages = BreadcrumbBanner::supportedPages();
        $existingSlugs = BreadcrumbBanner::pluck('page_slug')->toArray();

        return view('admin.breadcrumb-banners.create', compact('supportedPages', 'existingSlugs'));
    }

    /**
     * [CREATE - Store] Persist a new banner.
     */
    public function store(BreadcrumbBannerRequest $request)
    {
        $this->ensureTableExists();

        $data = $request->validated();
        $data['primary_button_text'] = null;
        $data['primary_button_url'] = null;

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
        $this->ensureTableExists();

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
        $this->ensureTableExists();

        $banner = BreadcrumbBanner::findOrFail($id);
        $data = $request->validated();
        $data['primary_button_text'] = null;
        $data['primary_button_url'] = null;

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
        $this->ensureTableExists();

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
        $this->ensureTableExists();

        $banner = BreadcrumbBanner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $banner->is_active,
                'message' => 'Banner status updated to ' . ($banner->is_active ? 'Active' : 'Inactive') . '.',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Status toggled successfully for ' . $banner->page_name . '.');
    }
}
