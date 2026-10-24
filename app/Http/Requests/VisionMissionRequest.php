<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisionMissionRequest extends FormRequest
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
            'type' => 'nullable|string|max:50',
            'eyebrow' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'eyebrow.required' => 'The badge/eyebrow text is required (e.g. OUR VISION).',
            'title.required' => 'The title is required.',
            'description.required' => 'The description content is required.',
            'image_file.image' => 'The background image must be a valid image file.',
            'image_file.max' => 'The background image size must not exceed 10MB.',
        ];
    }
}
