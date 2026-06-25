<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

trait InteractsWithGoogleAuth
{
    /**
     * Build the Google Socialite driver with the correct callback URL for this flow.
     */
    protected function googleProvider(string $callbackRouteName): GoogleProvider
    {
        $provider = Socialite::driver('google');

        if (! $provider instanceof GoogleProvider) {
            throw new \RuntimeException('Socialite Google driver is not available.');
        }

        return $provider->redirectUrl($this->googleOAuthRedirectUrl($callbackRouteName));
    }

    /**
     * OAuth redirect URI sent to Google (must match an entry in Google Cloud Console exactly).
     */
    protected function googleOAuthRedirectUrl(string $callbackRouteName): string
    {
        $google = config('services.google', []);

        return match ($callbackRouteName) {
            'student.google.callback' => (string) ($google['redirect_student'] ?? ''),
            'instructor.google.callback' => (string) ($google['redirect_instructor'] ?? ''),
            default => route($callbackRouteName),
        };
    }

    protected function googleOAuthRedirect(string $callbackRouteName)
    {
        return $this->googleProvider($callbackRouteName)->redirect();
    }

    protected function googleOAuthUser(string $callbackRouteName)
    {
        return $this->googleProvider($callbackRouteName)->user();
    }

    protected function googleOAuthConfigured(): bool
    {
        $google = config('services.google', []);

        return filled($google['client_id'] ?? null)
            && filled($google['client_secret'] ?? null)
            && filled($google['redirect_student'] ?? null)
            && filled($google['redirect_instructor'] ?? null);
    }

    /**
     * Find or create a user/instructor from Google OAuth data (by google_id, then email).
     *
     * @param  class-string<Model>  $modelClass
     * @param  array<string, mixed>  $createAttributes  Extra attributes when creating a new record
     */
    protected function findOrCreateFromGoogleUser(
        string $modelClass,
        SocialiteUser $googleUser,
        array $createAttributes = []
    ): Model {
        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();

        if (! $email) {
            throw new \RuntimeException('Google account email is required.');
        }

        $name = $googleUser->getName() ?: Str::before($email, '@');

        $record = null;

        if ($googleId) {
            $record = $modelClass::query()->where('google_id', $googleId)->first();
        }

        if (! $record) {
            $record = $modelClass::query()->where('email', $email)->first();
        }

        if ($record) {
            $updates = [];

            if ($googleId && empty($record->google_id)) {
                $updates['google_id'] = $googleId;
            }

            if (empty($record->name) && $name) {
                $updates['name'] = $name;
            }

            if ($updates !== []) {
                $record->update($updates);
            }

            return $record->fresh();
        }

        return $modelClass::create(array_merge([
            'name' => $name,
            'email' => $email,
            'google_id' => $googleId,
            'password' => Hash::make(Str::random(48)),
        ], $createAttributes));
    }
}
