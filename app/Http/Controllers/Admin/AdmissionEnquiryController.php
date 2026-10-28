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
        $status = $request->query('status');
        $search = $request->query('search');

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

        $enquiries = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => AdmissionEnquiry::count(),
            'pending'   => AdmissionEnquiry::where('status', 'pending')->count(),
            'contacted' => AdmissionEnquiry::where('status', 'contacted')->count(),
            'admitted'  => AdmissionEnquiry::where('status', 'admitted')->count(),
            'closed'    => AdmissionEnquiry::where('status', 'closed')->count(),
        ];

        return view('admin.admission-enquiries.index', compact('enquiries', 'stats', 'status', 'search'));
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
            flash()->warning("Enquiry #{$admissionEnquiry->id} status updated to Closed.", 'Enquiry Closed');
        } elseif ($validated['status'] === 'admitted') {
            flash()->success("Enquiry #{$admissionEnquiry->id} marked as Admitted!", 'Student Admitted');
        } else {
            flash()->info("Enquiry #{$admissionEnquiry->id} status updated to " . ucfirst($validated['status']) . ".", 'Status Updated');
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

        flash()->info("Admission enquiry #{$id} deleted successfully.", 'Enquiry Deleted');

        return redirect()->back()->with('success', "Admission enquiry #{$id} deleted successfully.");
    }
}
