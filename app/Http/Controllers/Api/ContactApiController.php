<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\JsonResponse;

class ContactApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/contact or /api/contact-us
     */
    public function index(): JsonResponse
    {
        $contact = ContactSetting::first();

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact details not configured yet.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'       => $contact->id,
                'address'  => $contact->address,
                'phone'    => $contact->phone,
                'email'    => $contact->email,
                'map_link' => $contact->map_link,
            ],
        ], 200);
    }
    /**
     * Submit Online Inquiry Message from Contact Us page.
     * POST /api/contact/inquiry or POST /api/contact-inquiries
     */
    public function storeInquiry(\App\Http\Requests\ContactInquiryRequest $request): JsonResponse
    {
        $inquiry = \App\Models\ContactInquiry::create([
            'parent_name' => $request->input('parent_name'),
            'phone'       => $request->input('phone'),
            'grade'       => $request->input('grade'),
            'email'       => $request->input('email'),
            'message'     => $request->input('message'),
            'status'      => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been sent successfully. Our admissions counselor will get back to you within 24 hours.',
            'data'    => $inquiry,
        ], 201);
    }

    /**
     * Get Grade options for the Contact Us inquiry dropdown.
     * GET /api/contact/grades
     */
    public function grades(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'Nursery',
                'LKG',
                'UKG',
                'Grade 1',
                'Grade 2',
                'Grade 3',
                'Grade 4',
                'Grade 5',
                'Grade 6',
                'Grade 7',
                'Grade 8',
                'Grade 9',
                'Grade 10',
                'Grade 11',
                'Grade 12',
            ],
        ], 200);
    }
}
