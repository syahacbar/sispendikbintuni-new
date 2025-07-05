<?php

namespace App\Filament\Resources\JenisSarprasResource\Pages;

use App\Filament\Resources\JenisSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisSarpras extends EditRecord
{
    protected static string $resource = JenisSarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
