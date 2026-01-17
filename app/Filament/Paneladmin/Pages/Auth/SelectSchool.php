<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use App\Models\MstSekolah;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\SimplePage;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class SelectSchool extends SimplePage
{
    protected static string $view = 'filament.pages.auth.select-school';

    protected static ?string $title = 'Pilih Sekolah';

    public ?array $data = [];

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
                Select::make('sekolah_id')
                    ->label('Pilih Sekolah Anda')
                    ->helperText('Pilih sekolah yang Anda kelola. Sekolah yang sudah memiliki admin tidak akan muncul dalam daftar.')
                    ->options(
                        MstSekolah::query()
                            ->whereNull('users_id') // Only schools without admin
                            ->orderBy('nama')
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->placeholder('-- Pilih Sekolah --'),
            ])
            ->statePath('data');
    }

    /**
     * Handle form submission
     */
    public function submit(): void
    {
        $data = $this->form->getState();
        $sekolahId = $data['sekolah_id'];
        $user = Auth::user();

        // Double-check if school is still available (race condition protection)
        $sekolah = MstSekolah::where('id', $sekolahId)
            ->whereNull('users_id')
            ->first();

        if (!$sekolah) {
            Notification::make()
                ->title('Sekolah Tidak Tersedia')
                ->body('Maaf, sekolah yang Anda pilih sudah diklaim oleh admin lain. Silakan pilih sekolah lain.')
                ->danger()
                ->send();

            // Refresh the form to show updated school list
            $this->form->fill();
            return;
        }

        // Associate school with user
        $sekolah->update([
            'users_id' => $user->id,
        ]);

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
                ->icon('heroicon-o-arrow-right'),
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
