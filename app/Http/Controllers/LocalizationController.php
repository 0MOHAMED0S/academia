<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocalizationController extends Controller
{
    protected array $supportedLocales = ['ar', 'en', 'de'];

    public function switch(string $locale, Request $request)
    {
        if (!in_array($locale, $this->supportedLocales)) {
            $locale = config('app.fallback_locale', 'ar');
        }

        App::setLocale($locale);
        session(['app_locale' => $locale, 'locale' => $locale]);

        $segments = $request->segments();
        if (!empty($segments) && $segments[0] === $locale) {
            $redirect = '/' . implode('/', $segments);
        } else {
            $redirect = LaravelLocalization::getLocalizedURL($locale, $request->server('HTTP_REFERER', '/'));
        }

        return redirect($redirect);
    }
}
