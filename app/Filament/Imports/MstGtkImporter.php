<?php

namespace App\Filament\Imports;

use App\Models\MstGtk;
use App\Models\MstSekolah;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class MstGtkImporter extends Importer
{
    protected static ?string $model = MstGtk::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')->rules(['required']),
            ImportColumn::make('nik'),
            ImportColumn::make('nip'),
            ImportColumn::make('nuptk'),
            ImportColumn::make('tempat_lahir')->rules(['required']),
            ImportColumn::make('tgl_lahir')->rules(['required', 'date']),
            ImportColumn::make('jenis_kelamin')->rules(['required', 'in:L,P']),
            ImportColumn::make('status_kepegawaian')->rules(['required']),
            ImportColumn::make('jenis_gtk')->rules(['required']),
            ImportColumn::make('pend_terakhir')->rules(['required']),
            ImportColumn::make('status_keaktifan'),
            // ->fillRecordUsing(fn($record, $state) => $record->status_keaktifan = $state ?: 'Aktif'),
        ];
    }

    /**
     * Override untuk mendukung UUID
     */
    public function resolveRecord(): ?\Illuminate\Database\Eloquent\Model
    {
        // Return new instance to force creation
        return new static::$model();
    }

    protected function beforeSave(): void
    {
        /** @var \App\Models\MstGtk $record */
        $record = $this->record;

        // ---------------------------------------------------------
        // LOGIC FINAL: Gunakan User dari Model Import (Persistent di Queue)
        // ---------------------------------------------------------
        $tempatTugas = $this->options['tempat_tugas'] ?? null;

        if (!$tempatTugas) {
            // Ambil user yang melakukan import (aman untuk queue)
            $importUser = $this->import?->user;

            Log::info('DEBUG IMPORT GTK (beforeSave):', [
                'import_id' => $this->import?->id,
                'has_import_user' => (bool) $importUser,
                'user_id' => $importUser?->id,
                'auth_id' => auth()->id(),
            ]);

            $user = $importUser ?? auth()->user();

            if ($user && $user->hasRole('admin_sekolah')) {
                // Query manual untuk memastikan dapat data terbaru
                $sekolah = MstSekolah::where('users_id', $user->id)->first();
                Log::info('DEBUG SEKOLAH:', ['tempat_tugas' => $sekolah?->npsn]);

                if ($sekolah) {
                    $tempatTugas = $sekolah->npsn;
                }
            }
        }

        if ($tempatTugas) {
            $record->tempat_tugas = $tempatTugas;
        }

        if (!$record->status_keaktifan) {
            $record->status_keaktifan = 'Aktif';
        }
    }

    public static function getCompletedNotificationBody($import): string
    {
        return "Import GTK selesai: {$import->successful_rows} data berhasil diimpor.";
    }
}
