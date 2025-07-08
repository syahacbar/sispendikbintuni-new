<?php

namespace App\Filament\Resources\PesertaDidikResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Str;
use App\Models\PesertaDidik;

use App\Imports\PesertaDidikImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SekolahResource;
use App\Filament\Resources\PesertaDidikResource;

class ListPesertaDidiks extends ListRecords
{
    protected static string $resource = PesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Impor Excel')
                ->label('Impor Excel')
                ->modalHeading('Impor Data Peserta Didik')
                ->modalButton('Impor Sekarang')
                ->form([
                    FileUpload::make('file')
                        ->label('Pilih file Excel')
                        ->required()
                        ->disk('local')
                        ->directory('temp')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                            '.xls',
                            '.xlsx',
                            '.csv',
                        ]),
                ])
                ->action(function (array $data) {
                    try {
                        $path = storage_path('app/' . $data['file']);
                        Excel::import(new PesertaDidikImport, $path);
                        Storage::delete($data['file']);
                        Notification::make()
                            ->title('Impor Berhasil')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Impor Gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
