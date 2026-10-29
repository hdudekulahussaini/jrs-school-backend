<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FacilityRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|max:1000',
            'overview_description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:500',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144',
            'existing_gallery_images' => 'nullable|array',
            'existing_gallery_images.*' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144',
            'image_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The facility title is required (e.g. Smart Classrooms).',
            'title.min' => 'The title must be at least 2 characters.',
            'image.image' => 'The uploaded file must be a valid image file.',
            'image.max' => 'The facility image size cannot exceed 6MB.',
            'sort_order.integer' => 'Sort order must be an integer.',
        ];
    }

    /**
     * Handle failed validation for API vs Web requests.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson() || $this->is('api/*')) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Facility validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
