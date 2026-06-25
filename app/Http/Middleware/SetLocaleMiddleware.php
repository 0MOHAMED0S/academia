<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * SetLocaleMiddleware
 *
 * Handles locale setting based on URL, session, and user preferences.
 * Sets the application locale, shares locale data with views, and handles RTL/LTR.
 *
 * Features:
 * - Detects locale from URL
 * - Stores locale in session
 * - Shares $currentLocale with all views
 * - Shares $currentDir (rtl/ltr) with all views
 * - Shares $isArabic flag for conditional rendering
 */
class SetLocaleMiddleware
{
    /**
     * Supported locales for the application
     */
    protected array $supportedLocales = ['ar', 'en', 'de'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from URL (laravel-localization sets it in the request)
        $locale = App::getLocale();

        // Validate the locale
        if (!in_array($locale, $this->supportedLocales)) {
            $locale = 'ar'; // Default to Arabic
            App::setLocale($locale);
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Determine text direction based on locale
        $direction = $this->getDirection($locale);

        // Share locale and direction with all views
        view()->share([
            'currentLocale' => $locale,
            'currentDir' => $direction,
            'isArabic' => $locale === 'ar',
            'isEnglish' => $locale === 'en',
            'isGerman' => $locale === 'de',
        ]);

        return $next($request);
    }

    /**
     * Get text direction for locale
     *
     * @param string $locale
     * @return string 'rtl' for Arabic, 'ltr' for others
     */
    protected function getDirection(string $locale): string
    {
        return $locale === 'ar' ? 'rtl' : 'ltr';
    }
}