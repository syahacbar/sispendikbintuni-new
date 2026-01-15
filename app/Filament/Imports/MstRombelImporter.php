<?php

namespace App\Filament\Imports;

use App\Models\MstRombel;
use App\Models\MstSekolah;
use App\Models\RefKurikulum;
use App\Models\RefSemester;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MstRombelImporter extends Importer
{
    protected static ?string $model = MstRombel::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->label('Nama Rombel')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('tingkat')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('jurusan')
                ->rules(['max:50']),
            ImportColumn::make('kapasitas')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Select::make('semester_id')
                ->label('Semester')
                ->options(fn() => RefSemester::where('is_aktif', true)
                    ->get()
                    ->mapWithKeys(fn($item) => [$item->id => "{$item->nama_semester} {$item->tahun_ajaran}"]))
                ->required()
                ->searchable(),
            Select::make('kurikulum_id')
                ->label('Kurikulum')
                ->options(fn() => RefKurikulum::pluck('nama', 'id'))
                ->required()
                ->searchable(),
        ];
    }

    public function resolveRecord(): ?Model
    {
        return new static::$model();
    }

    protected function beforeSave(): void
    {
        /** @var \App\Models\MstRombel $record */
        $record = $this->record;

        // 1. UUID
        if (!$record->id) {
            $record->id = (string) Str::uuid();
        }

        // 2. Options: Semester & Kurikulum
        if (isset($this->options['semester_id'])) {
            $record->semester_id = $this->options['semester_id'];
        }
        if (isset($this->options['kurikulum_id'])) {
            $record->kurikulum_id = $this->options['kurikulum_id'];
        }

        // 3. Sekolah Context
        // Try to get from user
        $user = $this->import?->user; // Safe access via relationship if loaded, or auth() if direct

        // If running in queue, auth() might not be set, so rely on $this->import->user
        if (!$user) {
            $user = auth()->user();
        }

        if ($user && $user->hasRole('admin_sekolah')) {
            // Fetch school via user relation
            $sekolah = MstSekolah::where('users_id', $user->id)->first();
            if ($sekolah) {
                $record->sekolah_id = $sekolah->id;
            }
        }

        // Default Active
        $record->status_aktif = true;
    }

    public static function getCompletedNotificationBody($import): string
    {
        return "Import Data Rombel selesai: {$import->successful_rows} data berhasil diimpor.";
    }
}
