<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use App\Filament\Resources\MstPesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstPesertaDidik extends EditRecord
{
    protected static string $resource = MstPesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getHeading(): string
    {
        return 'Ubah Data';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
