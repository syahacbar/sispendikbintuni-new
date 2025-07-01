<?php

namespace App\Filament\Resources\RombonganBelajarResource\Pages;

use App\Filament\Resources\RombonganBelajarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRombonganBelajar extends EditRecord
{
    protected static string $resource = RombonganBelajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
