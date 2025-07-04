<?php

namespace App\Filament\Resources\InformasiResource\Pages;

use App\Filament\Resources\InformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformasi extends EditRecord
{
    protected static string $resource = InformasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
