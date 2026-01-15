<?php

namespace App\Filament\Imports;

use App\Models\MstSarprasSekolah;
use App\Models\MstSekolah;
use App\Models\RefSarpras;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MstSarprasSekolahImporter extends Importer
{
    protected static ?string $model = MstSarprasSekolah::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->label('Nama Sarpras')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('jenis_sarpras')
                ->label('Jenis Sarpras (Nama Referensi)')
                ->requiredMapping()
                ->rules(['required']), // We will validate lookup in beforeSave/resolve? Or just try to find.

            ImportColumn::make('jumlah_ideal')
                ->numeric()
                ->rules(['integer'])
                ->requiredMapping(),

            ImportColumn::make('kondisi_baik')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kondisi_rusak_ringan')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kondisi_rusak_sedang')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kondisi_rusak_berat')
                ->numeric()
                ->rules(['integer']),

            ImportColumn::make('keterangan'),
        ];
    }

    public function resolveRecord(): ?Model
    {
        return new static::$model();
    }

    protected function beforeSave(): void
    {
        /** @var \App\Models\MstSarprasSekolah $record */
        $record = $this->record;

        // 1. UUID
        if (!$record->id) {
            $record->id = (string) Str::uuid();
        }

        // 2. Lookup Jenis Sarpras (RefSarpras)
        // Expecting the CSV column 'jenis_sarpras' to be the name.
        if (isset($record->jenis_sarpras) || $record->getAttribute('jenis_sarpras')) {
            $refName = $record->jenis_sarpras;

            // Try exact match first, then ilike?
            $ref = RefSarpras::where('nama', 'ILIKE', $refName)->first();

            if ($ref) {
                $record->sarpras_id = $ref->id;
            }

            // CRITICAL: Remove from attributes to avoid SQL error
            unset($record->jenis_sarpras);
        }

        // 3. Calculate Jumlah Saat Ini
        $total = (int) ($record->kondisi_baik ?? 0) +
            (int) ($record->kondisi_rusak_ringan ?? 0) +
            (int) ($record->kondisi_rusak_sedang ?? 0) +
            (int) ($record->kondisi_rusak_berat ?? 0);

        $record->jumlah_saat_ini = $total;

        // 4. Sekolah Context
        $user = $this->import?->user;
        if (!$user) {
            $user = auth()->user();
        }

        if ($user && $user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();
            if ($sekolah) {
                $record->sekolah_id = $sekolah->id;
            }
        }
    }

    public static function getCompletedNotificationBody($import): string
    {
        return "Import Sarpras Sekolah selesai: {$import->successful_rows} data berhasil diimpor.";
    }
}
