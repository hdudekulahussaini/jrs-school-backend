<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolEventRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'badge_day' => 'nullable|string|max:10',
            'badge_month' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_url' => 'nullable|string|max:1000',
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
            'title' => 'Event Title',
            'event_date' => 'Event Date',
            'badge_day' => 'Badge Day',
            'badge_month' => 'Badge Month',
            'description' => 'Event Description',
            'image' => 'Event Photo',
            'sort_order' => 'Sort Order',
        ];
    }
}
