<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionEnquiry;
use Illuminate\Http\Request;

class AdmissionEnquiryController extends Controller
{
    /**
     * [READ] Display paginated list of submitted admission enquiries with filter options.
     */
    public function index(Request $request)
    {
        $status  = $request->query('status');
        $search  = $request->query('search');
        $perPage = (int) $request->query('per_page', 10);
        if ($perPage < 5 || $perPage > 100) {
            $perPage = 10;
        }

        $query = AdmissionEnquiry::latest();

        if ($status && in_array($status, ['pending', 'contacted', 'admitted', 'closed'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('parent_mobile', 'like', "%{$search}%")
                  ->orWhere('grade', 'like', "%{$search}%")
                  ->orWhere('branch', 'like', "%{$search}%")
                  ->orWhere('admission_type', 'like', "%{$search}%");
            });
        }

        $enquiries = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total'     => AdmissionEnquiry::count(),
            'pending'   => AdmissionEnquiry::where('status', 'pending')->count(),
            'contacted' => AdmissionEnquiry::where('status', 'contacted')->count(),
            'admitted'  => AdmissionEnquiry::where('status', 'admitted')->count(),
            'closed'    => AdmissionEnquiry::where('status', 'closed')->count(),
        ];

        return view('admin.admission-enquiries.index', compact('enquiries', 'stats', 'status', 'search', 'perPage'));
    }

    /**
     * [READ] Display detailed view of a single admission enquiry.
     */
    public function show(AdmissionEnquiry $admissionEnquiry)
    {
        return view('admin.admission-enquiries.show', compact('admissionEnquiry'));
    }

    /**
     * [UPDATE] Update enquiry status or notes.
     */
    public function update(Request $request, AdmissionEnquiry $admissionEnquiry)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,contacted,admitted,closed'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ]);

        $admissionEnquiry->update($validated);

        if ($validated['status'] === 'closed') {
            flash()->success("Enquiry #{$admissionEnquiry->id} status updated to Closed.");
        } elseif ($validated['status'] === 'admitted') {
            flash()->success("Enquiry #{$admissionEnquiry->id} marked as Admitted!");
        } else {
            flash()->success("Enquiry #{$admissionEnquiry->id} status updated to " . ucfirst($validated['status']) . ".");
        }

        return redirect()->back()->with('success', "Enquiry #{$admissionEnquiry->id} status updated to " . ucfirst($validated['status']) . ".");
    }

    /**
     * [DELETE] Delete an enquiry record.
     */
    public function destroy(AdmissionEnquiry $admissionEnquiry)
    {
        $id = $admissionEnquiry->id;
        $admissionEnquiry->delete();

        flash()->success("Admission enquiry #{$id} deleted successfully.");

        return redirect()->back()->with('success', "Admission enquiry #{$id} deleted successfully.");
    }

    /**
     * [BULK DELETE] Delete multiple admission enquiries at once.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:admission_enquiries,id'],
        ], [
            'ids.required' => 'Please select at least one enquiry to delete.',
            'ids.min'      => 'Please select at least one enquiry to delete.',
            'ids.*.exists' => 'One or more selected enquiries could not be found.',
        ]);

        $count = AdmissionEnquiry::whereIn('id', $validated['ids'])->delete();

        flash()->success("{$count} admission " . ($count === 1 ? 'enquiry' : 'enquiries') . " deleted successfully.");

        return redirect()->back()->with('success', "{$count} admission " . ($count === 1 ? 'enquiry' : 'enquiries') . " deleted successfully.");
    }
}
