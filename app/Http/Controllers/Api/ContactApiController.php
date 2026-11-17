<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactInquiryRequest;
use App\Mail\ContactInquiryAcknowledgement;
use App\Mail\ContactInquiryAdminNotification;
use App\Models\ContactInquiry;
use App\Models\ContactSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
                'id'            => $contact->id,
                'address'       => $contact->address,
                'phone'         => $contact->phone,
                'phone_2'       => $contact->phone_2,
                'email'         => $contact->email,
                'map_link'      => $contact->map_link,
                'facebook_url'  => $contact->facebook_url,
                'instagram_url' => $contact->instagram_url,
                'twitter_url'   => $contact->twitter_url,
                'youtube_url'   => $contact->youtube_url,
                'linkedin_url'  => $contact->linkedin_url,
            ],
        ], 200);
    }

    /**
     * Submit Online Inquiry Message from Contact Us page.
     * POST /api/contact/inquiry or POST /api/contact-inquiries
     */
    public function storeInquiry(ContactInquiryRequest $request): JsonResponse
    {
        $inquiry = ContactInquiry::create([
            'parent_name' => $request->input('parent_name'),
            'phone'       => $request->input('phone'),
            'grade'       => $request->input('grade'),
            'email'       => $request->input('email'),
            'message'     => $request->input('message'),
            'status'      => 'pending',
            'notes'       => $request->input('notes'),
        ]);

        // Safely dispatch admin notification and user acknowledgement emails
        try {
            $adminRecipient = config('mail.contact_notification_email')
                ?: env('CONTACT_NOTIFICATION_EMAIL')
                ?: ContactSetting::first()?->email
                ?: 'hdudekulahussaini@gmail.com';

            if (filter_var($adminRecipient, FILTER_VALIDATE_EMAIL)) {
                Mail::to($adminRecipient)->queue(new ContactInquiryAdminNotification($inquiry));
            }

            // Send acknowledgement to user if a valid email was provided
            if (!empty($inquiry->email) && filter_var($inquiry->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($inquiry->email)->queue(new ContactInquiryAcknowledgement($inquiry));
            }
        } catch (\Throwable $e) {
            Log::error('Contact inquiry email dispatch failed: ' . $e->getMessage(), [
                'inquiry_id' => $inquiry->id,
                'exception'  => $e,
            ]);
        }

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
                'Grade 11 (MPC)',
                'Grade 11 (BiPC)',
                'Grade 11 (MEC)',
                'Grade 12 (MPC)',
                'Grade 12 (BiPC)',
                'Grade 12 (MEC)',
            ],
        ], 200);
    }
}
