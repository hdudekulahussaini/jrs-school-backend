<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChairmanMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Section 1: Address & Leadership Profile
            'section_badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'profile_badge' => 'nullable|string|max:100',
            'name' => 'required|string|max:150',
            'sub_title' => 'nullable|string|max:200',
            'quote' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'image_path' => 'nullable|string|max:500',
            'remove_image' => 'nullable|boolean',
            'paragraph' => 'required|string',
            'signoff_note' => 'nullable|string|max:150',
            'signoff_name' => 'nullable|string|max:100',
            'signoff_sub' => 'nullable|string|max:150',

            // Section 2: Strategic Commitment Banner
            'commitment_badge' => 'nullable|string|max:100',
            'commitment_title' => 'required|string|max:255',
            'commitment_description' => 'nullable|string',

            'is_active' => 'nullable|boolean',
        ];
    }
}
