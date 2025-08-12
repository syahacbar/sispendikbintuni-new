<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Models\MstRombel;
use App\Models\MstSekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\MstGtkResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\RefSemester;
use App\Models\RefKurikulum;

class CreateMstGtk extends CreateRecord
{
    protected static string $resource = MstGtkResource::class;
    protected static ?string $breadcrumb = 'Tambah Data GTK';
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getHeading(): string
    {
        return 'Tambah Data GTK';
    }

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();
            $semester = RefSemester::where('is_aktif', true)->first();
            $kurikulum = RefKurikulum::where('status', true)->first();

            MstRombel::create([
                'sekolah_id' => $sekolah->id,
                'wali_kelas_ptk_id' => $this->record->id,
                'nama' => 'Kelas 9B',
                'semester_id' => $semester?->id,
                'kurikulum_id' => $kurikulum?->id,
            ]);
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $sekolah = DB::table('mst_sekolah')
            ->where('users_id', Auth::id())
            ->first();

        if ($sekolah) {
            $data['sekolah_id'] = $sekolah->id;
        }

        // Pastikan status keaktifan default Aktif
        $data['status_keaktifan'] = 'Aktif';

        return $data;
    }
}
