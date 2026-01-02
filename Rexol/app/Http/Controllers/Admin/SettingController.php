<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $logo = Setting::where('key', 'site_logo')->value('value');
        return view('admin.settings.index', compact('logo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => 'required|file|mimes:svg|max:2048', // 2MB max, SVG only
        ]);

        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = 'site_logo.svg';
            // We'll store it in storage/app/public/settings/ or just public/images/
            // Storing in standard public path for easy access
            $path = public_path('images');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // Move the file
            $file->move($path, $filename);

            // Update DB
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => 'images/site_logo.svg']
            );

            return redirect()->back()->with('success', 'Logo updated successfully.');
        }

        return redirect()->back()->with('error', 'No file uploaded.');
    }
}
