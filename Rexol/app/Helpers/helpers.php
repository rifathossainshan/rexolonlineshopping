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

    function app_favicon()
    {
        return Cache::rememberForever('site_favicon', function () {
            $faviconPath = Setting::where('key', 'site_favicon')->value('value');
            return $faviconPath ? asset($faviconPath) : asset('favicon.ico');
        });
    }

    function invoice_logo()
    {
        // Different cache key to avoid conflicts, but logic can check site_logo too
        return Cache::rememberForever('invoice_logo_path', function () {
            // 1. Check for specific invoice logo
            $invoiceLogo = Setting::where('key', 'invoice_logo')->value('value');
            if ($invoiceLogo && file_exists(public_path($invoiceLogo))) {
                return public_path($invoiceLogo);
            }

            // 2. Fallback to site logo (but return Path, not URL, for DomPDF)
            $siteLogo = Setting::where('key', 'site_logo')->value('value');
            if ($siteLogo && file_exists(public_path($siteLogo))) {
                return public_path($siteLogo);
            }

            return null;
        });
    }
}
