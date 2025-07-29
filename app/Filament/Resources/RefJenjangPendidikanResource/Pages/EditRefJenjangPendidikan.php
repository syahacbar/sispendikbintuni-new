<?php

namespace App\Filament\Resources\RefJenjangPendidikanResource\Pages;

use App\Filament\Resources\RefJenjangPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefJenjangPendidikan extends EditRecord
{
    protected static string $resource = RefJenjangPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
