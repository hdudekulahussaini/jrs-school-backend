<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Http\Requests\HomeBannerRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HomeBannerController extends Controller
{
    /**
     * Display the Home Banner manager page.
     */
    public function index()
    {
        $banner = HomeBanner::first();

        return view('admin.home-banners.index', [
            'banner' => $banner,
            'formAction' => route('admin.home-banner.store'),
            'formMethod' => null,
        ]);
    }

    /**
     * The banner is a single configuration; its existing manager is also the create form.
     */
    public function create()
    {
        return view('admin.home-banners.index', [
            'banner' => HomeBanner::first(),
            'formAction' => route('admin.home-banners.store'),
            'formMethod' => null,
        ]);
    }

    /**
     * Display a specific banner in the existing management form.
     */
    public function edit($id)
    {
        $banner = HomeBanner::findOrFail($id);

        return view('admin.home-banners.index', [
            'banner' => $banner,
            'formAction' => route('admin.home-banners.update', $banner->id),
            'formMethod' => 'PUT',
        ]);
    }

    /**
     * Redirect the resource show action to the editable banner details.
     */
    public function show($id)
    {
        return redirect()->route('admin.home-banners.edit', $id);
    }

    /**
     * Store or update the Home Banner image.
     */
    public function store(HomeBannerRequest $request)
    {
        return $this->saveBanner($request, HomeBanner::first() ?: new HomeBanner());
    }

    /**
     * Update a specific banner.
     */
    public function update(HomeBannerRequest $request, $id)
    {
        $banner = HomeBanner::findOrFail($id);

        return $this->saveBanner($request, $banner);
    }

    private function saveBanner(HomeBannerRequest $request, HomeBanner $banner)
    {
        $uploadDir = public_path('uploads/home_banners');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        if ($request->hasFile('image')) {
            // Delete old physical image if exists
            $this->deletePhysicalImage($banner->image_path);

            $file = $request->file('image');
            $filename = 'home_banner_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $banner->image_path = 'uploads/home_banners/' . $filename;
            $banner->save();

            flash()->success('Home banner uploaded successfully.', 'Banner Saved');
        } elseif ($request->filled('image_path')) {
            $banner->image_path = $request->input('image_path');
            $banner->save();

            flash()->success('Home banner updated successfully.', 'Banner Saved');
        } else {
            flash()->warning('Please select an image file to upload.', 'No File Selected');
        }

        return redirect()->route('admin.home-banner.index');
    }

    /**
     * Remove the current Home Banner.
     */
    public function destroy($id = null)
    {
        $banner = $id ? HomeBanner::find($id) : HomeBanner::first();

        if ($banner) {
            $this->deletePhysicalImage($banner->image_path);
            $banner->delete();
            flash()->info('Home banner deleted successfully.', 'Banner Removed');
        }

        return redirect()->route('admin.home-banner.index');
    }

    /**
     * Helper to safely remove uploaded image file from disk.
     */
    private function deletePhysicalImage(?string $path): void
    {
        if (!empty($path) && !str_starts_with($path, 'http://') && !str_starts_with($path, 'https://')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
