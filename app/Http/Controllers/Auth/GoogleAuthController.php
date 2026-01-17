<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\SysSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user ke Google OAuth
     */
    public function redirectToGoogle()
    {
        // Check if Google login is enabled
        $googleLoginEnabled = SysSetting::getValue('google_login_enabled', false);

        if (!$googleLoginEnabled) {
            return redirect()->route('filament.paneladmin.auth.login')
                ->with('error', 'Login dengan Google tidak tersedia saat ini.');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            // Check if Google login is enabled
            $googleLoginEnabled = SysSetting::getValue('google_login_enabled', false);

            if (!$googleLoginEnabled) {
                return redirect()->route('filament.paneladmin.auth.login')
                    ->with('error', 'Login dengan Google tidak tersedia saat ini.');
            }

            // Get user info from Google
            $googleUser = Socialite::driver('google')->user();

            // Find or create user
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();
            }

            if ($user) {
                // Update existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?? now(), // Auto-verify if not verified
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(), // Auto-verify email for Google users
                    'password' => bcrypt(str()->random(32)), // Random password for security
                ]);

                // Assign default role untuk user baru (admin_sekolah)
                $user->assignRole('admin_sekolah');
            }

            // Login user
            Auth::login($user, true);

            // Check if user has associated school
            if (!$user->sekolah()->exists()) {
                // Redirect to school selection page
                return redirect()->route('auth.select-school')
                    ->with('info', 'Silakan pilih sekolah yang Anda kelola untuk melanjutkan.');
            }

            // Redirect to admin panel dashboard
            return redirect()->intended('/paneladmin');

        } catch (\Exception $e) {
            return redirect()->route('filament.paneladmin.auth.login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }
}
