<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicStage;

class AcademicStageController extends Controller
{
    public function index()
    {
        $stages = AcademicStage::orderBy('sort_order')->get();
        return view('admin.academics.index', compact('stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stage_number' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:100',
            'description' => 'required|string',
            'key_features_text' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->key_features_text)));

        AcademicStage::create([
            'stage_number' => $request->stage_number,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'key_features' => array_values($features),
            'image_url' => $request->image_url ?? '/images/pre-primary-learning.jpg',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Academic stage added.');
    }

    public function update(Request $request, $id)
    {
        $stage = AcademicStage::findOrFail($id);

        $request->validate([
            'stage_number' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:100',
            'description' => 'required|string',
            'key_features_text' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->key_features_text)));

        $stage->update([
            'stage_number' => $request->stage_number,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'key_features' => array_values($features),
            'image_url' => $request->image_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Academic stage updated.');
    }

    public function destroy($id)
    {
        $stage = AcademicStage::findOrFail($id);
        $stage->delete();

        return back()->with('success', 'Academic stage removed.');
    }
}
