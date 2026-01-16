<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Filament\Resources\MstGtkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditMstGtk extends EditRecord
{
    protected static string $resource = MstGtkResource::class;
    protected static ?string $recordTitleAttribute = 'name';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getHeading(): string
    {
        return 'Ubah Data';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('GTK Diperbarui')
            ->body('Data GTK berhasil diperbarui.');
    }
}
