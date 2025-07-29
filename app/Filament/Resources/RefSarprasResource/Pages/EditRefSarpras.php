<?php

namespace App\Filament\Resources\RefSarprasResource\Pages;

use App\Filament\Resources\RefSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefSarpras extends EditRecord
{
    protected static string $resource = RefSarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
