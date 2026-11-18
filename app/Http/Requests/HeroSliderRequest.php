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
     * Restricted strictly to the supported hero slider fields:
     * 1. Hero Background Images (multiple image support)
     * 2. Experience Badge Image (SVG / PNG / JPG / WebP)
     * 3. Primary Button Text
     * 4. Secondary Button Text and URL
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'primary_button_text' => 'nullable|string|max:100',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:500',
            'experience_badge_image' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:5120',
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
            'experience_badge_image.file' => 'The experience badge must be a file.',
            'experience_badge_image.mimes' => 'The experience badge must be an image of type: jpeg, png, jpg, webp, or svg.',
            'experience_badge_image.max' => 'The experience badge file size cannot exceed 5MB.',
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
