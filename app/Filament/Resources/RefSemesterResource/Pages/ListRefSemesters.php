<?php

namespace App\Filament\Resources\RefSemesterResource\Pages;

use App\Filament\Resources\RefSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Closure;

class ListRefSemesters extends ListRecords
{
    protected static string $resource = RefSemesterResource::class;

    public function getHeading(): string
    {
        return 'Data Semester';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Semester')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
