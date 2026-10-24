<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PtaMemberRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'designation' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
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
            'name.required' => 'Member full name is required.',
            'designation.required' => 'Designation/Role is required (e.g. CHAIRMAN or MEMBER).',
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
                'message' => 'PTA Member validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
