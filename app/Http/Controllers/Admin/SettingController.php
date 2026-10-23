<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolSetting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SchoolSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        foreach ($data as $key => $value) {
            SchoolSetting::set($key, $value);
        }

        return back()->with('success', 'School settings updated successfully.');
    }
}
