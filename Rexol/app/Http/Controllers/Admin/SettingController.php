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
        $invoiceLogo = Setting::where('key', 'invoice_logo')->value('value');
        return view('admin.settings.index', compact('logo', 'invoiceLogo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|file|mimes:svg,png,jpg,jpeg|max:2048',
            'invoice_logo' => 'nullable|file|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            // Keep extension to avoid corruption if not SVG
            $filename = 'site_logo.' . $file->getClientOriginalExtension();

            $path = public_path('images');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file->move($path, $filename);

            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => 'images/' . $filename]
            );
        }

        if ($request->hasFile('invoice_logo')) {
            $file = $request->file('invoice_logo');
            $filename = 'invoice_logo.' . $file->getClientOriginalExtension();

            $path = public_path('images');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file->move($path, $filename);

            Setting::updateOrCreate(
                ['key' => 'invoice_logo'],
                ['value' => 'images/' . $filename]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
