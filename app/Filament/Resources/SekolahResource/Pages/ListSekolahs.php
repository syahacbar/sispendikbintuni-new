<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Imports\SekolahImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SekolahResource;

class ListSekolahs extends ListRecords
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('generateAkunMassal')
                ->label('Generate Akun Massal')
                ->icon('heroicon-o-users')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $sekolahs = \App\Models\Sekolah::whereDoesntHave('user')->whereNotNull('email')->get();

                    $akunBaru = [];

                    foreach ($sekolahs as $sekolah) {
                        if (!filter_var($sekolah->email, FILTER_VALIDATE_EMAIL)) {
                            continue;
                        }

                        $password = Str::random(8);

                        $user = \App\Models\User::create([
                            'name' => $sekolah->nama,
                            'email' => $sekolah->email,
                            'password' => Hash::make($password),
                            'sekolah_id' => $sekolah->id,
                        ]);

                        $user->assignRole('admin_sekolah');

                        $akunBaru[] = [
                            'Nama Sekolah' => $sekolah->nama,
                            'Email' => $sekolah->email,
                            'Password' => $password,
                        ];
                    }

                    if (empty($akunBaru)) {
                        Notification::make()
                            ->title('Tidak ada akun baru yang dibuat')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Buat file CSV
                    $filename = 'akun_sekolah_' . now()->format('Ymd_His') . '.csv';
                    $path = storage_path("app/public/{$filename}");
                    $handle = fopen($path, 'w');
                    fputcsv($handle, ['Nama Sekolah', 'Email', 'Password']); // Header CSV

                    foreach ($akunBaru as $akun) {
                        fputcsv($handle, $akun);
                    }

                    fclose($handle);

                    Notification::make()
                        ->title('Akun berhasil dibuat!')
                        ->success()
                        ->body("Total akun baru: " . count($akunBaru))
                        ->send();

                    // Simpan ke session untuk download
                    session()->flash('csv_download_path', 'storage/' . $filename);
                })
                ->after(function () {
                    if (session()->has('csv_download_path')) {
                        Notification::make()
                            ->title('Download Akun')
                            ->body('<a href="' . asset(session('csv_download_path')) . '" target="_blank" class="underline text-blue-600">Klik di sini untuk unduh akun</a>')
                            ->success()
                            ->send();
                    }
                }),

            Actions\Action::make('Impor Excel')
                ->label('Impor Excel')
                ->modalHeading('Impor Data Sekolah')
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
                        Excel::import(new SekolahImport, $path);
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
