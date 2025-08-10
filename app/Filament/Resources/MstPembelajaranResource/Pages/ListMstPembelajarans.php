<?php

namespace App\Filament\Resources\MstPembelajaranResource\Pages;

use App\Filament\Resources\MstPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstPembelajarans extends ListRecords
{
    protected static string $resource = MstPembelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }


    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if (auth()->user()->hasRole('admin_sekolah')) {
            $query->whereHas('rombel', function ($q) {
                $q->where('sekolah_id', auth()->user()->sekolah_id);
            });
        }

        return $query;
    }
}
