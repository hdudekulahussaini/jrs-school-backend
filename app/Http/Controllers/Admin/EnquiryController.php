<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionEnquiry;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EnquiryController extends Controller
{
    /**
     * Display a listing of admission enquiries.
     */
    public function index(Request $request)
    {
        $query = AdmissionEnquiry::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Grade filter
        if ($request->filled('grade')) {
            $query->where('grade_applying', $request->input('grade'));
        }

        $enquiries = $query->latest()->paginate(15)->withQueryString();

        $grades = AdmissionEnquiry::select('grade_applying')->distinct()->pluck('grade_applying');

        return view('admin.enquiries.index', compact('enquiries', 'grades'));
    }

    /**
     * Update enquiry status or notes.
     */
    public function update(Request $request, $id)
    {
        $enquiry = AdmissionEnquiry::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,scheduled_tour,admitted,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $enquiry->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }

        return back()->with('success', "Enquiry for {$enquiry->student_name} updated successfully.");
    }

    /**
     * Delete an enquiry.
     */
    public function destroy($id)
    {
        $enquiry = AdmissionEnquiry::findOrFail($id);
        $name = $enquiry->student_name;
        $enquiry->delete();

        return back()->with('success', "Enquiry for {$name} deleted successfully.");
    }

    /**
     * Export enquiries to CSV.
     */
    public function exportCsv(Request $request)
    {
        $fileName = 'jrs_admission_enquiries_' . date('Y-m-d_H-i') . '.csv';

        $query = AdmissionEnquiry::latest();
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $enquiries = $query->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Student Name', 'Parent Name', 'Grade Applying', 'Email', 'Phone', 'City', 'Status', 'Message', 'Admin Notes', 'Date Submitted'];

        $callback = function () use ($enquiries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($enquiries as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->student_name,
                    $item->parent_name,
                    $item->grade_applying,
                    $item->email,
                    $item->phone,
                    $item->city,
                    ucfirst(str_replace('_', ' ', $item->status)),
                    $item->message,
                    $item->admin_notes,
                    $item->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
