<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerBenefit;
use Illuminate\Http\Request;

class CareerBenefitController extends Controller
{
    /**
     * Display a listing of Work Culture & Benefits.
     */
    public function index()
    {
        $benefits = CareerBenefit::orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $activeCount = $benefits->where('is_active', true)->count();
        $totalCount = $benefits->count();

        return view('admin.careers.benefits.index', compact('benefits', 'activeCount', 'totalCount'));
    }

    /**
     * Show the form for creating a new benefit.
     */
    public function create()
    {
        $icons = CareerBenefit::availableIcons();
        $nextOrder = (CareerBenefit::max('sort_order') ?? 0) + 1;
        return view('admin.careers.benefits.create', compact('icons', 'nextOrder'));
    }

    /**
     * Store a newly created benefit in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(CareerBenefit::validationRules());
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        CareerBenefit::create($validated);

        flash()->success('Work Culture & Benefit item added successfully.', 'Benefit Added');

        return redirect()->route('admin.careers-benefits.index')
            ->with('success', 'Work Culture & Benefit item added successfully.');
    }

    /**
     * Show the form for editing the specified benefit.
     */
    public function edit(CareerBenefit $careers_benefit)
    {
        $icons = CareerBenefit::availableIcons();
        $benefit = $careers_benefit;
        return view('admin.careers.benefits.edit', compact('benefit', 'icons'));
    }

    /**
     * Update the specified benefit in storage.
     */
    public function update(Request $request, CareerBenefit $careers_benefit)
    {
        $validated = $request->validate(CareerBenefit::validationRules($careers_benefit->id));
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $careers_benefit->update($validated);

        flash()->success('Work Culture & Benefit item updated successfully.', 'Benefit Updated');

        return redirect()->route('admin.careers-benefits.index')
            ->with('success', 'Work Culture & Benefit item updated successfully.');
    }

    /**
     * Remove the specified benefit from storage.
     */
    public function destroy(CareerBenefit $careers_benefit)
    {
        $careers_benefit->delete();

        flash()->info('Work Culture & Benefit item deleted successfully.', 'Benefit Removed');

        return redirect()->route('admin.careers-benefits.index')
            ->with('success', 'Work Culture & Benefit item deleted successfully.');
    }

    /**
     * Toggle the active status of a benefit item.
     */
    public function toggle($id)
    {
        $benefit = CareerBenefit::findOrFail($id);
        $benefit->is_active = !$benefit->is_active;
        $benefit->save();

        if ($benefit->is_active) {
            flash()->success('Status activated for "' . $benefit->title . '".', 'Status Updated');
        } else {
            flash()->warning('Status deactivated for "' . $benefit->title . '".', 'Status Inactive');
        }

        return redirect()->back()->with('success', 'Status updated for "' . $benefit->title . '".');
    }
}
