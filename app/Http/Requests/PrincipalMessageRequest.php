<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrincipalMessageRequest extends FormRequest
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
            'desk_title' => 'nullable|string|max:191',
            'desk_subtitle' => 'nullable|string|max:191',
            'official_address_badge' => 'nullable|string|max:191',
            'academic_year' => 'nullable|string|max:191',

            'section_badge' => 'nullable|string|max:191',
            'title' => 'required|string|max:255',
            'salutation' => 'nullable|string|max:255',

            'card_badge' => 'nullable|string|max:100',
            'profile_badge' => 'nullable|string|max:100',
            'name' => 'required|string|max:191',
            'sub_title' => 'nullable|string|max:191',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'remove_image' => 'nullable|boolean',

            'paragraph' => 'nullable|string',
            'quote' => 'nullable|string',

            'signoff_note' => 'nullable|string|max:191',
            'signoff_signature' => 'nullable|string|max:191',
            'signoff_name' => 'nullable|string|max:191',
            'signoff_sub' => 'nullable|string|max:191',

            'is_active' => 'nullable|boolean',
        ];
    }
}
