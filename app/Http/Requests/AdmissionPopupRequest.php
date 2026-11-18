<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionPopupRequest extends FormRequest
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
            'is_active'    => 'nullable|boolean',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_path'   => 'nullable|string|max:500',
            'remove_image' => 'nullable|boolean',
        ];
    }
}
