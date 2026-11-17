<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrincipalMessage;
use Illuminate\Http\JsonResponse;

class PrincipalMessageApiController extends Controller
{
    /**
     * Public GET endpoint: /api/principal or /api/leadership/principal
     * Returns the complete data for the "Principal's Message" leadership page:
     * 1) Document Header info (Desk, Academic Year)
     * 2) Leadership Profile Card (Photo, Badges, Name, Designation)
     * 3) Principal's Address (Title, Salutation, Paragraphs, Quote Callout)
     * 4) Sign-off (Note, Signature, Stamp)
     */
    public function index(): JsonResponse
    {
        $principal = PrincipalMessage::where('is_active', true)->first() ?? PrincipalMessage::first();

        if (!$principal) {
            return response()->json([
                'success' => false,
                'message' => 'No active Principal section content found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $principal->id,
                'desk_title' => $principal->desk_title,
                'desk_subtitle' => $principal->desk_subtitle,
                'official_address_badge' => $principal->official_address_badge,
                'academic_year' => $principal->academic_year,
                'section_badge' => $principal->section_badge,
                'title' => $principal->title,
                'salutation' => $principal->salutation,
                'card_badge' => $principal->card_badge,
                'profile_badge' => $principal->profile_badge,
                'name' => $principal->name,
                'sub_title' => $principal->sub_title,
                'image_path' => $principal->image_path,
                'paragraph' => $principal->paragraph,
                'quote' => $principal->quote,
                'signoff_note' => $principal->signoff_note,
                'signoff_signature' => $principal->signoff_signature,
                'signoff_name' => $principal->signoff_name,
                'signoff_sub' => $principal->signoff_sub,
                'is_active' => (bool)$principal->is_active,
            ],
        ], 200);
    }
}
