<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BreadcrumbBannerRequest extends FormRequest
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
        $slug = $this->input('page_slug');

        if (empty($slug) && !empty($this->input('page_name'))) {
            $slug = Str::slug($this->input('page_name'));
        } elseif (!empty($slug)) {
            $slug = Str::slug($slug);
        }

        if ($slug) {
            $this->merge([
                'page_slug' => $slug,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Support finding banner id whether passed as model binding, route param, or input
        $bannerId = $this->route('breadcrumb_banner')?->id 
            ?? $this->route('breadcrumb_banner') 
            ?? $this->route('id') 
            ?? $this->input('id');

        $supportedSlugs = collect(\App\Models\BreadcrumbBanner::supportedPages())->pluck('slug')->toArray();

        return [
            'page_name' => ['required', 'string', 'max:255'],
            'page_slug' => [
                'required',
                'string',
                Rule::in($supportedSlugs),
                Rule::unique('breadcrumb_banners', 'page_slug')->ignore($bannerId),
            ],
            'breadcrumb_title' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'highlighted_title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'primary_button_text' => ['nullable', 'string', 'max:100'],
            'primary_button_url' => ['nullable', 'string', 'max:500'],
            'secondary_button_text' => ['nullable', 'string', 'max:100'],
            'secondary_button_url' => ['nullable', 'string', 'max:500'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:10240'],
            'background_image_path' => ['nullable', 'string', 'max:500'],
            'stats' => ['nullable', 'array'],
            'stats.*.icon' => ['nullable', 'string', 'max:100'],
            'stats.*.value' => ['nullable', 'string', 'max:100'],
            'stats.*.label' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'page_slug.in' => 'Only the 15 predefined website header pages are allowed. Custom pages are not supported.',
            'page_slug.unique' => 'A breadcrumb banner for this page already exists. Please edit the existing banner.',
            'background_image.max' => 'The background image must not be larger than 10MB.',
            'background_image.image' => 'The file uploaded must be a valid image file (jpeg, png, webp, svg, gif).',
        ];
    }
}
