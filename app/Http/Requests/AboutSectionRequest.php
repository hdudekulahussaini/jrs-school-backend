<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AboutSectionRequest extends FormRequest
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
            'tagline' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'title_highlight' => 'nullable|string|max:255',
            'description_p1' => 'required|string',
            'description_p2' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image_1_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'image_2_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'video_title' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tagline.required' => 'The section eyebrow/tagline is required (e.g. ABOUT JRS).',
            'title.required' => 'The primary heading title is required.',
            'description_p1.required' => 'The first description paragraph is required.',
        ];
    }

    /**
     * Handle failed validation for API vs Web.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson() || $this->is('api/*')) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
