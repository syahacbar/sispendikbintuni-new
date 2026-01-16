<?php

namespace App\Filament\Imports;

use App\Models\MstPesertaDidik;
use App\Models\MstAnggotaRombel;
use App\Models\MstRombel;
use App\Models\MstSekolah;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class MstPesertaDidikImporter extends Importer
{
    protected static ?string $model = MstPesertaDidik::class;

    public static function getLabel(): string
    {
        return 'Peserta Didik';
    }

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('nipd')
                ->rules(['max:6']),
            ImportColumn::make('nisn')
                ->rules(['max:10']),
            ImportColumn::make('nik')
                ->rules(['max:20']),
            ImportColumn::make('tempat_lahir')
                ->rules(['max:100']),
            ImportColumn::make('tgl_lahir')
                ->rules(['date']),
            ImportColumn::make('jenis_kelamin'),
            // ->rules(['in:L,P']), // Validation relaxed to allow mapping in beforeSave
            ImportColumn::make('agama'),
            // ->rules(['in:Islam,Kristen,Hindu,Buddha,Konghucu,Katholik']), // Validation relaxed
            ImportColumn::make('alamat'),
            ImportColumn::make('kode_wilayah'),
            ImportColumn::make('kode_pos')
                ->rules(['max:10']),
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Select::make('rombel_id')
                ->label('Masukkan ke Rombel (Kelas)')
                ->options(function () {
                    $user = auth()->user();
                    if ($user && $user->hasRole('admin_sekolah')) {
                        $sekolah = MstSekolah::where('users_id', $user->id)->first();
                        if ($sekolah) {
                            return MstRombel::where('sekolah_id', $sekolah->id)
                                ->orderBy('nama')
                                ->pluck('nama', 'id');
                        }
                        return [];
                    }
                    return MstRombel::orderBy('nama')->pluck('nama', 'id');
                })
                ->required()
                ->searchable()
                ->helperText('Pilih rombel untuk siswa yang diimpor. Semua siswa di file CSV akan dimasukkan ke rombel ini.'),
        ];
    }

    public function resolveRecord(): ?Model
    {
        // Return new instance to force creation
        return new static::$model();
    }

    protected function beforeSave(): void
    {
        /** @var \App\Models\MstPesertaDidik $record */
        $record = $this->record;

        // 1. Handle UUID if missing
        if (!$record->id) {
            $record->id = (string) Str::uuid();
        }

        // 2. Mapping Jenis Kelamin
        $jkMap = [
            'laki-laki' => 'L',
            'perempuan' => 'P',
            'l' => 'L',
            'p' => 'P',
        ];
        if ($record->jenis_kelamin) {
            $jkLower = strtolower($record->jenis_kelamin);
            if (isset($jkMap[$jkLower])) {
                $record->jenis_kelamin = $jkMap[$jkLower];
            }
        }

        // 3. Mapping Agama (Optional normalization)
        if ($record->agama) {
            $record->agama = ucwords(strtolower($record->agama));
        }
    }


    /**
     * Override saveRecord to handle relationships
     */
    public function saveRecord(): void
    {
        $this->record->save();

        // LINK TO ROMBEL
        $rombelId = $this->options['rombel_id'] ?? null;

        if ($rombelId && $this->record->id) {
            // Create Anggota Rombel
            // Check duplication handled by DB or Model constraints? 
            // We'll just try to create or ignore if exists.

            $exists = MstAnggotaRombel::where('peserta_didik_id', $this->record->id)
                ->where('rombel_id', $rombelId)
                ->exists();

            if (!$exists) {
                MstAnggotaRombel::create([
                    'rombel_id' => $rombelId,
                    'peserta_didik_id' => $this->record->id,
                    'status_keaktifan' => true,
                    'tanggal_masuk' => now(), // Default today
                ]);
            }
        }
    }

    public static function getCompletedNotificationBody($import): string
    {
        return "Import Peserta Didik selesai: {$import->successful_rows} data berhasil diimpor.";
    }
}
