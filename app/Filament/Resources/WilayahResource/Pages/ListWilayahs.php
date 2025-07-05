<?php

namespace App\Filament\Resources\WilayahResource\Pages;

use Filament\Actions;
use App\Imports\WilayahImport;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\WilayahResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;

class ListWilayahs extends ListRecords
{
    protected static string $resource = WilayahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('Impor Excel')
                ->label('Impor Excel')
                ->modalHeading('Impor Data Wilayah')
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
                        Excel::import(new WilayahImport, $path);
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
