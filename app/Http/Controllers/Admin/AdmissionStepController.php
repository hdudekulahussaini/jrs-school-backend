<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionStepRequest;
use App\Models\AdmissionStep;
use Illuminate\Http\Request;

class AdmissionStepController extends Controller
{
    /**
     * [READ - Index] Listing of all Admission Process steps.
     */
    public function index(Request $request)
    {
        $query = AdmissionStep::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('step_number', 'like', "%{$term}%");
            });
        }

        $steps = $query->orderBy('step_number', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = AdmissionStep::count();

        return view('admin.admission-steps.index', compact('steps', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new step.
     */
    public function create()
    {
        $nextStep = (AdmissionStep::max('step_number') ?? 0) + 1;
        return view('admin.admission-steps.create', compact('nextStep'));
    }

    /**
     * [CREATE - Store] Persist a new step.
     */
    public function store(AdmissionStepRequest $request)
    {
        AdmissionStep::create($request->validated());

        flash()->success('Admission process step created successfully.', 'Step Created');

        return redirect()->route('admin.admission-steps.index')
            ->with('success', 'Admission process step created successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $step = AdmissionStep::findOrFail($id);
        return view('admin.admission-steps.edit', compact('step'));
    }

    /**
     * [UPDATE - Save] Update step.
     */
    public function update(AdmissionStepRequest $request, $id)
    {
        $step = AdmissionStep::findOrFail($id);
        $step->update($request->validated());

        flash()->success('Admission process step updated successfully.', 'Step Updated');

        return redirect()->route('admin.admission-steps.index')
            ->with('success', 'Admission process step updated successfully.');
    }

    /**
     * [DELETE] Remove step.
     */
    public function destroy($id)
    {
        $step = AdmissionStep::findOrFail($id);
        $step->delete();

        flash()->info('Admission process step deleted successfully.', 'Step Removed');

        return redirect()->route('admin.admission-steps.index')
            ->with('success', 'Admission process step deleted successfully.');
    }
}
