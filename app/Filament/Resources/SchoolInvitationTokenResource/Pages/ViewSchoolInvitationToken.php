<?php

namespace App\Filament\Resources\SchoolInvitationTokenResource\Pages;

use App\Filament\Resources\SchoolInvitationTokenResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Notifications\Notification;
use App\Mail\SchoolInvitationMail;
use Illuminate\Support\Facades\Mail;

class ViewSchoolInvitationToken extends ViewRecord
{
    protected static string $resource = SchoolInvitationTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('send_email')
                ->label('Kirim Email')
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->visible(fn() => $this->record->email !== null && $this->record->isValid())
                ->requiresConfirmation()
                ->modalHeading('Kirim Email Undangan')
                ->modalDescription(fn() => "Email akan dikirim ke {$this->record->email}")
                ->action(function () {
                    try {
                        Mail::to($this->record->email)->send(new SchoolInvitationMail($this->record));

                        Notification::make()
                            ->title('Email berhasil dikirim!')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal mengirim email')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\EditAction::make()
                ->visible(fn() => $this->record->isValid()),

            Actions\DeleteAction::make()
                ->label('Batalkan Token'),
        ];
    }
}
