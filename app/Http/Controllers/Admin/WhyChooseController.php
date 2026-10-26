<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseFeature;
use App\Http\Requests\WhyChooseFeatureRequest;
use Illuminate\Http\Request;

class WhyChooseController extends Controller
{
    /**
     * [READ - Index] Listing of Why Choose JRS features & badges.
     */
    public function index(Request $request)
    {
        $query = WhyChooseFeature::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $items = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = WhyChooseFeature::count();

        return view('admin.why-choose.index', compact('items', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new item.
     */
    public function create()
    {
        $nextOrder = (WhyChooseFeature::max('sort_order') ?? 0) + 1;
        return view('admin.why-choose.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new item.
     */
    public function store(WhyChooseFeatureRequest $request)
    {
        $validated = $request->validated();
        $validated['type'] = 'card';
        $validated['is_active'] = true;
        $validated['sort_order'] = $request->input('sort_order', 0);

        WhyChooseFeature::create($validated);

        return redirect()->route('admin.why-choose.index')
            ->with('success', 'Feature card created successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $item = WhyChooseFeature::findOrFail($id);
        return view('admin.why-choose.edit', compact('item'));
    }

    /**
     * [UPDATE - Save] Update item.
     */
    public function update(WhyChooseFeatureRequest $request, $id)
    {
        $item = WhyChooseFeature::findOrFail($id);
        $validated = $request->validated();
        $validated['type'] = $item->type ?? 'card';
        $validated['is_active'] = true;
        $validated['sort_order'] = $request->input('sort_order', 0);

        $item->update($validated);

        return redirect()->route('admin.why-choose.index')
            ->with('success', 'Feature card updated successfully.');
    }

    /**
     * [DELETE - Destroy] Remove item.
     */
    public function destroy($id)
    {
        $item = WhyChooseFeature::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.why-choose.index')
            ->with('success', 'Feature item deleted successfully.');
    }
}
