<?php

namespace App\Filament\Resources\SysSettingResource\Pages;

use App\Filament\Resources\SysSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSysSetting extends EditRecord
{
    protected static string $resource = SysSettingResource::class;
    protected static ?string $title = 'Ubah Data Pengaturan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
