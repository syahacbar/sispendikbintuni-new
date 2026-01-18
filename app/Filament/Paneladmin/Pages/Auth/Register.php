<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use App\Models\MstSekolah;
use App\Models\SchoolInvitationToken;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Forms;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Exceptions\Halt;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    public ?string $verifiedSchoolName = null;
    public ?string $verifiedNpsn = null;
    public ?string $tokenStatus = 'default'; // 'default', 'error', 'success'

    /**
     * ============================
     * FORM SCHEMA
     * ============================
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getInvitationTokenFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * ============================
     * NAMA FIELD
     * ============================
     */
    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Nama Lengkap')
            ->placeholder('Masukkan nama lengkap Anda')
            ->required()
            ->maxLength(255)
            ->minLength(3)
            ->autofocus()
            ->validationMessages([
                'required' => 'Nama wajib diisi.',
                'max' => 'Nama tidak boleh lebih dari :max karakter.',
                'min' => 'Nama minimal :min karakter.',
            ]);
    }

    /**
     * ============================
     * EMAIL FIELD
     * ============================
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Alamat Email')
            ->placeholder('contoh@email.com')
            ->email()
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel())
            ->validationMessages([
                'required' => 'Email wajib diisi.',
                'email' => 'Format email tidak valid.',
                'unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.',
                'max' => 'Email tidak boleh lebih dari :max karakter.',
            ]);
    }

    /**
     * ============================
     * PASSWORD FIELD
     * ============================
     */
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Kata Sandi')
            ->placeholder('Minimal 8 karakter, kombinasi huruf besar, kecil, angka & simbol')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(
                Password::default()
                    ->min(8)
                    ->mixedCase()           // Wajib huruf besar & kecil
                    ->numbers()             // Wajib ada angka
                    ->symbols()             // Wajib ada simbol
                    ->uncompromised()       // Check against compromised passwords
            )
            ->same('passwordConfirmation')
            ->dehydrateStateUsing(fn($state) => Hash::make($state))
            ->validationMessages([
                'required' => 'Kata sandi wajib diisi.',
                'min' => 'Kata sandi minimal :min karakter.',
                'same' => 'Kata sandi dan konfirmasi kata sandi harus sama.',
            ])
            ->validationAttribute('kata sandi');
    }

    /**
     * ============================
     * PASSWORD CONFIRMATION FIELD
     * ============================
     */
    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label('Konfirmasi Kata Sandi')
            ->placeholder('Ulangi kata sandi Anda')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false)
            ->validationMessages([
                'required' => 'Konfirmasi kata sandi wajib diisi.',
            ])
            ->validationAttribute('konfirmasi kata sandi');
    }

    /**
     * ============================
     * PASSWORD STRENGTH METER COMPONENT
     * ============================
     */
    protected function getPasswordStrengthMeterComponent(): Component
    {
        $strength = $this->passwordStrength ? $this->calculatePasswordStrength($this->passwordStrength) : null;

        return Forms\Components\View::make('filament.components.password-strength-meter')
            ->viewData([
                'strength' => $strength,
            ]);
    }

    /**
     * ============================
     * TOKEN UNDANGAN FIELD
     * ============================
     */
    protected function getInvitationTokenFormComponent(): Component
    {
        return TextInput::make('invitation_token')
            ->label('Token Undangan Sekolah')
            ->placeholder('Masukkan token undangan yang Anda terima')
            ->required()
            ->maxLength(32)
            ->helperText('Token ini dikirimkan oleh admin sekolah melalui email.')
            ->suffixAction(
                Forms\Components\Actions\Action::make('verify_token')
                    ->icon(function () {
                        return match ($this->tokenStatus) {
                            'success' => 'heroicon-o-check-circle',
                            'error' => 'heroicon-o-x-circle',
                            default => 'heroicon-o-shield-check',
                        };
                    })
                    ->iconButton()
                    ->color(function () {
                        return match ($this->tokenStatus) {
                            'success' => 'success',
                            'error' => 'danger',
                            default => 'warning',
                        };
                    })
                    ->action(function ($state, $set, $get) {
                        if (empty($state)) {
                            $this->verifiedSchoolName = null;
                            $this->verifiedNpsn = null;
                            $this->tokenStatus = 'error';

                            Notification::make()
                                ->title('Token Kosong')
                                ->body('Silakan masukkan token terlebih dahulu.')
                                ->warning()
                                ->send();
                            return;
                        }

                        $tokenString = strtoupper($state);
                        $token = SchoolInvitationToken::where('token', $tokenString)->first();

                        if (!$token) {
                            $this->verifiedSchoolName = null;
                            $this->verifiedNpsn = null;
                            $this->tokenStatus = 'error';

                            Notification::make()
                                ->title('Token Tidak Valid')
                                ->body('Token yang Anda masukkan tidak ditemukan.')
                                ->danger()
                                ->send();
                            return;
                        }

                        if (!$token->isValid()) {
                            $this->verifiedSchoolName = null;
                            $this->verifiedNpsn = null;
                            $this->tokenStatus = 'error';

                            $message = $token->used_at
                                ? 'Token sudah pernah digunakan.'
                                : 'Token sudah kadaluarsa.';

                            Notification::make()
                                ->title('Token Tidak Valid')
                                ->body($message)
                                ->danger()
                                ->send();
                            return;
                        }

                        // Check email match
                        $email = $get('email');
                        if ($email && !$token->isEmailMatch($email)) {
                            $this->verifiedSchoolName = null;
                            $this->verifiedNpsn = null;
                            $this->tokenStatus = 'error';

                            Notification::make()
                                ->title('Token Tidak Valid')
                                ->body('Token ini tidak dapat digunakan dengan email tersebut.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Check if school still available
                        $sekolah = $token->sekolah;
                        if (!$sekolah || $sekolah->users_id !== null) {
                            $this->verifiedSchoolName = null;
                            $this->verifiedNpsn = null;
                            $this->tokenStatus = 'error';

                            Notification::make()
                                ->title('Sekolah Tidak Tersedia')
                                ->body('Sekolah ini sudah memiliki admin.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Token is valid! Save school info AND ensure token is saved
                        $this->verifiedSchoolName = $sekolah->nama;
                        $this->verifiedNpsn = $sekolah->npsn;
                        $this->tokenStatus = 'success';

                        // Force set the token value to ensure it's in form state
                        $set('invitation_token', $tokenString);

                        Notification::make()
                            ->title('Token Valid! ✅')
                            ->body("Anda akan terdaftar sebagai admin untuk: {$sekolah->nama}")
                            ->success()
                            ->duration(5000)
                            ->send();
                    })
            )
            ->readOnly(fn() => $this->verifiedSchoolName !== null)
            ->dehydrated(true);
    }

    /**
     * ============================
     * HANDLE REGISTRATION
     * ============================
     */
    protected function handleRegistration(array $data): Model
    {
        $tokenString = strtoupper($data['invitation_token']);
        unset($data['invitation_token']);

        // 🔍 Find token
        $token = SchoolInvitationToken::where('token', $tokenString)->first();

        // ⛔ Validasi token exists
        if (!$token) {
            throw ValidationException::withMessages([
                'data.invitation_token' => 'Token undangan tidak valid.',
            ]);
        }

        // ⛔ Validasi token masih aktif (belum digunakan dan belum expired)
        if (!$token->isValid()) {
            $message = $token->used_at
                ? 'Token undangan sudah pernah digunakan.'
                : 'Token undangan sudah kadaluarsa.';

            throw ValidationException::withMessages([
                'data.invitation_token' => $message,
            ]);
        }

        // ⛔ Validasi email match (jika token spesifik ke email)
        if (!$token->isEmailMatch($data['email'])) {
            throw ValidationException::withMessages([
                'data.invitation_token' => 'Token undangan ini tidak dapat digunakan dengan email tersebut.',
            ]);
        }

        // 🔍 Get sekolah dari token
        $sekolah = $token->sekolah;

        if (!$sekolah) {
            throw ValidationException::withMessages([
                'data.invitation_token' => 'Sekolah tidak ditemukan untuk token ini.',
            ]);
        }

        // ⛔ Cegah sekolah dipakai ulang (race condition)
        if ($sekolah->users_id !== null) {
            throw ValidationException::withMessages([
                'data.invitation_token' => 'Sekolah ini sudah memiliki admin.',
            ]);
        }

        /** @var \App\Models\User $user */
        $user = parent::handleRegistration($data);

        // 🔗 Hubungkan user ke sekolah
        $sekolah->update([
            'users_id' => $user->id,
        ]);

        // ✅ Mark token as used
        $token->markAsUsed($user->id);

        // 🔐 Assign role Filament Shield
        $user->assignRole('admin_sekolah');

        // ✅ Auto-verify email jika email verification dinonaktifkan
        if (!\App\Models\SysSetting::getValue('email_verification_enabled', true)) {
            $user->markEmailAsVerified();
        }

        return $user;
    }


    /**
     * Custom view untuk registration page
     */
    public function getView(): string
    {
        return 'filament.pages.auth.register';
    }
}

