<?php

namespace App\Filament\Resources\RefKurikulumResource\Pages;

use App\Filament\Resources\RefKurikulumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefKurikulum extends EditRecord
{
    protected static string $resource = RefKurikulumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
