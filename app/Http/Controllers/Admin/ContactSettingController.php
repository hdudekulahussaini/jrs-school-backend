<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSettingRequest;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    /**
     * [READ] Display the Contact Us management form.
     */
    public function index()
    {
        $contact = ContactSetting::first() ?? new ContactSetting([
            'address'  => 'JRS International School, Narapally, Near Uppal Depot, Hyderabad, Telangana',
            'phone'    => '+91 915740 43210',
            'email'    => 'info@jrsinternationalschool.com',
            'map_link' => 'https://maps.google.com/?q=JRS+International+School+Narapally+Hyderabad',
        ]);

        return view('admin.contact-settings.index', compact('contact'));
    }

    /**
     * [UPDATE] Update Contact Us information.
     */
    public function update(ContactSettingRequest $request)
    {
        $contact = ContactSetting::first();

        if ($contact) {
            $contact->update($request->validated());
        } else {
            $contact = ContactSetting::create($request->validated());
        }

        return redirect()->route('admin.contact-settings.index')
            ->with('success', 'Contact details updated successfully.');
    }
}
