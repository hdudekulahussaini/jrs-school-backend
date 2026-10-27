<?php

namespace Database\Seeders;

use App\Models\BreadcrumbBanner;
use App\Models\BreadcrumbBannerStat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BreadcrumbBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = BreadcrumbBanner::supportedPages();
        $supportedSlugs = collect($pages)->pluck('slug')->toArray();

        // Migrate legacy slugs if present
        BreadcrumbBanner::where('page_slug', 'principals-message')->update(['page_slug' => 'principal', 'page_name' => 'Principal']);
        BreadcrumbBanner::where('page_slug', 'chairmans-message')->update(['page_slug' => 'chairman', 'page_name' => 'Chairman of JRS']);
        BreadcrumbBanner::where('page_slug', 'amenities')->update(['page_slug' => 'facilities', 'page_name' => 'Amenities']);
        BreadcrumbBanner::where('page_slug', 'beyond-classroom')->update(['page_slug' => 'beyond', 'page_name' => 'Beyond Classroom']);
        BreadcrumbBanner::where('page_slug', 'news-media')->update(['page_slug' => 'media', 'page_name' => 'Media']);

        // Remove legacy banners that are not part of header navigation
        BreadcrumbBanner::whereNotIn('page_slug', $supportedSlugs)->delete();

        foreach ($pages as $index => $pageData) {
            $stats = $pageData['stats'] ?? [];
            unset($pageData['stats']);

            $banner = BreadcrumbBanner::updateOrCreate(
                ['page_slug' => $pageData['slug']],
                [
                    'page_name' => $pageData['name'],
                    'breadcrumb_title' => $pageData['breadcrumb_title'],
                    'title' => $pageData['title'],
                    'highlighted_title' => $pageData['highlighted_title'] ?? null,
                    'subtitle' => $pageData['subtitle'] ?? null,
                    'description' => $pageData['description'] ?? null,
                    'primary_button_text' => $pageData['primary_button_text'] ?? null,
                    'primary_button_url' => $pageData['primary_button_url'] ?? null,
                    'secondary_button_text' => $pageData['secondary_button_text'] ?? null,
                    'secondary_button_url' => $pageData['secondary_button_url'] ?? null,
                ]
            );

            // Seed stats if provided
            if (!empty($stats) && Schema::hasTable('breadcrumb_banner_stats')) {
                // Clear existing and re-seed
                $banner->stats()->delete();
                foreach ($stats as $sIndex => $stat) {
                    BreadcrumbBannerStat::create([
                        'breadcrumb_banner_id' => $banner->id,
                        'icon' => $stat['icon'] ?? 'sparkles',
                        'value' => $stat['value'],
                        'label' => $stat['label'],
                        'sort_order' => $sIndex + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
