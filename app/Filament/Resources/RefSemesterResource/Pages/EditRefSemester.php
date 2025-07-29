<?php

namespace App\Filament\Resources\RefSemesterResource\Pages;

use App\Filament\Resources\RefSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefSemester extends EditRecord
{
    protected static string $resource = RefSemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
