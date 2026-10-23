<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('sort_order')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'icon_name' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        Facility::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon_name' => $request->icon_name,
            'image_url' => $request->image_url ?? '/images/campus-building.jpg',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Campus facility added.');
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'icon_name' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $facility->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon_name' => $request->icon_name,
            'image_url' => $request->image_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Campus facility updated.');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return back()->with('success', 'Campus facility removed.');
    }
}
