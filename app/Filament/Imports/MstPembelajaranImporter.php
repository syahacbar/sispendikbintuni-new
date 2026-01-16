<?php

namespace App\Filament\Imports;

use App\Models\MstPembelajaran;
use App\Models\MstRombel;
use App\Models\RefMapel;
use App\Models\MstGtk;
use App\Models\RefSemester;
use App\Models\MstSekolah;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MstPembelajaranImporter extends Importer
{
    protected static ?string $model = MstPembelajaran::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama_rombel')
                ->label('Nama Rombel')
                ->requiredMapping()
                ->rules(['required', 'string']),

            ImportColumn::make('nama_mapel')
                ->label('Nama Mata Pelajaran')
                ->requiredMapping()
                ->rules(['required', 'string']),

            ImportColumn::make('nama_gtk')
                ->label('Nama GTK')
                ->requiredMapping()
                ->rules(['required', 'string']),

            ImportColumn::make('nama_semester')
                ->label('Nama Semester')
                ->requiredMapping()
                ->rules(['required', 'string']),

            ImportColumn::make('jam_mengajar_per_minggu')
                ->numeric()
                ->rules(['nullable', 'integer']),

            ImportColumn::make('jenis_pembelajaran')
                ->rules(['nullable', 'string', 'max:50']),

            ImportColumn::make('tgl_mulai')
                ->rules(['nullable', 'string']),

            ImportColumn::make('tgl_selesai')
                ->rules(['nullable', 'string']),

            ImportColumn::make('status_aktif')
                ->boolean()
                ->rules(['nullable', 'boolean']),

            ImportColumn::make('keterangan')
                ->rules(['nullable', 'string']),
        ];
    }

    public function resolveRecord(): ?Model
    {
        // Untuk import Pembelajaran, kita buat record baru atau update jika kombinasi Rombel + Mapel + GTK + Semester sama (opsional)
        // Namun untuk sementara kita selalu buat baru (sesuai contoh GtkImporter)
        return new static::$model();
    }

    protected function beforeSave(): void
    {
        /** @var \App\Models\MstPembelajaran $record */
        $record = $this->record;

        // 1. Resolve UUID for the record itself
        if (!$record->id) {
            $record->id = (string) Str::uuid();
        }

        $user = $this->import?->user;
        $sekolah = null;

        if ($user && $user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::query()->where('users_id', $user->id)->first();

            if (!$sekolah) {
                throw ValidationException::withMessages([
                    'import' => "Akun admin Anda belum terhubung dengan data sekolah mana pun. Silakan hubungi Super Admin.",
                ]);
            }
        }

        Log::info('Importing Pembelajaran Row', [
            'import_id' => $this->import?->id,
            'user_id' => $user?->id,
            'sekolah_npsn' => $sekolah?->npsn,
            'data' => $this->data
        ]);

        // 1.5 Handle Dates (Manually due to dd/mm/yyyy format in CSV)
        foreach (['tgl_mulai', 'tgl_selesai'] as $dateField) {
            $dateValue = trim($this->data[$dateField] ?? '');
            if ($dateValue) {
                try {
                    if (str_contains($dateValue, '/')) {
                        $record->{$dateField} = \Illuminate\Support\Carbon::createFromFormat('d/m/Y', $dateValue)->format('Y-m-d');
                    } else {
                        $record->{$dateField} = \Illuminate\Support\Carbon::parse($dateValue)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to parse date: {$dateValue} for field {$dateField}");
                }
            }
        }

        // 2. Resolve Rombel (ID atau Nama)
        $rombelInput = trim($this->data['nama_rombel'] ?? '');
        if ($rombelInput) {
            $query = MstRombel::query();

            if (Str::isUuid($rombelInput)) {
                $query->where('id', $rombelInput);
            } else {
                $query->where('nama', 'ILIKE', $rombelInput);
            }

            if ($sekolah) {
                $query->where('sekolah_id', $sekolah->id);
            }

            $rombel = $query->first();
            if ($rombel) {
                $record->rombongan_belajar_id = $rombel->id;
            }
        }

        if (!$record->rombongan_belajar_id) {
            $msg = "Rombongan Belajar '{$rombelInput}' tidak ditemukan.";
            if ($sekolah)
                $msg .= " Pastikan nama sesuai dengan menu Rombongan Belajar di sekolah Anda (NPSN: {$sekolah->npsn}).";
            throw ValidationException::withMessages(['nama_rombel' => $msg]);
        }

        // 3. Resolve Mapel (ID, Kode, atau Nama)
        $mapelInput = trim($this->data['nama_mapel'] ?? '');
        if ($mapelInput) {
            $rombel = MstRombel::find($record->rombongan_belajar_id);
            $tingkat = $rombel?->tingkat;

            $findMapel = function ($input, $lvl = null) {
                $q = RefMapel::query();
                if (Str::isUuid($input)) {
                    $q->where('id', $input);
                } else {
                    $q->where(function ($sub) use ($input) {
                        $sub->where('nama', 'ILIKE', $input)
                            ->orWhere('kode', 'ILIKE', $input);

                        // Smart fallback for religion
                        if (str_contains(strtolower($input), 'pendidikan agama')) {
                            $sub->orWhere('nama', 'ILIKE', 'Pendidikan Agama');
                        }
                    });
                }
                if ($lvl)
                    $q->where('tingkat', (string) $lvl);
                return $q->first();
            };

            $mapel = $findMapel($mapelInput, $tingkat);
            if (!$mapel)
                $mapel = $findMapel($mapelInput); // Fallback without tingkat

            if ($mapel) {
                $record->mata_pelajaran_id = $mapel->id;
            }
        }

        if (!$record->mata_pelajaran_id) {
            throw ValidationException::withMessages([
                'nama_mapel' => "Mata Pelajaran '{$mapelInput}' tidak ditemukan. Anda bisa menggunakan Nama (contoh: Pendidikan Agama) atau Kode Mapel.",
            ]);
        }

        // 4. Resolve GTK (ID, Nama, NUPTK, atau NIP)
        $gtkInput = trim($this->data['nama_gtk'] ?? '');
        if ($gtkInput) {
            $query = MstGtk::query();

            if (Str::isUuid($gtkInput)) {
                $query->where('id', $gtkInput);
            } else {
                $query->where(function ($q) use ($gtkInput) {
                    $q->where('nama', 'ILIKE', $gtkInput)
                        ->orWhere('nuptk', $gtkInput)
                        ->orWhere('nip', $gtkInput);
                });
            }

            if ($sekolah) {
                $query->where('tempat_tugas', $sekolah->npsn);
            }

            $gtk = $query->first();
            if ($gtk) {
                $record->gtk_id = $gtk->id;
            }
        }

        if (!$record->gtk_id) {
            $msg = "GTK '{$gtkInput}' tidak ditemukan.";
            if ($sekolah)
                $msg .= " Pastikan nama sesuai dengan profil GTK di sekolah Anda (NPSN: {$sekolah->npsn}).";
            throw ValidationException::withMessages(['nama_gtk' => $msg]);
        }

        // 5. Resolve Semester (ID atau Nama)
        $semesterInput = trim($this->data['nama_semester'] ?? '');
        if ($semesterInput) {
            $query = RefSemester::query();
            if (Str::isUuid($semesterInput)) {
                $query->where('id', $semesterInput);
            } else {
                $query->where('nama_semester', 'ILIKE', $semesterInput);
            }
            $semester = $query->first();
            if ($semester) {
                $record->semester_id = $semester->id;
            }
        }

        if (!$record->semester_id) {
            throw ValidationException::withMessages([
                'nama_semester' => "Semester '{$semesterInput}' tidak ditemukan. Contoh: Semester Genap 2023/2024",
            ]);
        }

        // 6. Default values & Cleaning virtual attributes
        if ($record->status_aktif === null || $record->status_aktif === '') {
            $record->status_aktif = true;
        }

        // Handle string 'aktif' from CSV
        if (is_string($record->status_aktif) && strtolower($record->status_aktif) === 'aktif') {
            $record->status_aktif = true;
        }

        // IMPORTANT: Clean virtual attributes so they are not sent to the database
        unset($record->nama_rombel);
        unset($record->nama_mapel);
        unset($record->nama_gtk);
        unset($record->nama_semester);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data pembelajaran telah selesai dan ' . number_format($import->successful_rows) . ' ' . str('baris')->plural($import->successful_rows) . ' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diimpor.';
        }

        return $body;
    }
}
