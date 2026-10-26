<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionBannerRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'title_highlight' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'primary_button_text' => 'nullable|string|max:100',
            'primary_button_link' => 'nullable|string|max:500',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_link' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'image_path' => 'nullable|string|max:500',
        ];
    }
}
