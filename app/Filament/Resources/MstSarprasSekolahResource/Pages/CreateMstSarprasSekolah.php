<?php

namespace App\Filament\Resources\MstSarprasSekolahResource\Pages;

use App\Filament\Resources\MstSarprasSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMstSarprasSekolah extends CreateRecord
{
    protected static string $resource = MstSarprasSekolahResource::class;
    protected static bool $canCreateAnother = false;
    protected static ?string $breadcrumb = 'Tambah Sarpras';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getHeading(): string
    {
        return 'Tambah Sarpras';
    }
}
