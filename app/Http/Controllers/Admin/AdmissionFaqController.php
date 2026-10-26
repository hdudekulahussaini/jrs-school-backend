<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionFaqRequest;
use App\Models\AdmissionFaq;
use Illuminate\Http\Request;

class AdmissionFaqController extends Controller
{
    /**
     * [READ - Index] Listing of all Admission FAQs.
     */
    public function index(Request $request)
    {
        $query = AdmissionFaq::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('question', 'like', "%{$term}%")
                  ->orWhere('answer', 'like', "%{$term}%");
            });
        }

        $faqs = $query->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = AdmissionFaq::count();

        return view('admin.admission-faqs.index', compact('faqs', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new FAQ.
     */
    public function create()
    {
        return view('admin.admission-faqs.create');
    }

    /**
     * [CREATE - Store] Persist a new FAQ.
     */
    public function store(AdmissionFaqRequest $request)
    {
        AdmissionFaq::create($request->validated());

        return redirect()->route('admin.admission-faqs.index')
            ->with('success', 'Admission FAQ created successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $faq = AdmissionFaq::findOrFail($id);
        return view('admin.admission-faqs.edit', compact('faq'));
    }

    /**
     * [UPDATE - Save] Update FAQ.
     */
    public function update(AdmissionFaqRequest $request, $id)
    {
        $faq = AdmissionFaq::findOrFail($id);
        $faq->update($request->validated());

        return redirect()->route('admin.admission-faqs.index')
            ->with('success', 'Admission FAQ updated successfully.');
    }

    /**
     * [DELETE] Remove FAQ.
     */
    public function destroy($id)
    {
        $faq = AdmissionFaq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.admission-faqs.index')
            ->with('success', 'Admission FAQ deleted successfully.');
    }
}
