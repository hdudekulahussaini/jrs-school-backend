<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeFeature;
use App\Http\Requests\HomeFeatureRequest;
use Illuminate\Http\Request;

class HomeFeatureController extends Controller
{
    /**
     * [READ - Index] Listing of all home features.
     */
    public function index(Request $request)
    {
        $query = HomeFeature::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('icon', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $features = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = HomeFeature::count();
        $activeCount = HomeFeature::where('is_active', true)->count();
        $inactiveCount = HomeFeature::where('is_active', false)->count();

        return view('admin.features.index', compact('features', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new feature card.
     */
    public function create()
    {
        $nextOrder = (HomeFeature::max('sort_order') ?? 0) + 1;
        return view('admin.features.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new feature card.
     */
    public function store(HomeFeatureRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['color'] = $request->filled('color') ? $request->input('color') : null;
        $validated['icon'] = $request->filled('icon') ? $request->input('icon') : null;

        HomeFeature::create($validated);

        flash()->success('Key Feature card created successfully.', 'Feature Created');

        return redirect()->route('admin.features.index')
            ->with('success', 'Key Feature card created successfully.');
    }

    /**
     * [READ - Show] Redirect to edit form (show page removed).
     */
    public function show($id)
    {
        return redirect()->route('admin.features.edit', $id);
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $feature = HomeFeature::findOrFail($id);
        return view('admin.features.edit', compact('feature'));
    }

    /**
     * [UPDATE - Action] Save updates to an existing feature card.
     */
    public function update(HomeFeatureRequest $request, $id)
    {
        $feature = HomeFeature::findOrFail($id);
        $validated = $request->validated();

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['color'] = $request->filled('color') ? $request->input('color') : null;
        $validated['icon'] = $request->filled('icon') ? $request->input('icon') : null;

        $feature->update($validated);

        flash()->success('Key Feature card updated successfully.', 'Feature Updated');

        return redirect()->route('admin.features.index')
            ->with('success', 'Key Feature card updated successfully.');
    }

    /**
     * [STATUS TOGGLE] Quick switch between active and inactive.
     */
    public function toggle($id)
    {
        $feature = HomeFeature::findOrFail($id);
        $feature->is_active = !$feature->is_active;
        $feature->save();

        if ($feature->is_active) {
            flash()->success('Feature status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Feature status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $feature->is_active,
                'message' => 'Status changed to ' . ($feature->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Feature status changed to ' . ($feature->is_active ? 'Active' : 'Inactive') . '.');
    }

    /**
     * [DELETE] Remove feature card.
     */
    public function destroy($id)
    {
        $feature = HomeFeature::findOrFail($id);
        $feature->delete();

        flash()->info('Key Feature card deleted successfully.', 'Feature Removed');

        return redirect()->route('admin.features.index')
            ->with('success', 'Key Feature card deleted successfully.');
    }
}
