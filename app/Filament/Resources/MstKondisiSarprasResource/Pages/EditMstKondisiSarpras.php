<?php

namespace App\Filament\Resources\MstKondisiSarprasResource\Pages;

use App\Filament\Resources\MstKondisiSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstKondisiSarpras extends EditRecord
{
    protected static string $resource = MstKondisiSarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
