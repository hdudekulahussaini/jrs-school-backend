<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Http\Requests\HomeBannerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HomeBannerController extends Controller
{
    /**
     * Display the Home Banner manager page.
     */
    public function index()
    {
        HomeBanner::ensureTableExists();

        // Clear default pre-populated banner if present
        $defaultBanners = HomeBanner::where('image_path', 'like', '%home_banner_iit_jee_neet%')->get();
        foreach ($defaultBanners as $d) {
            $this->deletePhysicalImage($d->image_path);
            $d->delete();
        }

        $defaultFile = public_path('uploads/home_banners/home_banner_iit_jee_neet.png');
        if (File::exists($defaultFile)) {
            @File::delete($defaultFile);
        }

        $banner = HomeBanner::first();

        return view('admin.home-banners.index', compact('banner'));
    }

    /**
     * Store or update the Home Banner image.
     */
    public function store(HomeBannerRequest $request)
    {
        HomeBanner::ensureTableExists();

        $uploadDir = public_path('uploads/home_banners');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $banner = HomeBanner::first() ?: new HomeBanner();

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
        HomeBanner::ensureTableExists();

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
