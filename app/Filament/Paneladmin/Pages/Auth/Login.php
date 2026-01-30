<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use App\Models\SysSetting;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Livewire\Attributes\Reactive;
use Closure;

class Login extends BaseLogin
{
    /**
     * Error message untuk ditampilkan di atas form
     */
    public ?string $loginError = null;
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
     * Override method authenticate untuk validasi email dan password
     */
    public function authenticate(): ?\Filament\Http\Responses\Auth\Contracts\LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $errorMessage = __('filament-panels::pages/auth/login.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]);

            $this->loginError = $errorMessage;

            Notification::make()
                ->title('Terlalu Banyak Percobaan')
                ->body($errorMessage)
                ->danger()
                ->send();

            throw ValidationException::withMessages([]);
        }

        $data = $this->form->getState();

        // Reset error sebelumnya
        $this->loginError = null;

        // Validasi format email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->loginError = 'Format email tidak valid. Silakan periksa kembali alamat email Anda.';

            Notification::make()
                ->title('Email Tidak Valid')
                ->body($this->loginError)
                ->danger()
                ->send();

            throw ValidationException::withMessages([]);
        }

        // Validasi password tidak boleh kosong
        if (empty($data['password'])) {
            $this->loginError = 'Password wajib diisi.';

            Notification::make()
                ->title('Password Kosong')
                ->body($this->loginError)
                ->danger()
                ->send();

            throw ValidationException::withMessages([]);
        }

        // Coba autentikasi dengan kredensial yang diberikan
        if (
            !Filament::auth()->attempt([
                'email' => $data['email'],
                'password' => $data['password'],
            ], $data['remember'] ?? false)
        ) {
            // Jika gagal, berikan pesan error yang jelas
            $this->loginError = 'Email atau password yang Anda masukkan salah. Silakan dicek kembali.';

            Notification::make()
                ->title('Login Gagal')
                ->body($this->loginError)
                ->danger()
                ->send();

            throw ValidationException::withMessages([]);
        }

        // Reset error jika berhasil
        $this->loginError = null;

        // Regenerate session untuk keamanan
        session()->regenerate();

        return app(\Filament\Http\Responses\Auth\Contracts\LoginResponse::class);
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
