<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionHeroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Filter out empty features
        if ($this->has('features') && is_array($this->features)) {
            $filteredFeatures = array_values(array_filter($this->features, function ($feat) {
                return !empty(trim($feat['title'] ?? ''));
            }));
            $this->merge(['features' => $filteredFeatures]);
        }

        // Filter out empty trust badges
        if ($this->has('trust_badges') && is_array($this->trust_badges)) {
            $filteredBadges = array_values(array_filter(array_map('trim', $this->trust_badges), function ($b) {
                return !empty($b);
            }));
            $this->merge(['trust_badges' => $filteredBadges]);
        }

        // Filter string array helpers for enquiry form options
        $arrayFields = ['enquiry_academic_years', 'enquiry_admission_types'];
        foreach ($arrayFields as $field) {
            if ($this->has($field) && is_array($this->$field)) {
                $filtered = array_values(array_filter(array_map('trim', $this->$field), function ($val) {
                    return !empty($val);
                }));
                $this->merge([$field => $filtered]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'location_tag'              => ['required', 'string', 'max:255'],
            'title'                     => ['required', 'string', 'max:255'],
            'academic_year'             => ['required', 'string', 'max:50'],
            'description'               => ['required', 'string'],
            'phone'                     => ['required', 'string', 'max:50'],
            'email'                     => ['required', 'email', 'max:255'],
            'features'                  => ['nullable', 'array'],
            'features.*.title'          => ['required_with:features', 'string', 'max:150'],
            'features.*.subtitle'       => ['nullable', 'string', 'max:255'],
            'features.*.icon'           => ['nullable', 'string', 'max:150'],
            'trust_badges'              => ['nullable', 'array'],
            'trust_badges.*'            => ['nullable', 'string', 'max:150'],

            // Enquiry Form settings
            'enquiry_academic_years'    => ['nullable', 'array'],
            'enquiry_academic_years.*'  => ['nullable', 'string', 'max:50'],
            'enquiry_admission_types'   => ['nullable', 'array'],
            'enquiry_admission_types.*' => ['nullable', 'string', 'max:100'],
        ];
    }
}
