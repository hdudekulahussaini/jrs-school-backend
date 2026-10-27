<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSettingRequest extends FormRequest
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
            'address'                 => ['required', 'string'],
            'phone'                   => ['required', 'string', 'max:50'],
            'email'                   => ['required', 'email', 'max:255'],
            'map_link'                => ['nullable', 'string'],
            'facebook_url'            => ['nullable', 'string', 'max:500'],
            'instagram_url'           => ['nullable', 'string', 'max:500'],
            'twitter_url'             => ['nullable', 'string', 'max:500'],
            'youtube_url'             => ['nullable', 'string', 'max:500'],
            'linkedin_url'            => ['nullable', 'string', 'max:500'],
            'social_links'            => ['nullable', 'array'],
            'social_links.*.platform' => ['nullable', 'string', 'max:100'],
            'social_links.*.icon'     => ['nullable', 'string', 'max:100'],
            'social_links.*.url'      => ['nullable', 'string', 'max:500'],
        ];
    }
}
