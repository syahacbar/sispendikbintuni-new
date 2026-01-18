<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt as BaseEmailVerificationPrompt;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EmailVerificationPrompt extends BaseEmailVerificationPrompt
{
    /**
     * Override the redirect after email verification
     * to go to login page instead of dashboard
     */
    public function mount(): void
    {
        parent::mount();

        /** @var MustVerifyEmail $user */
        $user = auth()->user();

        // If user is verified, logout and redirect to login
        if ($user?->hasVerifiedEmail()) {
            auth()->logout();

            $this->redirect(route('filament.paneladmin.auth.login'), navigate: false);
        }
    }
}
