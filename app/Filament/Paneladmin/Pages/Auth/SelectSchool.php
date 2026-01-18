<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use App\Models\MstSekolah;
use App\Models\SchoolInvitationToken;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Form;
use Filament\Pages\SimplePage;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class SelectSchool extends SimplePage
{
    protected static string $view = 'filament.pages.auth.select-school';

    protected static ?string $title = 'Verifikasi Token Sekolah';

    public ?array $data = [];

    public ?string $verifiedSchoolName = null;
    public ?string $verifiedNpsn = null;
    public ?string $tokenStatus = 'default'; // 'default', 'error', 'success'

    /**
     * Mount - Check if user already has school
     */
    public function mount(): void
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            $this->redirect('/paneladmin/login');
            return;
        }

        // Check if user already has school
        $user = Auth::user();
        if ($user->sekolah()->exists()) {
            $this->redirect('/paneladmin');
            return;
        }

        $this->form->fill();
    }

    /**
     * Form Schema
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('invitation_token')
                    ->label('Token Undangan Sekolah')
                    ->placeholder('Masukkan token undangan yang Anda terima')
                    ->helperText('Token ini dikirimkan oleh admin sekolah melalui email.')
                    ->required()
                    ->maxLength(32)
                    ->suffixAction(
                        FormAction::make('verify_token')
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
                            ->action(function ($state, $set) {
                                if (empty($state)) {
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

                                // Check email match if token is email-specific
                                $userEmail = Auth::user()->email;
                                if (!$token->isEmailMatch($userEmail)) {
                                    $this->verifiedSchoolName = null;
                                    $this->verifiedNpsn = null;
                                    $this->tokenStatus = 'error';

                                    Notification::make()
                                        ->title('Token Tidak Valid')
                                        ->body('Token ini tidak dapat digunakan dengan email Anda.')
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
                                    ->body("Anda akan terhubung ke: {$sekolah->nama}")
                                    ->success()
                                    ->duration(5000)
                                    ->send();
                            })
                    )
                    ->readOnly(fn() => $this->verifiedSchoolName !== null)
                    ->dehydrated(true),
            ])
            ->statePath('data');
    }

    /**
     * Handle form submission
     */
    public function submit(): void
    {
        $data = $this->form->getState();

        // Check if invitation_token exists in form data
        if (!isset($data['invitation_token']) || empty($data['invitation_token'])) {
            Notification::make()
                ->title('Token Diperlukan')
                ->body('Silakan masukkan dan verifikasi token terlebih dahulu.')
                ->warning()
                ->send();
            return;
        }

        $tokenString = strtoupper($data['invitation_token']);
        $user = Auth::user();

        // Re-validate token
        $token = SchoolInvitationToken::where('token', $tokenString)->first();

        if (!$token || !$token->isValid()) {
            Notification::make()
                ->title('Token Tidak Valid')
                ->body('Silakan verifikasi token terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        // Get school
        $sekolah = $token->sekolah;

        // Double-check if school is still available
        if (!$sekolah || $sekolah->users_id !== null) {
            Notification::make()
                ->title('Sekolah Tidak Tersedia')
                ->body('Sekolah sudah memiliki admin.')
                ->danger()
                ->send();
            return;
        }

        // Associate school with user
        $sekolah->update([
            'users_id' => $user->id,
        ]);

        // Mark token as used
        $token->markAsUsed($user->id);

        // Assign role if not already assigned
        if (!$user->hasRole('admin_sekolah')) {
            $user->assignRole('admin_sekolah');
        }

        Notification::make()
            ->title('Berhasil')
            ->body('Akun Anda berhasil dikaitkan dengan ' . $sekolah->nama)
            ->success()
            ->send();

        // Redirect to admin dashboard
        $this->redirect('/paneladmin');
    }

    /**
     * Get form actions
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('submit')
                ->label('Lanjutkan ke Dashboard')
                ->submit('submit')
                ->color('primary')
                ->icon('heroicon-o-arrow-right')
                ->disabled(fn() => $this->verifiedSchoolName === null),
        ];
    }

    /**
     * Cache form actions
     */
    public function getCachedFormActions(): array
    {
        return $this->getFormActions();
    }

    /**
     * Check if form actions should be full width
     */
    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    /**
     * Check if user can access this page
     */
    public function hasLogo(): bool
    {
        return true;
    }
}
