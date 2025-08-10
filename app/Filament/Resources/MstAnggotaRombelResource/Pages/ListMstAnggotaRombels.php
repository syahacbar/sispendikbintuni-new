<?php

namespace App\Filament\Resources\MstAnggotaRombelResource\Pages;

use App\Filament\Resources\MstAnggotaRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstAnggotaRombels extends ListRecords
{
    protected static string $resource = MstAnggotaRombelResource::class;

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
            // Filter berdasarkan sekolah yang dimiliki user
            $query->whereHas('rombel', function ($q) {
                $q->where('sekolah_id', auth()->user()->sekolah_id);
            });
        }

        return $query;
    }
}
