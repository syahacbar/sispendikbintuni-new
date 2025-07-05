<?php

namespace App\Filament\Resources\KelompokMapelResource\Pages;

use App\Filament\Resources\KelompokMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelompokMapel extends EditRecord
{
    protected static string $resource = KelompokMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
