<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use Filament\Actions;
use App\Models\MstRombel;
use App\Models\MstSekolah;
use App\Models\MstAnggotaRombel;
use Illuminate\Support\Facades\DB;
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function afterCreate(): void
    // {
    //     $user = auth()->user();

    //     if ($user->hasRole('admin_sekolah')) {
    //         $sekolah = MstSekolah::where('users_id', $user->id)->first();

    //         if (!$sekolah) {
    //             return;
    //         }

    //         $rombel = MstRombel::where('sekolah_id', $sekolah->id)
    //             ->latest()
    //             ->first();

    //         if ($rombel) {
    //             MstAnggotaRombel::create([
    //                 'rombel_id' => $rombel->id,
    //                 'peserta_didik_id' => $this->record->id,
    //             ]);
    //         }
    //     }
    // }


    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return DB::transaction(function () use ($data) {

            $user = auth()->user();

            // 1. Simpan peserta didik
            $peserta = static::getModel()::create($data);

            // 2. Jika admin sekolah → wajib assign ke sekolah
            if ($user->hasRole('admin_sekolah')) {

                $sekolah = MstSekolah::where('users_id', $user->id)->first();

                if (!$sekolah) {
                    throw new \Exception('Admin sekolah tidak terhubung ke sekolah.');
                }

                // 3. Ambil rombel AKTIF (bukan latest sembarang)
                $rombel = MstRombel::where('sekolah_id', $sekolah->id)
                    ->orderBy('created_at')
                    ->first();

                if (!$rombel) {
                    throw new \Exception('Sekolah belum memiliki rombel.');
                }

                // 4. Hubungkan peserta ke rombel
                MstAnggotaRombel::create([
                    'rombel_id' => $rombel->id,
                    'peserta_didik_id' => $peserta->id,
                ]);
            }

            return $peserta;
        });
    }


}
