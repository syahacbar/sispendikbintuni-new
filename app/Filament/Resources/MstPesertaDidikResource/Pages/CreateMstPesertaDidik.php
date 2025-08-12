<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use Filament\Actions;
use App\Models\MstRombel;
use App\Models\MstSekolah;
use App\Models\MstAnggotaRombel;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\MstPesertaDidikResource;

class CreateMstPesertaDidik extends CreateRecord
{
    protected static string $resource = MstPesertaDidikResource::class;
    protected static ?string $breadcrumb = 'Tambah Peserta Didik';
    protected static bool $canCreateAnother = false;
    public function getHeading(): string
    {
        return 'Tambah Data Peserta Didik';
    }

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();

            if ($sekolah) {
                $rombel = MstRombel::where('sekolah_id', $sekolah->id)->first();

                if ($rombel) {
                    MstAnggotaRombel::create([
                        'rombel_id' => $rombel->id,
                        'peserta_didik_id' => $this->record->id,
                    ]);
                }
            }
        }
    }
}
