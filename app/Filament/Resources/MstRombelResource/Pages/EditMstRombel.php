<?php

namespace App\Filament\Resources\MstRombelResource\Pages;

use App\Filament\Resources\MstRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstRombel extends EditRecord
{
    protected static string $resource = MstRombelResource::class;

    public function getHeading(): string
    {
        return 'Ubah Rombel';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
