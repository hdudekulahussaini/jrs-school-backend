<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs for validation (handling camelCase React payload as well).
     */
    protected function prepareForValidation(): void
    {
        $countryCode = $this->input('country_code') ?? $this->input('countryCode') ?? '+91';
        if (!str_starts_with((string)$countryCode, '+')) {
            $countryCode = '+' . $countryCode;
        }

        $this->merge([
            'academic_year'  => $this->input('academic_year') ?? $this->input('academicYear') ?? '2026-2027',
            'branch'         => $this->input('branch') ?? 'JRS INTERNATIONAL SCHOOL',
            'admission_type' => $this->input('admission_type') ?? $this->input('admissionType') ?? 'DAY SCHOLAR',
            'grade'          => $this->input('grade'),
            'country_code'   => $countryCode,
            'parent_mobile'  => $this->input('parent_mobile') ?? $this->input('parentMobile'),
            'student_dob'    => $this->input('student_dob') ?? $this->input('studentDob'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'academic_year'  => ['required', 'string', 'max:50'],
            'branch'         => ['required', 'string', 'max:150'],
            'admission_type' => ['required', 'string', 'max:100'],
            'grade'          => ['required', 'string', 'max:50'],
            'parent_mobile'  => ['required', 'string', 'max:25'],
            'student_dob'    => ['required', 'date'],
            'status'         => ['nullable', 'string', 'in:pending,contacted,admitted,closed'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom messages for validation.
     */
    public function messages(): array
    {
        return [
            'parent_mobile.required' => 'Parent mobile number is required.',
            'grade.required'         => 'Please select the applying grade / class.',
            'student_dob.required'   => 'Student date of birth is required.',
        ];
    }

    /**
     * Handle failed validation for API vs Web requests.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson() || $this->is('api/*')) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Admission enquiry validation error',
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
