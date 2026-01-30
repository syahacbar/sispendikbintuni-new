<?php

namespace App\Filament\Resources\SchoolInvitationTokenResource\Pages;

use App\Filament\Resources\SchoolInvitationTokenResource;
use App\Models\MstSekolah;
use App\Models\SchoolInvitationToken;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SchoolInvitationImport;
use App\Mail\SchoolInvitationMail;
use Illuminate\Support\Facades\Mail;

class ListSchoolInvitationTokens extends ListRecords
{
    protected static string $resource = SchoolInvitationTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import_invitations')
                ->label('Import Undangan (CSV)')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    Forms\Components\FileUpload::make('file')
                        ->label('File CSV/Excel')
                        ->helperText('Format kolom: npsn, email')
                        ->required()
                        ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                        ->disk('public')
                        ->directory('invitation-imports'),
                ])
                ->action(function (array $data) {
                    $filePath = storage_path('app/public/' . $data['file']);

                    try {
                        $rows = Excel::toArray(new SchoolInvitationImport, $filePath)[0]; // First sheet
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal membaca file')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                        return;
                    }

                    $createdCount = 0;
                    $skippedCount = 0;
                    $errorCount = 0;

                    foreach ($rows as $row) {
                        if (empty($row['npsn']) || empty($row['email'])) {
                            continue;
                        }

                        $sekolah = MstSekolah::where('npsn', $row['npsn'])->first();

                        // Skip if school not found or already has user
                        if (!$sekolah || $sekolah->users_id !== null) {
                            $skippedCount++;
                            continue;
                        }

                        // Skip if active token exists
                        $existingToken = SchoolInvitationToken::where('npsn', $sekolah->npsn)
                            ->active()
                            ->first();

                        if ($existingToken) {
                            $skippedCount++;
                            continue;
                        }

                        try {
                            // Create new token
                            $token = SchoolInvitationToken::create([
                                'token' => SchoolInvitationToken::generateUniqueToken(16),
                                'npsn' => $sekolah->npsn,
                                'email' => $row['email'],
                                'expires_at' => now()->addDays(30),
                                'created_by_user_id' => auth()->id(),
                            ]);

                            // Send email
                            Mail::to($token->email)->send(new SchoolInvitationMail($token));

                            $createdCount++;
                        } catch (\Exception $e) {
                            $errorCount++;
                        }
                    }

                    Notification::make()
                        ->title('Import Selesai')
                        ->body("Berhasil: {$createdCount}, Dilewati: {$skippedCount}, Error: {$errorCount}")
                        ->success()
                        ->send();
                }),

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
