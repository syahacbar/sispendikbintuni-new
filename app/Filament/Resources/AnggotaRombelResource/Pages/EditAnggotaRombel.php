<?php

namespace App\Filament\Resources\AnggotaRombelResource\Pages;

use App\Filament\Resources\AnggotaRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnggotaRombel extends EditRecord
{
    protected static string $resource = AnggotaRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
