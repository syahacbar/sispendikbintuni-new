<?php

namespace App\Filament\Resources\SchoolInvitationTokenResource\Pages;

use App\Filament\Resources\SchoolInvitationTokenResource;
use App\Models\MstSekolah;
use App\Models\SchoolInvitationToken;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;

class ListSchoolInvitationTokens extends ListRecords
{
    protected static string $resource = SchoolInvitationTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate_bulk_tokens')
                ->label('Generate Token Massal')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->visible(fn() => auth()->user()->hasRole('super_admin'))
                ->requiresConfirmation()
                ->modalHeading('Generate Token untuk Semua Sekolah')
                ->modalDescription('Sistem akan membuat token undangan untuk semua sekolah yang belum memiliki akun admin.')
                ->form([
                    Forms\Components\DateTimePicker::make('expires_at')
                        ->label('Berlaku Hingga')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y H:i')
                        ->default(now()->addDays(30))
                        ->minDate(now())
                        ->helperText('Semua token akan menggunakan tanggal kadaluarsa ini.'),
                ])
                ->action(function (array $data) {
                    // Get all schools without user accounts
                    $schoolsWithoutAccounts = MstSekolah::whereNull('users_id')->get();

                    if ($schoolsWithoutAccounts->isEmpty()) {
                        Notification::make()
                            ->title('Tidak ada sekolah yang perlu token')
                            ->body('Semua sekolah sudah memiliki akun admin.')
                            ->warning()
                            ->send();
                        return;
                    }

                    $createdCount = 0;
                    $skippedCount = 0;

                    foreach ($schoolsWithoutAccounts as $sekolah) {
                        // Check if active token already exists for this school
                        $existingToken = SchoolInvitationToken::where('npsn', $sekolah->npsn)
                            ->active()
                            ->first();

                        if ($existingToken) {
                            $skippedCount++;
                            continue;
                        }

                        // Create new token
                        SchoolInvitationToken::create([
                            'token' => SchoolInvitationToken::generateUniqueToken(16),
                            'npsn' => $sekolah->npsn,
                            'email' => null, // Open token (anyone can use)
                            'expires_at' => $data['expires_at'],
                            'created_by_user_id' => auth()->id(),
                        ]);

                        $createdCount++;
                    }

                    Notification::make()
                        ->title('Token berhasil di-generate!')
                        ->body("Dibuat: {$createdCount} token. Dilewati: {$skippedCount} sekolah (sudah punya token aktif).")
                        ->success()
                        ->duration(8000)
                        ->send();
                }),

            Actions\CreateAction::make()
                ->label('Buat Token Baru')
                ->icon('heroicon-o-plus'),
        ];
    }
}
