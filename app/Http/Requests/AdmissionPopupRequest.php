<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionPopupRequest extends FormRequest
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
            'is_active'                => 'nullable|boolean',
            'image'                    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_path'               => 'nullable|string|max:500',
            'badge_text'               => 'required|string|max:100',
            'cbse_affiliation_text'    => 'nullable|string|max:255',
            'school_name'              => 'nullable|string|max:255',
            'school_location'          => 'nullable|string|max:255',
            'academic_year_badge'      => 'required|string|max:150',
            'title_prefix'             => 'required|string|max:150',
            'academic_year_highlight'  => 'required|string|max:50',
            'description'              => 'required|string|max:2000',
            'features'                 => 'nullable|array',
            'features.*'               => 'nullable|string|max:255',
            'phone_number'             => 'nullable|string|max:50',
        ];
    }
}
