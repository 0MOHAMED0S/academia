<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * SetLocale Middleware
 *
 * Runs on every web request, after the package has resolved the locale
 * from the URL prefix (/ar, /en, /de). It then:
 *
 *  1. Reads the current locale resolved by LaravelLocalization.
 *  2. Explicitly calls App::setLocale() so Laravel's translator, validator,
 *     and mail use the correct language.
 *  3. Persists the locale in the session so it survives page navigation.
 *  4. Shares two Blade variables with every view:
 *       $currentLocale  — the ISO code  ('ar', 'en', 'de')
 *       $currentDir     — the text direction ('rtl' or 'ltr')
 */
class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Read the locale already set by the package's own middleware.
        //    LaravelLocalization::getCurrentLocale() returns e.g. 'ar'.
        $locale = LaravelLocalization::getCurrentLocale();

        // 2. Tell Laravel's core to use this locale.
        //    This makes __('messages.key'), validation messages, and mails
        //    all render in the correct language automatically.
        App::setLocale($locale);

        // 3. Persist in session so the preference survives navigation.
        session(['app_locale' => $locale]);

        // 4. Derive text direction: only Arabic is RTL in this project.
        $supportedLocales = LaravelLocalization::getSupportedLocales();
        $dir = ($supportedLocales[$locale]['dir'] ?? 'ltr');

        // 5. Share globally with all Blade views so layouts can set
        //    <html lang="ar" dir="rtl"> etc. without re-computing.
        view()->share('currentLocale', $locale);
        view()->share('currentDir',    $dir);

        return $next($request);
    }
}
