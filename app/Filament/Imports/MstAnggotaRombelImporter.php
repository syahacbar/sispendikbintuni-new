<?php

namespace App\Filament\Imports;

use App\Models\MstAnggotaRombel;
use App\Models\MstPesertaDidik;
use App\Models\MstRombel;
use App\Models\MstSekolah;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MstAnggotaRombelImporter extends Importer
{
    protected static ?string $model = MstAnggotaRombel::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama_peserta_didik')
                ->label('Nama Peserta Didik')
                ->requiredMapping()
                ->rules(['required']),

            ImportColumn::make('nama_rombel')
                ->label('Nama Rombel (Opsional jika pilih rombel di form)')
                ->rules(['nullable', 'string']),

            ImportColumn::make('status_keaktifan')
                ->boolean()
                ->rules(['boolean']),

            ImportColumn::make('tanggal_masuk')
                ->rules(['date']),

            ImportColumn::make('keterangan'),
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Select::make('rombel_id')
                ->label('Pilih Rombel (Target Default)')
                ->helperText('Jika kolom "Nama Rombel" di CSV kosong, siswa akan dimasukkan ke rombel ini.')
                ->options(function () {
                    $user = auth()->user();
                    if ($user->hasRole('admin_sekolah')) {
                        $sekolah = MstSekolah::where('users_id', $user->id)->first();
                        if ($sekolah) {
                            return MstRombel::where('sekolah_id', $sekolah->id)
                                ->where('status_aktif', true)
                                ->pluck('nama', 'id');
                        }
                        return [];
                    }
                    return MstRombel::where('status_aktif', true)->pluck('nama', 'id');
                })
                ->searchable()
                ->preload(),
        ];
    }

    public function resolveRecord(): ?Model
    {
        // 1. Resolve Student ID
        $siswaName = $this->data['nama_peserta_didik'] ?? null;
        $siswaId = null;
        if ($siswaName) {
            $siswa = MstPesertaDidik::where('nama', 'ILIKE', $siswaName)->first();
            $siswaId = $siswa?->id;
        }

        // 2. Resolve Rombel ID
        $rombelId = null;
        $rombelName = $this->data['nama_rombel'] ?? null;

        if ($rombelName) {
            $query = MstRombel::query()->where('nama', 'ILIKE', $rombelName);

            $user = auth()->user();
            if ($user && $user->hasRole('admin_sekolah')) {
                $sekolah = MstSekolah::where('users_id', $user->id)->first();
                if ($sekolah) {
                    $query->where('sekolah_id', $sekolah->id);
                }
            }
            $rombel = $query->first();
            $rombelId = $rombel?->id;
        }

        // Fallback to options if not in CSV or lookup failed (though if in CSV but failed, might be weird, but okay)
        if (!$rombelId && isset($this->options['rombel_id'])) {
            $rombelId = $this->options['rombel_id'];
        }

        // 3. Find Existing Assignment
        if ($siswaId && $rombelId) {
            return MstAnggotaRombel::where('peserta_didik_id', $siswaId)
                ->where('rombel_id', $rombelId)
                ->first() ?? new static::$model();
        }

        return new static::$model();
    }

    protected function beforeSave(): void
    {
        /** @var \App\Models\MstAnggotaRombel $record */
        $record = $this->record;

        // 1. UUID
        if (!$record->id) {
            $record->id = (string) Str::uuid();
        }

        // 2. Lookup Peserta Didik
        if (isset($record->nama_peserta_didik) || $record->getAttribute('nama_peserta_didik')) {
            $siswaName = $record->nama_peserta_didik;
            // Lookup by name (Case Insensitive)
            // TODO: Maybe constraint by School if possible? But Student doesn't have direct school_id.
            $siswa = MstPesertaDidik::where('nama', 'ILIKE', $siswaName)->first();

            if ($siswa) {
                $record->peserta_didik_id = $siswa->id;
            }
            unset($record->nama_peserta_didik);
        }

        // 3. Lookup Rombel
        // Priority: CSV "nama_rombel" > Option "rombel_id"
        $rombelId = null;

        if (isset($record->nama_rombel) || $record->getAttribute('nama_rombel')) {
            $rombelName = $record->nama_rombel;
            // Lookup Rombel
            // Ensure we only find rombels from the user's school if admin_sekolah
            $query = MstRombel::query()->where('nama', 'ILIKE', $rombelName);

            $user = $this->import?->user ?? auth()->user();
            if ($user && $user->hasRole('admin_sekolah')) {
                $sekolah = MstSekolah::where('users_id', $user->id)->first();
                if ($sekolah) {
                    $query->where('sekolah_id', $sekolah->id);
                }
            }

            $foundRombel = $query->first();
            if ($foundRombel) {
                $rombelId = $foundRombel->id;
            }
            unset($record->nama_rombel);
        }

        // If not found in CSV, check options
        if (!$rombelId && isset($this->options['rombel_id'])) {
            $rombelId = $this->options['rombel_id'];
        }

        if ($rombelId) {
            $record->rombel_id = $rombelId;
        }

        // 4. Defaults
        if (!$record->tanggal_masuk) {
            $record->tanggal_masuk = now();
        }
        if ($record->status_keaktifan === null) {
            $record->status_keaktifan = true;
        }
    }

    public static function getCompletedNotificationBody($import): string
    {
        return "Import Anggota Rombel selesai: {$import->successful_rows} siswa berhasil dimasukkan.";
    }
}
