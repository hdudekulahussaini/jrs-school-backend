<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare input data for validation (handles React camelCase & snake_case aliases).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'parent_name' => $this->input('parent_name') ?? $this->input('parentName') ?? $this->input('name'),
            'phone'       => $this->input('phone') ?? $this->input('phoneNumber') ?? $this->input('phone_number') ?? $this->input('mobile'),
            'grade'       => $this->input('grade') ?? $this->input('gradeOfChild') ?? $this->input('grade_of_child'),
            'email'       => $this->input('email') ?? $this->input('emailAddress') ?? $this->input('email_address'),
            'message'     => $this->input('message') ?? $this->input('yourQuery') ?? $this->input('your_query') ?? $this->input('query'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'parent_name' => ['required', 'string', 'max:150'],
            'phone'       => ['required', 'string', 'max:30'],
            'grade'       => ['nullable', 'string', 'max:50'],
            'email'       => ['nullable', 'email', 'max:150'],
            'message'     => ['required', 'string', 'max:3000'],
            'status'      => ['nullable', 'string', 'in:pending,contacted,resolved,closed'],
            'notes'       => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'parent_name.required' => 'Parent / Guardian name is required.',
            'phone.required'       => 'Phone number is required.',
            'message.required'     => 'Your query or message is required.',
        ];
    }
}
