<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionCriterionRequest extends FormRequest
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
        // Filter empty points if submitted as array
        if ($this->has('points') && is_array($this->points)) {
            $filtered = array_values(array_filter(array_map('trim', $this->points), function ($val) {
                return !empty($val);
            }));
            $this->merge(['points' => $filtered]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'step_number' => ['required', 'integer', 'min:1', 'max:50'],
            'badge_tag'   => ['nullable', 'string', 'max:100'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string'],
            'note'        => ['nullable', 'string'],
            'points'      => ['nullable', 'array'],
            'points.*'    => ['string', 'max:255'],
        ];
    }
}
