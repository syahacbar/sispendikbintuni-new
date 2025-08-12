<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Filament\Resources\MstGtkResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;

class ListMstGtks extends ListRecords
{
    protected static string $resource = MstGtkResource::class;

    public function getHeading(): string
    {
        return 'Data GTK';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah GTK')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if (auth()->user()->hasRole('admin_sekolah')) {
            $userId = auth()->id();

            $query->where(function ($q) use ($userId) {
                // Hanya pakai relasi melalui mst_rombel dan mst_pembelajaran

                // GTK yang jadi wali kelas di rombel sekolah admin
                $q->whereIn('mst_gtk.id', function ($sub) use ($userId) {
                    $sub->select('wali_kelas_ptk_id')
                        ->from('mst_rombel')
                        ->whereIn('sekolah_id', function ($sq) use ($userId) {
                            $sq->select('id')
                                ->from('mst_sekolah')
                                ->where('users_id', $userId);
                        });
                })
                    // GTK yang mengajar di pembelajaran rombel sekolah admin
                    ->orWhereIn('mst_gtk.id', function ($sub) use ($userId) {
                        $sub->select('gtk_id')
                            ->from('mst_pembelajaran')
                            ->whereIn('rombongan_belajar_id', function ($sq) use ($userId) {
                                $sq->select('id')
                                    ->from('mst_rombel')
                                    ->whereIn('sekolah_id', function ($sq2) use ($userId) {
                                        $sq2->select('id')
                                            ->from('mst_sekolah')
                                            ->where('users_id', $userId);
                                    });
                            });
                    });
            });
        }

        return $query;
    }
}
