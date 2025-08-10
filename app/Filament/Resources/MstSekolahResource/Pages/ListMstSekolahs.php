<?php

namespace App\Filament\Resources\MstSekolahResource\Pages;

use App\Filament\Resources\MstSekolahResource;
use Filament\Resources\Pages\ListRecords;

class ListMstSekolahs extends ListRecords
{
    protected static string $resource = MstSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        if (auth()->user()->hasRole('admin_sekolah')) {
            $record = auth()->user()->sekolah;

            if ($record) {
                $this->redirect(
                    route(
                        'filament.paneladmin.resources.data-sekolah.edit',
                        ['record' => $record->getKey()]
                    )
                );
            }
        }
    }
}
