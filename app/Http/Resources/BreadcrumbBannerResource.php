<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BreadcrumbBannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'page_name' => $this->page_name,
            'page_slug' => $this->page_slug,
            'breadcrumb_title' => $this->breadcrumb_title,
            'title' => $this->title,
            'highlighted_title' => $this->highlighted_title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'background_image' => $this->background_image_url,
            'background_image_raw' => $this->background_image,
            'primary_button' => [
                'text' => $this->primary_button_text,
                'url' => $this->primary_button_url,
            ],
            'secondary_button' => [
                'text' => $this->secondary_button_text,
                'url' => $this->secondary_button_url,
            ],
            'stats' => ($this->isAboutBanner() && $this->stats) ? $this->stats->map(function ($stat) {
                return [
                    'id' => $stat->id,
                    'icon' => $stat->icon,
                    'value' => $stat->value,
                    'label' => $stat->label,
                    'sort_order' => $stat->sort_order,
                ];
            }) : [],
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
