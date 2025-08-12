<?php

namespace App\Filament\Resources\MstSarprasSekolahResource\Pages;

use App\Filament\Resources\MstSarprasSekolahResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditMstSarprasSekolah extends EditRecord
{
    protected static string $resource = MstSarprasSekolahResource::class;
    protected static ?string $modelLabel = ' University';
    protected static ?string $pluralModelLabel = 'Universities';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getHeading(): string
    {
        return 'Ubah Data';
    }
}
