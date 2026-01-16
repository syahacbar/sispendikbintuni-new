<?php

namespace App\Filament\Resources\RefJenjangPendidikanResource\Pages;

use App\Filament\Resources\RefJenjangPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Closure;

class ListRefJenjangPendidikans extends ListRecords
{
    protected static string $resource = RefJenjangPendidikanResource::class;

    public function getHeading(): string
    {
        return 'Data Jenjang Pendidikan';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Jenjang Pendidikan')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }


}
