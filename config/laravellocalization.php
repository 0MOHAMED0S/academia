<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    | The default locale for this application. Matches one of the supported
    | locales below.
    */
    'locale' => 'ar',

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    | If a translation key is missing in the current locale, Laravel falls
    | back to this locale.
    */
    'fallback_locale' => 'ar',

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    | All locales the application supports. Each entry needs a 'name', 'script',
    | 'native', 'regional', and 'dir' key.
    */
    'supportedLocales' => [
        'ar' => [
            'name'     => 'Arabic',
            'script'   => 'Arab',
            'native'   => 'العربية',
            'regional' => 'ar_EG',
            'dir'      => 'rtl',
        ],
        'en' => [
            'name'     => 'English',
            'script'   => 'Latn',
            'native'   => 'English',
            'regional' => 'en_GB',
            'dir'      => 'ltr',
        ],
        'de' => [
            'name'     => 'German',
            'script'   => 'Latn',
            'native'   => 'Deutsch',
            'regional' => 'de_DE',
            'dir'      => 'ltr',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Always show locale in URL
    |--------------------------------------------------------------------------
    | Setting this to false would hide the default locale (/ar → /) in the URL.
    | We keep it true so /ar, /en, /de are ALWAYS visible — cleaner and
    | avoids ambiguity.
    */
    'hideDefaultLocaleInURL' => false,

    /*
    |--------------------------------------------------------------------------
    | Use Accept-Language Header
    |--------------------------------------------------------------------------
    | When true, the package reads the browser's Accept-Language header to
    | auto-detect locale on first visit. We set it to false to avoid
    | unexpected redirects; the default locale (ar) is used instead.
    */
    'useAcceptLanguageHeader' => false,

    /*
    |--------------------------------------------------------------------------
    | Use Session to Store Locale
    |--------------------------------------------------------------------------
    */
    'useSessionLocale' => true,

    /*
    |--------------------------------------------------------------------------
    | Use Cookie to Store Locale
    |--------------------------------------------------------------------------
    */
    'useCookieLocale' => false,

    /*
    |--------------------------------------------------------------------------
    | Decode URL parameters
    |--------------------------------------------------------------------------
    */
    'useGeoIpLocale' => false,

    /*
    |--------------------------------------------------------------------------
    | Locales mapping
    |--------------------------------------------------------------------------
    | Map URL segment locales to different application locales.
    | Leave empty if URL locale == app locale.
    */
    'localesMapping' => [],

    /*
    |--------------------------------------------------------------------------
    | UTF-8 encoding
    |--------------------------------------------------------------------------
    */
    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.utf8'),

    /*
    |--------------------------------------------------------------------------
    | Forbidden Locale URLs
    |--------------------------------------------------------------------------
    | These URLs will not be localized.
    */
    'localizedRoutesExclude' => [],

];
