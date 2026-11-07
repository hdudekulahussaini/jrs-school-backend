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
        $imageRule = [
            'nullable',
            'file',
            'mimes:jpeg,png,jpg,webp,svg',
            'max:6144',
            function (string $attribute, mixed $value, \Closure $fail) {
                $this->validateSecureImage($attribute, $value, $fail);
            },
        ];

        return [
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|max:1000',
            'overview_description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:500',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => $imageRule,
            'existing_gallery_images' => 'nullable|array',
            'existing_gallery_images.*' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => $imageRule,
            'image_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Inspect uploaded image files for security and format integrity.
     */
    protected function validateSecureImage(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!$value instanceof \Illuminate\Http\UploadedFile) {
            return;
        }

        $extension = strtolower($value->getClientOriginalExtension());

        if ($extension === 'svg') {
            $path = $value->getRealPath();
            if (!$path || !is_file($path)) {
                $fail('The uploaded SVG file could not be read.');
                return;
            }

            $content = file_get_contents($path);
            if ($content === false || !str_contains($content, '<svg')) {
                $fail('The uploaded file is not a valid SVG document.');
                return;
            }

            // Reject SVGs containing script tags, event handlers, or dangerous constructs
            $patterns = [
                '/<\s*script/i',
                '/javascript\s*:/i',
                '/data\s*:\s*text\/html/i',
                '/onload\s*=/i',
                '/onerror\s*=/i',
                '/onclick\s*=/i',
                '/onmouseover\s*=/i',
                '/onfocus\s*=/i',
                '/<\s*iframe/i',
                '/<\s*object/i',
                '/<\s*embed/i',
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $content)) {
                    $fail('The SVG image contains unsafe scripts or embedded elements.');
                    return;
                }
            }
        }
    }

    /**
     * Custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'facility title',
            'image' => 'facility photograph',
            'gallery_images' => 'gallery images',
            'gallery_images.*' => 'gallery photo',
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
            'image.file' => 'Please upload a valid facility image.',
            'image.image' => 'The facility photograph must be a valid image file.',
            'image.mimes' => 'The facility photograph must be a file of type: JPG, JPEG, PNG, WEBP, or SVG.',
            'image.max' => 'The facility image size cannot exceed 6MB.',
            'gallery_images.array' => 'Gallery images must be provided as a list of files.',
            'gallery_images.*.file' => 'Each gallery photo must be a valid uploaded file.',
            'gallery_images.*.image' => 'Each gallery photo must be a valid image file.',
            'gallery_images.*.mimes' => 'Gallery images must be JPG, JPEG, PNG, WEBP, or SVG.',
            'gallery_images.*.max' => 'Each gallery image must not exceed 6MB.',
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
