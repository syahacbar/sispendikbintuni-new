<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    /**
     * Custom view untuk request password reset page
     */
    public function getView(): string
    {
        return 'filament.pages.auth.request-password-reset';
    }
}
