<?php

namespace App\Filament\Resources\SarprasResource\Pages;

use App\Filament\Resources\SarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSarpras extends EditRecord
{
    protected static string $resource = SarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
