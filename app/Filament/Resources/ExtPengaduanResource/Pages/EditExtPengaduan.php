<?php

namespace App\Filament\Resources\ExtPengaduanResource\Pages;

use App\Filament\Resources\ExtPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtPengaduan extends EditRecord
{
    protected static string $resource = ExtPengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
