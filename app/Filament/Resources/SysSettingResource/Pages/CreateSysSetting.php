<?php

namespace App\Filament\Resources\SysSettingResource\Pages;

use App\Filament\Resources\SysSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

class CreateSysSetting extends CreateRecord
{
    protected static string $resource = SysSettingResource::class;

    protected static ?string $title = 'Tambah Data Pengaturan';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
