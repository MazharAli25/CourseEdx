<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function homeCustomization()
    {
        // Get the first record, or null if none exists
        $systemSetting = SystemSetting::first();

        return view('SuperAdmin.SystemSettings.GeneralSettings', compact('systemSetting'));
    }

    public function homeCustomizationUpdate(Request $request)
    {
        // Validation
        $request->validate([
            'webTitle' => 'required|string|max:255',
            'favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        // Get first record or create a new instance (but don't insert yet)
        $systemSetting = SystemSetting::firstOrNew([]);

        // Assign website title
        $systemSetting->webTitle = $request->input('webTitle');

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = time().'_'.$favicon->getClientOriginalName();
            $favicon->move(public_path('uploads/system/'), $faviconName);
            $systemSetting->favicon = 'uploads/system/'.$faviconName;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time().'_'.$logo->getClientOriginalName();
            $logo->move(public_path('uploads/system/'), $logoName);
            $systemSetting->logo = 'uploads/system/'.$logoName;
        }

        // Save the record (insert if new, update if exists)
        $systemSetting->save();

        return back()->with('success', 'System settings updated successfully.');
    }
}
