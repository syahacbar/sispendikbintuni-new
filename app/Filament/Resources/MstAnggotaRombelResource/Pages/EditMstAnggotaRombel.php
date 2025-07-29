<?php

namespace App\Filament\Resources\MstAnggotaRombelResource\Pages;

use App\Filament\Resources\MstAnggotaRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstAnggotaRombel extends EditRecord
{
    protected static string $resource = MstAnggotaRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
