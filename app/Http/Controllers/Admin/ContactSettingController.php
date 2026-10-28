<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSettingRequest;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ContactSettingController extends Controller
{
    /**
     * [READ] Display the Contact Us management form.
     */
    public function index()
    {
        $contact = ContactSetting::first() ?? new ContactSetting([
            'address'       => 'JRS International School, Narapally, Near Uppal Depot, Hyderabad, Telangana',
            'phone'         => '+91 915740 43210',
            'email'         => 'info@jrsinternationalschool.com',
            'map_link'      => 'https://maps.google.com/?q=JRS+International+School+Narapally+Hyderabad',
            'facebook_url'  => 'https://facebook.com/jrsinternationalschool',
            'instagram_url' => 'https://instagram.com/jrsinternationalschool',
            'twitter_url'   => 'https://x.com/jrs_school',
            'youtube_url'   => 'https://youtube.com/@jrsinternationalschool',
            'linkedin_url'  => 'https://linkedin.com/company/jrs-international-school',
        ]);

        // Build socialLinks array: prioritize stored JSON, fallback to flat fields or defaults
        $socialLinks = $contact->social_links;
        if (empty($socialLinks) || !is_array($socialLinks)) {
            $socialLinks = [];
            if (!empty($contact->facebook_url)) {
                $socialLinks[] = ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => $contact->facebook_url];
            }
            if (!empty($contact->instagram_url)) {
                $socialLinks[] = ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => $contact->instagram_url];
            }
            if (!empty($contact->twitter_url)) {
                $socialLinks[] = ['platform' => 'X (Twitter)', 'icon' => 'fab fa-x-twitter', 'url' => $contact->twitter_url];
            }
            if (!empty($contact->youtube_url)) {
                $socialLinks[] = ['platform' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => $contact->youtube_url];
            }
            if (!empty($contact->linkedin_url)) {
                $socialLinks[] = ['platform' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => $contact->linkedin_url];
            }

            // If still completely empty, provide standard initial channels
            if (empty($socialLinks)) {
                $socialLinks = [
                    ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => 'https://facebook.com/jrsinternationalschool'],
                    ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => 'https://instagram.com/jrsinternationalschool'],
                    ['platform' => 'X (Twitter)', 'icon' => 'fab fa-x-twitter', 'url' => 'https://x.com/jrs_school'],
                    ['platform' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => 'https://youtube.com/@jrsinternationalschool'],
                    ['platform' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => 'https://linkedin.com/company/jrs-international-school'],
                ];
            }
        }

        return view('admin.contact-settings.index', compact('contact', 'socialLinks'));
    }

    /**
     * [UPDATE] Update Contact Us information.
     */
    public function update(ContactSettingRequest $request)
    {
        $data = $request->validated();

        // Process social_links repeater items
        $socialLinks = [];
        if ($request->has('social_links') && is_array($request->input('social_links'))) {
            foreach ($request->input('social_links') as $item) {
                $url = trim($item['url'] ?? '');
                $platform = trim($item['platform'] ?? '');
                $icon = trim($item['icon'] ?? '');

                if ($url !== '' || $platform !== '') {
                    $socialLinks[] = [
                        'platform' => $platform ?: 'Link',
                        'icon'     => $icon ?: 'fas fa-link',
                        'url'      => $url,
                    ];
                }
            }
        }

        // Auto-sync common platforms to individual flat columns for backward compatibility
        $data['facebook_url'] = null;
        $data['instagram_url'] = null;
        $data['twitter_url'] = null;
        $data['youtube_url'] = null;
        $data['linkedin_url'] = null;

        foreach ($socialLinks as $link) {
            $p = strtolower($link['platform'] ?? '');
            $ic = strtolower($link['icon'] ?? '');
            $u = $link['url'] ?? '';

            if ((str_contains($p, 'facebook') || str_contains($ic, 'facebook')) && empty($data['facebook_url'])) {
                $data['facebook_url'] = $u;
            } elseif ((str_contains($p, 'instagram') || str_contains($ic, 'instagram')) && empty($data['instagram_url'])) {
                $data['instagram_url'] = $u;
            } elseif ((str_contains($p, 'twitter') || str_contains($p, 'x') || str_contains($ic, 'twitter') || str_contains($ic, 'x-twitter')) && empty($data['twitter_url'])) {
                $data['twitter_url'] = $u;
            } elseif ((str_contains($p, 'youtube') || str_contains($ic, 'youtube')) && empty($data['youtube_url'])) {
                $data['youtube_url'] = $u;
            } elseif ((str_contains($p, 'linkedin') || str_contains($ic, 'linkedin')) && empty($data['linkedin_url'])) {
                $data['linkedin_url'] = $u;
            }
        }

        // Only save social_links if the column exists in the database table
        if (Schema::hasColumn('contact_settings', 'social_links')) {
            $data['social_links'] = $socialLinks;
        } else {
            unset($data['social_links']);
        }

        $contact = ContactSetting::first();

        if ($contact) {
            $contact->update($data);
        } else {
            $contact = ContactSetting::create($data);
        }

        flash()->success('Contact details and social links updated successfully.', 'Settings Saved');

        return redirect()->route('admin.contact-settings.index')
            ->with('success', 'Contact details and social links updated successfully.');
    }
}
