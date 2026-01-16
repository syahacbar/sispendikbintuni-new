<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Filament\Resources\MstGtkResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;
use Filament\Actions\ImportAction;
use App\Filament\Imports\MstGtkImporter;
use Closure;

class ListMstGtks extends ListRecords
{
    protected static string $resource = MstGtkResource::class;

    public function getHeading(): string
    {
        return 'Data GTK';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data GTK')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),

            ImportAction::make()
                ->label('Impor Data GTK')
                ->modalHeading('Impor GTK')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(MstGtkImporter::class)
                ->color('success')
                ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'admin_sekolah']))
                ->options(function () {
                    $user = auth()->user();
                    if ($user->hasRole('admin_sekolah') && $user->sekolah) {
                        return [
                            'tempat_tugas' => $user->sekolah->npsn,
                        ];
                    }
                    return [];
                }),
        ];
    }
}
