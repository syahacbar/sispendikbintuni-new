<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use App\Models\SysSetting;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\Http;
use Closure;

class Login extends BaseLogin
{
    /**
     * Custom view untuk login page
     */
    public function getView(): string
    {
        return 'filament.pages.auth.login';
    }

    /**
     * Get form schema dengan tambahan Google login button dan ReCAPTCHA
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                        ViewField::make('recaptcha')
                            ->view('filament.pages.auth.recaptcha')
                            ->visible($this->isRecaptchaEnabled())
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, Closure $fail) {
                                        if (!$this->isRecaptchaEnabled()) {
                                            return;
                                        }

                                        if (empty($value)) {
                                            $fail('Silakan selesaikan validasi reCAPTCHA.');
                                            return;
                                        }

                                        $secret = SysSetting::getValue('recaptcha_secret_key');

                                        if (empty($secret)) {
                                            // Skip validation if secret is missing to prevent lockout, 
                                            // but ideally this should be configured correctly.
                                            return;
                                        }

                                        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                                            'secret' => $secret,
                                            'response' => $value,
                                        ]);

                                        if (!$response->json('success')) {
                                            $fail('Validasi reCAPTCHA gagal. Silakan coba lagi.');
                                        }
                                    };
                                },
                            ]),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * Check apakah ReCAPTCHA enabled
     */
    public function isRecaptchaEnabled(): bool
    {
        return (bool) SysSetting::getValue('recaptcha_enabled', false);
    }

    /**
     * Check apakah Google login enabled
     */
    public function isGoogleLoginEnabled(): bool
    {
        return (bool) SysSetting::getValue('google_login_enabled', false);
    }

    /**
     * Get Google Client ID untuk validasi
     */
    public function hasGoogleCredentials(): bool
    {
        $clientId = SysSetting::getValue('google_client_id');
        $clientSecret = SysSetting::getValue('google_client_secret');

        return !empty($clientId) && !empty($clientSecret);
    }

    /**
     * Get heading untuk login page
     */
    public function getHeading(): string|Htmlable
    {
        return 'Masuk ke Akun Anda';
    }
}
