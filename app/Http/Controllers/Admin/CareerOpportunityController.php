<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerOpportunity;
use Illuminate\Http\Request;

class CareerOpportunityController extends Controller
{
    /**
     * Display the modern card-based editor for Career Opportunities / How To Apply.
     */
    public function index()
    {
        $opportunities = CareerOpportunity::orderBy('id', 'desc')->get();
        $activeSection = $opportunities->where('is_active', true)->first() ?? $opportunities->first();

        // If no record exists at all, create a default one
        if (!$activeSection) {
            $activeSection = CareerOpportunity::create([
                'badge' => 'CAREER OPPORTUNITIES',
                'title' => 'Who Are Passionate About Their Field –',
                'highlight_title' => 'A Great Future Awaits You At JRS',
                'description' => "At JRS we are looking for professionals who understand and believe in our philosophy. People who are genuinely interested in creating students who are world-ready, in sync with today's technology and backed by the Indian value system.",
                'card_badge' => 'APPLICATION PROCESS',
                'card_title' => 'How To Apply',
                'card_description' => 'If you are looking for an opportunity to work at JRS International School, please send your resume to:',
                'email' => 'hrjrshyd@gmail.com',
                'checklist_title' => 'Please Ensure You Mention:',
                'checklist_items' => CareerOpportunity::defaultChecklist(),
                'is_active' => true,
            ]);
            $opportunities = CareerOpportunity::orderBy('id', 'desc')->get();
        }

        $totalCount = $opportunities->count();

        return view('admin.careers.opportunities.index', compact('opportunities', 'totalCount', 'activeSection'));
    }

    /**
     * Show the form for creating a new section variation.
     */
    public function create()
    {
        $defaultChecklist = CareerOpportunity::defaultChecklist();
        return view('admin.careers.opportunities.create', compact('defaultChecklist'));
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(CareerOpportunity::validationRules());
        $isActive = $request->has('is_active');
        $validated['is_active'] = $isActive;

        // Process checklist items from array or textarea
        if ($request->has('checklist_items') && is_array($request->input('checklist_items'))) {
            $validated['checklist_items'] = array_values(array_filter(array_map('trim', $request->input('checklist_items'))));
        } elseif ($request->has('checklist_text')) {
            $lines = array_filter(array_map('trim', explode("\n", $request->input('checklist_text'))));
            $validated['checklist_items'] = array_values($lines);
        }

        if ($isActive) {
            CareerOpportunity::where('is_active', true)->update(['is_active' => false]);
        }

        CareerOpportunity::create($validated);

        return redirect()->route('admin.careers-opportunities.index')
            ->with('success', 'Career Opportunities & How To Apply section saved successfully.');
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(CareerOpportunity $careers_opportunity)
    {
        $opportunity = $careers_opportunity;
        $checklistText = is_array($opportunity->checklist_items) 
            ? implode("\n", $opportunity->checklist_items) 
            : '';

        return view('admin.careers.opportunities.edit', compact('opportunity', 'checklistText'));
    }

    /**
     * Update the specified section in storage.
     */
    public function update(Request $request, CareerOpportunity $careers_opportunity)
    {
        $validated = $request->validate(CareerOpportunity::validationRules($careers_opportunity->id));
        $isActive = $request->has('is_active');
        $validated['is_active'] = $isActive;

        if ($request->has('checklist_items') && is_array($request->input('checklist_items'))) {
            $validated['checklist_items'] = array_values(array_filter(array_map('trim', $request->input('checklist_items'))));
        } elseif ($request->has('checklist_text')) {
            $lines = array_filter(array_map('trim', explode("\n", $request->input('checklist_text'))));
            $validated['checklist_items'] = array_values($lines);
        }

        if ($isActive) {
            CareerOpportunity::where('id', '!=', $careers_opportunity->id)->update(['is_active' => false]);
        }

        $careers_opportunity->update($validated);

        return redirect()->route('admin.careers-opportunities.index')
            ->with('success', 'Career Opportunities & How To Apply updated successfully.');
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(CareerOpportunity $careers_opportunity)
    {
        $careers_opportunity->delete();

        return redirect()->route('admin.careers-opportunities.index')
            ->with('success', 'Section deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle($id)
    {
        $item = CareerOpportunity::findOrFail($id);

        if (!$item->is_active) {
            CareerOpportunity::where('is_active', true)->update(['is_active' => false]);
            $item->is_active = true;
        } else {
            $item->is_active = false;
        }

        $item->save();

        return redirect()->back()->with('success', 'Status toggled successfully.');
    }
}
