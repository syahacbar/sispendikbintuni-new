<?php

namespace App\Filament\Resources\SchoolInvitationTokenResource\Pages;

use App\Filament\Resources\SchoolInvitationTokenResource;
use Filament\Resources\Pages\EditRecord;

class EditSchoolInvitationToken extends EditRecord
{
    protected static string $resource = SchoolInvitationTokenResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
