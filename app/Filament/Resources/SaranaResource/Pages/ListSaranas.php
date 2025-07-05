<?php

namespace App\Filament\Resources\SaranaResource\Pages;

use App\Filament\Resources\SaranaResource;
use App\Imports\SaranaImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListSaranas extends ListRecords
{
    protected static string $resource = SaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('Impor Excel')
                ->label('Impor Excel')
                ->modalHeading('Impor Data Sarana')
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
                        Excel::import(new SaranaImport, $path);
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
