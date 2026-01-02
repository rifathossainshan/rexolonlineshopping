<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('app_logo')) {
    function app_logo()
    {
        return Cache::rememberForever('site_logo', function () {
            $logoPath = Setting::where('key', 'site_logo')->value('value');
            return $logoPath ? asset($logoPath) : null;
        });
    }
}
