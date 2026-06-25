<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

/**
 * MultipleLanguageController
 *
 * Handles language switching and locale management.
 * Allows users to change the application language via session and URL.
 *
 * Supported Locales:
 * - ar (Arabic) - RTL
 * - en (English) - LTR
 * - de (Deutsch) - LTR
 */
class MultipleLanguageController extends Controller
{
    /**
     * List of supported locales
     */
    protected array $supportedLocales = ['ar', 'en', 'de'];

    /**
     * Language metadata (name, flag, direction)
     */
    protected array $languages = [
        'ar' => [
            'name' => 'العربية',
            'name_en' => 'Arabic',
            'flag' => '🇸🇦',
            'dir' => 'rtl',
        ],
        'en' => [
            'name' => 'English',
            'name_en' => 'English',
            'flag' => '🇺🇸',
            'dir' => 'ltr',
        ],
        'de' => [
            'name' => 'Deutsch',
            'name_en' => 'German',
            'flag' => '🇩🇪',
            'dir' => 'ltr',
        ],
    ];

    /**
     * Change application language
     *
     * @param Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     *
     * Example: /setlocale/en -> redirects to /en/home
     */
    public function setLocale(Request $request, string $locale)
    {
        // Validate locale
        if (!in_array($locale, $this->supportedLocales)) {
            return back()->with('error', 'Invalid language selected');
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Set application locale
        App::setLocale($locale);

        // Determine the referrer path to maintain navigation context
        $referrer = $request->header('referer', url('/'));

        // Extract path from referrer and remove old locale prefix
        $path = parse_url($referrer, PHP_URL_PATH);

        // Remove any existing locale prefix from path
        foreach ($this->supportedLocales as $supportedLocale) {
            if (str_starts_with($path, '/' . $supportedLocale)) {
                $path = substr($path, strlen($supportedLocale) + 1);
                break;
            }
        }

        // Ensure path starts with /
        if (!str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        // Remove leading slash for route building (laravel-localization will add it)
        $path = ltrim($path, '/');
        if (empty($path)) {
            $path = '/';
        }

        // Redirect to the same page with new locale prefix
        return redirect('/' . $locale . '/' . ltrim($path, '/'))
            ->with('success', 'Language changed successfully');
    }

    /**
     * Get all supported languages
     *
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * Get current language info
     *
     * @return array
     */
    public function getCurrentLanguage(): array
    {
        $locale = app()->getLocale();
        return $this->languages[$locale] ?? $this->languages['ar'];
    }

    /**
     * Get language info by locale
     *
     * @param string $locale
     * @return array|null
     */
    public function getLanguageInfo(string $locale): ?array
    {
        return $this->languages[$locale] ?? null;
    }
}
