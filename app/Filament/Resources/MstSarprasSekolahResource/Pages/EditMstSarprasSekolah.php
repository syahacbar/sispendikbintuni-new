<?php

namespace App\Filament\Resources\MstSarprasSekolahResource\Pages;

use App\Filament\Resources\MstSarprasSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstSarprasSekolah extends EditRecord
{
    protected static string $resource = MstSarprasSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
