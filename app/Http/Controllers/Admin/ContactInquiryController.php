<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    /**
     * [READ] Display paginated list of Contact Us messages / inquiries.
     */
    public function index(Request $request)
    {
        $status  = $request->query('status');
        $search  = $request->query('search');
        $perPage = (int) $request->query('per_page', 10);
        if ($perPage < 5 || $perPage > 100) {
            $perPage = 10;
        }

        $query = ContactInquiry::latest();

        if ($status && in_array($status, ['pending', 'contacted', 'resolved', 'closed'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('grade', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total'     => ContactInquiry::count(),
            'pending'   => ContactInquiry::where('status', 'pending')->count(),
            'contacted' => ContactInquiry::where('status', 'contacted')->count(),
            'resolved'  => ContactInquiry::where('status', 'resolved')->count(),
            'closed'    => ContactInquiry::where('status', 'closed')->count(),
        ];

        return view('admin.contact-inquiries.index', compact('inquiries', 'stats', 'status', 'search', 'perPage'));
    }

    /**
     * [READ] Display detailed view of a single Contact Us inquiry.
     */
    public function show(ContactInquiry $contactInquiry)
    {
        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    /**
     * [UPDATE] Update inquiry status or internal admin notes.
     */
    public function update(Request $request, ContactInquiry $contactInquiry)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,contacted,resolved,closed'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ]);

        $contactInquiry->update($validated);

        if ($validated['status'] === 'closed') {
            flash()->warning("Inquiry #{$contactInquiry->id} status marked as Closed.", [], 'Inquiry Closed');
        } elseif ($validated['status'] === 'resolved') {
            flash()->success("Inquiry #{$contactInquiry->id} marked as Resolved.", [], 'Inquiry Resolved');
        } else {
            flash()->info("Inquiry #{$contactInquiry->id} status updated to " . ucfirst($validated['status']) . ".", [], 'Status Updated');
        }

        return redirect()->back()->with('success', "Inquiry #{$contactInquiry->id} status updated to " . ucfirst($validated['status']) . ".");
    }

    /**
     * [DELETE] Delete an inquiry message.
     */
    public function destroy(ContactInquiry $contactInquiry)
    {
        $id = $contactInquiry->id;
        $contactInquiry->delete();

        flash()->info("Inquiry message #{$id} deleted successfully.", [], 'Message Removed');

        return redirect()->back()->with('success', "Inquiry message #{$id} deleted successfully.");
    }

    /**
     * [BULK DELETE] Delete multiple contact inquiries at once.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:contact_inquiries,id'],
        ], [
            'ids.required' => 'Please select at least one message to delete.',
            'ids.min'      => 'Please select at least one message to delete.',
            'ids.*.exists' => 'One or more selected messages could not be found.',
        ]);

        $count = ContactInquiry::whereIn('id', $validated['ids'])->delete();

        flash()->info("{$count} contact " . ($count === 1 ? 'message' : 'messages') . " deleted successfully.", [], 'Bulk Delete Complete');

        return redirect()->back()->with('success', "{$count} contact " . ($count === 1 ? 'message' : 'messages') . " deleted successfully.");
    }
}
