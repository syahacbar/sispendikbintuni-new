<?php

namespace App\Filament\Resources\PTKResource\Pages;

use App\Filament\Resources\PTKResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPTK extends EditRecord
{
    protected static string $resource = PTKResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
