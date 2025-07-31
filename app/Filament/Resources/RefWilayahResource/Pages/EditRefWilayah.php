<?php

namespace App\Filament\Resources\RefWilayahResource\Pages;

use App\Filament\Resources\RefWilayahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefWilayah extends EditRecord
{
    protected static string $resource = RefWilayahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
