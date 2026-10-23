<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlide;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.hero.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'badge_text' => 'required|string|max:200',
            'title_line1' => 'required|string|max:100',
            'title_line2' => 'required|string|max:100',
            'description' => 'required|string',
            'cta_primary_text' => 'required|string|max:50',
            'cta_primary_link' => 'required|string|max:200',
            'cta_secondary_text' => 'nullable|string|max:50',
            'cta_secondary_link' => 'nullable|string|max:200',
            'image_url' => 'required|string|max:255',
            'sort_order' => 'integer',
        ]);

        HeroSlide::create([
            'badge_text' => $request->badge_text,
            'title_line1' => $request->title_line1,
            'title_line2' => $request->title_line2,
            'description' => $request->description,
            'cta_primary_text' => $request->cta_primary_text,
            'cta_primary_link' => $request->cta_primary_link,
            'cta_secondary_text' => $request->cta_secondary_text,
            'cta_secondary_link' => $request->cta_secondary_link,
            'image_url' => $request->image_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Hero slide banner added successfully.');
    }

    public function update(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);

        $request->validate([
            'badge_text' => 'required|string|max:200',
            'title_line1' => 'required|string|max:100',
            'title_line2' => 'required|string|max:100',
            'description' => 'required|string',
            'cta_primary_text' => 'required|string|max:50',
            'cta_primary_link' => 'required|string|max:200',
            'cta_secondary_text' => 'nullable|string|max:50',
            'cta_secondary_link' => 'nullable|string|max:200',
            'image_url' => 'required|string|max:255',
            'sort_order' => 'integer',
        ]);

        $slide->update([
            'badge_text' => $request->badge_text,
            'title_line1' => $request->title_line1,
            'title_line2' => $request->title_line2,
            'description' => $request->description,
            'cta_primary_text' => $request->cta_primary_text,
            'cta_primary_link' => $request->cta_primary_link,
            'cta_secondary_text' => $request->cta_secondary_text,
            'cta_secondary_link' => $request->cta_secondary_link,
            'image_url' => $request->image_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Hero slide updated successfully.');
    }

    public function toggle($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->update(['is_active' => !$slide->is_active]);

        return back()->with('success', 'Hero slide visibility updated.');
    }

    public function destroy($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->delete();

        return back()->with('success', 'Hero slide deleted.');
    }
}
