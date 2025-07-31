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
}
