<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;

use App\Models\SysSetting;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Http;
use Closure;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        ViewField::make('recaptcha_widget')
                            ->view('filament.pages.auth.recaptcha')
                            ->visible($this->isRecaptchaEnabled()),
                        Hidden::make('recaptcha')
                            ->required()
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

    public function isRecaptchaEnabled(): bool
    {
        return (bool) SysSetting::getValue('recaptcha_enabled', false);
    }
    /**
     * Custom view untuk request password reset page
     */
    public function getView(): string
    {
        return 'filament.pages.auth.request-password-reset';
    }
}
