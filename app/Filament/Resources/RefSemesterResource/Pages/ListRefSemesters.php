<?php

namespace App\Filament\Resources\RefSemesterResource\Pages;

use App\Filament\Resources\RefSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefSemesters extends ListRecords
{
    protected static string $resource = RefSemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
