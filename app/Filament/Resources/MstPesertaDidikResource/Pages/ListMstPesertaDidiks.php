<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use App\Filament\Resources\MstPesertaDidikResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstPesertaDidiks extends ListRecords
{
    protected static string $resource = MstPesertaDidikResource::class;

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
                // Kalau user admin_sekolah tapi tidak punya sekolah, tampilkan kosong
                $query->whereRaw('1=0');
            }
        }

        return $query;
    }
}
