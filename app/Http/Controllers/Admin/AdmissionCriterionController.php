<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionCriterionRequest;
use App\Models\AdmissionCriterion;
use Illuminate\Http\Request;

class AdmissionCriterionController extends Controller
{
    /**
     * [READ - Index] Listing of all Admission Criteria & Guidelines cards.
     */
    public function index(Request $request)
    {
        $query = AdmissionCriterion::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('badge_tag', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('step_number', 'like', "%{$term}%");
            });
        }

        $criteria = $query->orderBy('step_number', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = AdmissionCriterion::count();

        return view('admin.admission-criteria.index', compact('criteria', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new card.
     */
    public function create()
    {
        $nextStep = (AdmissionCriterion::max('step_number') ?? 0) + 1;
        return view('admin.admission-criteria.create', compact('nextStep'));
    }

    /**
     * [CREATE - Store] Persist a new card.
     */
    public function store(AdmissionCriterionRequest $request)
    {
        AdmissionCriterion::create($request->validated());
        flash()->success('Admission criterion card created successfully.');

        return redirect()->route('admin.admission-criteria.index')
            ->with('success', 'Admission criterion card created successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $criterion = AdmissionCriterion::findOrFail($id);
        return view('admin.admission-criteria.edit', compact('criterion'));
    }

    /**
     * [UPDATE - Save] Update card.
     */
    public function update(AdmissionCriterionRequest $request, $id)
    {
        $criterion = AdmissionCriterion::findOrFail($id);
        $criterion->update($request->validated());
        flash()->success('Admission criterion card updated successfully.');

        return redirect()->route('admin.admission-criteria.index')
            ->with('success', 'Admission criterion card updated successfully.');
    }

    /**
     * [DELETE] Remove card.
     */
    public function destroy($id)
    {
        $criterion = AdmissionCriterion::findOrFail($id);
        $criterion->delete();
        flash()->info('Admission criterion card deleted successfully.');

        return redirect()->route('admin.admission-criteria.index')
            ->with('success', 'Admission criterion card deleted successfully.');
    }
}
