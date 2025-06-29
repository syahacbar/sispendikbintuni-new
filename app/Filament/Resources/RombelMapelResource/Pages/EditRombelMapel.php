<?php

namespace App\Filament\Resources\RombelMapelResource\Pages;

use App\Filament\Resources\RombelMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRombelMapel extends EditRecord
{
    protected static string $resource = RombelMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
