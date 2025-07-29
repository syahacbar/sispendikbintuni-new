<?php

namespace App\Filament\Resources\SysSettingResource\Pages;

use App\Filament\Resources\SysSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSysSettings extends ListRecords
{
    protected static string $resource = SysSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
