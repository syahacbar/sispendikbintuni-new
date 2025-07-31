<?php

namespace App\Filament\Resources\RefMapelResource\Pages;

use App\Filament\Resources\RefMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefMapel extends EditRecord
{
    protected static string $resource = RefMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
