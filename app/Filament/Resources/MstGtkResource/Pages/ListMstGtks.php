<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Filament\Resources\MstGtkResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstGtks extends ListRecords
{
    protected static string $resource = MstGtkResource::class;

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
            // Ambil sekolah yang terkait user
            $sekolah = MstSekolah::where('users_id', auth()->id())->first();

            if ($sekolah) {
                $query->whereHas('rombels', function ($q) use ($sekolah) {
                    $q->where('sekolah_id', $sekolah->id);
                });
            } else {
                $query->whereRaw('1=0');
            }
        }

        return $query;
    }
}
