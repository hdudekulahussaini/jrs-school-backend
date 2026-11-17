<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MandatoryDisclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MandatoryDisclosureController extends Controller
{
    /**
     * Display listing of mandatory disclosure entries.
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('table', $request->query('tab', 'general_info'));
        if (!in_array($activeTab, ['general_info', 'document', 'infrastructure', 'smc'])) {
            $activeTab = 'general_info';
        }

        $query = MandatoryDisclosure::query()->where('category', $activeTab);

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('value', 'like', "%{$term}%")
                  ->orWhere('button_label', 'like', "%{$term}%");
            });
        }

        $items = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $generalInfos = MandatoryDisclosure::where('category', 'general_info')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $documents = MandatoryDisclosure::where('category', 'document')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $infrastructures = MandatoryDisclosure::where('category', 'infrastructure')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $smcItems = MandatoryDisclosure::where('category', 'smc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalCount = MandatoryDisclosure::count();
        $generalCount = $generalInfos->count();
        $documentCount = $documents->count();
        $infrastructureCount = $infrastructures->count();
        $smcCount = $smcItems->count();
        $activeCount = MandatoryDisclosure::where('is_active', true)->count();

        return view('admin.mandatory-disclosure.index', compact(
            'items',
            'generalInfos',
            'documents',
            'infrastructures',
            'smcItems',
            'totalCount',
            'generalCount',
            'documentCount',
            'infrastructureCount',
            'smcCount',
            'activeCount',
            'activeTab'
        ));
    }

    /**
     * Show form to create a new mandatory disclosure record.
     */
    public function create(Request $request)
    {
        $category = $request->query('table', $request->query('category'));
        $type = $request->query('type');

        if (!$category) {
            $category = ($type === 'feature') ? 'document' : 'general_info';
        }

        if (!in_array($category, ['general_info', 'document', 'infrastructure', 'smc'])) {
            $category = 'general_info';
        }

        $type = in_array($category, ['document', 'smc']) ? 'feature' : 'table';
        $nextOrder = (MandatoryDisclosure::where('category', $category)->max('sort_order') ?? 0) + 1;

        return view('admin.mandatory-disclosure.create', compact('category', 'type', 'nextOrder'));
    }

    /**
     * Store newly created mandatory disclosure record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(MandatoryDisclosure::validationRules());
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $uploadDir = public_path('uploads/mandatory-disclosure');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['file_path'] = '/uploads/mandatory-disclosure/' . $filename;
        }

        unset($validated['file_upload']);

        if ($validated['category'] === 'general_info') {
            $validated['button_label'] = null;
            $validated['file_path'] = null;
            $validated['file_url'] = null;
            $validated['is_active'] = true;
        } elseif ($validated['category'] === 'document') {
            $validated['value'] = null;
            $validated['button_label'] = null;
            $validated['file_url'] = null;
            $validated['is_active'] = true;
        } elseif ($validated['category'] === 'infrastructure') {
            $validated['is_active'] = true;
        }

        MandatoryDisclosure::create($validated);

        flash()->success('Mandatory Disclosure entry created successfully.', 'Entry Created');

        return redirect()->route('admin.mandatory-disclosure.index', ['table' => $validated['category']])
            ->with('success', 'Mandatory Disclosure entry created successfully.');
    }

    /**
     * Show form to edit mandatory disclosure record.
     */
    public function edit(string $id)
    {
        $item = MandatoryDisclosure::findOrFail($id);
        $type = in_array($item->category, ['document', 'smc']) ? 'feature' : 'table';
        return view('admin.mandatory-disclosure.edit', compact('item', 'type'));
    }

    /**
     * Update mandatory disclosure record.
     */
    public function update(Request $request, string $id)
    {
        $item = MandatoryDisclosure::findOrFail($id);
        $validated = $request->validate(MandatoryDisclosure::validationRules());
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', $item->sort_order);

        if ($request->hasFile('file_upload')) {
            if ($item->file_path && File::exists(public_path(ltrim($item->file_path, '/')))) {
                File::delete(public_path(ltrim($item->file_path, '/')));
            }

            $file = $request->file('file_upload');
            $uploadDir = public_path('uploads/mandatory-disclosure');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['file_path'] = '/uploads/mandatory-disclosure/' . $filename;
        }

        unset($validated['file_upload']);

        if ($validated['category'] === 'general_info') {
            $validated['button_label'] = null;
            $validated['file_path'] = null;
            $validated['file_url'] = null;
            $validated['is_active'] = true;
        } elseif ($validated['category'] === 'document') {
            $validated['value'] = null;
            $validated['button_label'] = null;
            $validated['file_url'] = null;
            $validated['is_active'] = true;
        } elseif ($validated['category'] === 'infrastructure') {
            $validated['is_active'] = true;
        }

        $item->update($validated);

        flash()->success('Mandatory Disclosure entry updated successfully.', 'Entry Updated');

        return redirect()->route('admin.mandatory-disclosure.index', ['table' => $item->category])
            ->with('success', 'Mandatory Disclosure entry updated successfully.');
    }

    /**
     * Delete mandatory disclosure record.
     */
    public function destroy(string $id)
    {
        $item = MandatoryDisclosure::findOrFail($id);
        $category = $item->category;

        if ($item->file_path && File::exists(public_path(ltrim($item->file_path, '/')))) {
            File::delete(public_path(ltrim($item->file_path, '/')));
        }

        $item->delete();

        flash()->info('Mandatory Disclosure entry deleted successfully.', 'Entry Removed');

        return redirect()->route('admin.mandatory-disclosure.index', ['table' => $category])
            ->with('success', 'Mandatory Disclosure entry deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(string $id)
    {
        $item = MandatoryDisclosure::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        if ($item->is_active) {
            flash()->success('Disclosure status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Disclosure status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $item->is_active,
                'message' => 'Status updated successfully.',
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
    }
}
