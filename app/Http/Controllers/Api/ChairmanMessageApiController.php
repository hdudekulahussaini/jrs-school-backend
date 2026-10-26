<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChairmanMessage;
use Illuminate\Http\JsonResponse;

class ChairmanMessageApiController extends Controller
{
    /**
     * Public GET endpoint: /api/chairman or /api/leadership/chairman
     * Returns the two sections for the "Chairman of JRS" page:
     * 1) Chairman's Address & Leadership Profile
     * 2) Strategic Commitment Banner
     */
    public function index(): JsonResponse
    {
        $chairman = ChairmanMessage::where('is_active', true)->first() ?? ChairmanMessage::first();

        if (!$chairman) {
            return response()->json([
                'success' => false,
                'message' => 'No active Chairman section content found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $chairman->id,
                'is_active' => (bool)$chairman->is_active,

                // Section 1: Chairman's Address & Leadership Profile
                'chairman_address' => [
                    'badge' => $chairman->section_badge,
                    'heading' => $chairman->title,
                    'profile' => [
                        'badge' => $chairman->profile_badge,
                        'name' => $chairman->name,
                        'sub_title' => $chairman->sub_title,
                        'quote' => $chairman->quote,
                        'image_url' => $chairman->image_full_url,
                        'image_path' => $chairman->image_path,
                    ],
                    'paragraph' => $chairman->paragraph,
                    'paragraphs' => $chairman->paragraphs,
                    'signoff' => [
                        'note' => $chairman->signoff_note,
                        'name' => $chairman->signoff_name,
                        'sub_title' => $chairman->signoff_sub,
                    ],
                ],

                // Section 2: Our Strategic Commitment Banner
                'strategic_commitment' => [
                    'badge' => $chairman->commitment_badge,
                    'heading' => $chairman->commitment_title,
                    'description' => $chairman->commitment_description,
                ],

                // Flat fields for straightforward binding
                'section_badge' => $chairman->section_badge,
                'title' => $chairman->title,
                'profile_badge' => $chairman->profile_badge,
                'name' => $chairman->name,
                'sub_title' => $chairman->sub_title,
                'quote' => $chairman->quote,
                'image_url' => $chairman->image_full_url,
                'paragraph' => $chairman->paragraph,
                'signoff_note' => $chairman->signoff_note,
                'signoff_name' => $chairman->signoff_name,
                'signoff_sub' => $chairman->signoff_sub,
                'commitment_badge' => $chairman->commitment_badge,
                'commitment_title' => $chairman->commitment_title,
                'commitment_description' => $chairman->commitment_description,
                'updated_at' => $chairman->updated_at,
            ],
        ], 200);
    }
}
