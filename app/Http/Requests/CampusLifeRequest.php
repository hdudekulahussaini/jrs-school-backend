<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CampusLifeRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144',
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
            'title.required' => 'The card title is required (e.g. Eco-Friendly Campus).',
            'image.image' => 'The uploaded file must be a valid image file.',
            'image.max' => 'The image size cannot exceed 6MB.',
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
                'message' => 'Campus life validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
