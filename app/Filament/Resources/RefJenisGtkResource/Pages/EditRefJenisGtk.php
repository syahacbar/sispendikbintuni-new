<?php

namespace App\Filament\Resources\RefJenisGtkResource\Pages;

use App\Filament\Resources\RefJenisGtkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefJenisGtk extends EditRecord
{
    protected static string $resource = RefJenisGtkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
