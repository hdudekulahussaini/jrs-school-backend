<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HeroSliderRequest extends FormRequest
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
     * Restricted strictly to the 7 required fields:
     * 1. Hero Background Images (multiple image support)
     * 2. Heading / Title
     * 3. Primary Button Text
     * 4. Primary Button URL
     * 5. Secondary Button Text
     * 6. Secondary Button URL
     * 7. Experience Badge Image
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'primary_button_text' => 'nullable|string|max:100',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:500',
            'experience_badge_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'background_images' => 'nullable|array',
            'background_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|string',
            'image_url' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The hero heading/title is required (e.g. Empowering Minds, Shaping Future Leaders).',
            'title.min' => 'The heading must be at least 2 characters.',
            'experience_badge_image.image' => 'The experience badge must be an image file (PNG, SVG, JPG, WEBP).',
            'experience_badge_image.max' => 'The experience badge size cannot exceed 5MB.',
            'background_images.*.image' => 'Each background photograph must be a valid image file.',
            'background_images.*.mimes' => 'Background photographs must be in jpeg, png, jpg, webp, or svg format.',
            'background_images.*.max' => 'Background photograph size cannot exceed 10MB.',
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
                'message' => 'Hero slider validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
