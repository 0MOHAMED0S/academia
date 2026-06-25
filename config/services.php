<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OAuth providers (Laravel Socialite)
    |--------------------------------------------------------------------------
    */

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        /*
         * Socialite requires a non-empty `redirect` when building the driver.
         * Per-flow URLs use `redirect_student` / `redirect_instructor` (see InteractsWithGoogleAuth).
         */
        'redirect' => env(
            'GOOGLE_REDIRECT_URI_STUDENT',
            env('GOOGLE_REDIRECT_URI', rtrim((string) env('APP_URL', 'http://localhost'), '/').'/auth/google/student/callback')
        ),
        'redirect_student' => env(
            'GOOGLE_REDIRECT_URI_STUDENT',
            env('GOOGLE_REDIRECT_URI', rtrim((string) env('APP_URL', 'http://localhost'), '/').'/auth/google/student/callback')
        ),
        'redirect_instructor' => env(
            'GOOGLE_REDIRECT_URI_INSTRUCTOR',
            rtrim((string) env('APP_URL', 'http://localhost'), '/').'/auth/google/instructor/callback'
        ),
        'guzzle' => [
            'verify' => filter_var(env('GOOGLE_SSL_VERIFY', true), FILTER_VALIDATE_BOOLEAN),
        ],
    ],

];
