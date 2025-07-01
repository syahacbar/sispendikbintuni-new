<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Resources\SekolahResource;
use App\Imports\SekolahImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListSekolahs extends ListRecords
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('Import Excel')
                ->label('Import Excel')
                ->modalHeading('Import Data Sekolah')
                ->modalButton('Import Sekarang')
                ->form([
                    FileUpload::make('file')
                        ->label('Pilih file Excel')
                        ->required()
                        ->disk('local') // Penting: agar bisa disimpan di storage/app
                        ->directory('temp') // Folder penyimpanan
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
                        // Ambil path absolut dari file yang diupload
                        $path = storage_path('app/' . $data['file']);

                        // Jalankan proses import
                        Excel::import(new SekolahImport, $path);

                        // Hapus file setelah selesai
                        Storage::delete($data['file']);

                        Notification::make()
                            ->title('Import Berhasil')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import Gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
