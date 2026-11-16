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

        // Prepare normalized social links list
        $socialLinksList = $contact->social_links;
        if (empty($socialLinksList) || !is_array($socialLinksList)) {
            $socialLinksList = array_values(array_filter([
                $contact->facebook_url ? ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => $contact->facebook_url] : null,
                $contact->instagram_url ? ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => $contact->instagram_url] : null,
                $contact->twitter_url ? ['platform' => 'X (Twitter)', 'icon' => 'fab fa-x-twitter', 'url' => $contact->twitter_url] : null,
                $contact->youtube_url ? ['platform' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => $contact->youtube_url] : null,
                $contact->linkedin_url ? ['platform' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => $contact->linkedin_url] : null,
            ]));
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'            => $contact->id,
                'address'       => $contact->address,
                'phone'         => $contact->phone,
                'phone_2'       => $contact->phone_2,
                'phones'        => array_values(array_filter([$contact->phone, $contact->phone_2])),
                'email'         => $contact->email,
                'map_link'      => $contact->map_link,
                'facebook_url'  => $contact->facebook_url,
                'instagram_url' => $contact->instagram_url,
                'twitter_url'   => $contact->twitter_url,
                'youtube_url'   => $contact->youtube_url,
                'linkedin_url'  => $contact->linkedin_url,
                'social_links'  => $socialLinksList,
                'social_links_map' => [
                    'facebook'  => $contact->facebook_url,
                    'instagram' => $contact->instagram_url,
                    'twitter'   => $contact->twitter_url,
                    'x'         => $contact->twitter_url,
                    'youtube'   => $contact->youtube_url,
                    'linkedin'  => $contact->linkedin_url,
                ],
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
                'Grade 11',
                'Grade 12',
            ],
        ], 200);
    }
}
