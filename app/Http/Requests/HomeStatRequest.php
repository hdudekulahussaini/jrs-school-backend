<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeStatRequest extends FormRequest
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
            'value' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'value' => 'Metric Value',
            'title' => 'Metric Title / Label',
            'icon' => 'Icon Name',
            'color' => 'Accent Color',
            'description' => 'Description',
            'sort_order' => 'Sort Order',
        ];
    }
}
