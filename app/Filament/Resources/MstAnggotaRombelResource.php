<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstAnggotaRombelResource\Pages;
use App\Models\MstAnggotaRombel;
use App\Models\MstSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class MstAnggotaRombelResource extends Resource
{
    protected static ?string $model = MstAnggotaRombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationGroup(): ?string
    {
        return auth()->user()?->hasRole('admin_sekolah') ? null : 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data Anggota Rombel';
    protected static ?string $pluralLabel = 'Anggota Rombel';
    protected static ?string $slug = 'anggota-rombel';

    public static function getNavigationSort(): ?int
    {
        return 70;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Select::make('rombel_id')
                        ->label('Rombel')
                        ->relationship(
                            'rombel',
                            'nama',
                            function ($query) {
                                $user = auth()->user();

                                if ($user->hasRole('admin_sekolah')) {
                                    $sekolah = $user->sekolah;

                                    if (!$sekolah) {
                                        $query->whereRaw('1 = 0');
                                        return;
                                    }

                                    $query->where('sekolah_id', $sekolah->id);
                                }

                                $query->where('status_aktif', true);
                            }
                        )
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('peserta_didik_id')
                        ->label('Peserta Didik')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->relationship(
                            name: 'pesertaDidik',
                            titleAttribute: 'nama',
                            modifyQueryUsing: function (Builder $query) {
                                // Hanya peserta didik yang BELUM punya rombel
                                $query->whereDoesntHave('anggotaRombel');

                                // Jika admin sekolah → batasi sekolah
                                if (auth()->user()->hasRole('admin_sekolah')) {
                                    $query->whereHas('rombels', function ($q) {
                                        $q->where('sekolah_id', auth()->user()->sekolah_id);
                                    });
                                }
                            }
                        ),


                    DatePicker::make('tanggal_masuk')
                        ->label('Tanggal Masuk')
                        ->required()
                        ->native(false)
                        ->maxDate(now()),

                    DatePicker::make('tanggal_keluar')
                        ->label('Tanggal Keluar')
                        ->native(false)
                        ->maxDate(now()),

                    Toggle::make('status_keaktifan')
                        ->label('Status Aktif')
                        ->default(true)
                        ->required(),

                    Textarea::make('keterangan')
                        ->columnSpanFull(),
                ]);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();

        $columns = [];

        // 🔹 Kolom Sekolah (HANYA jika bukan admin_sekolah)
        if (!$user->hasRole('admin_sekolah')) {
            $columns[] = TextColumn::make('rombel.sekolah.nama')
                ->label('Sekolah')
                ->sortable()
                ->searchable(query: function (Builder $query, string $search) {
                    $query->whereHas('rombel.sekolah', function ($q) use ($search) {
                        $q->where('nama', 'ILIKE', "%{$search}%");
                    });
                });
        }

        // 🔹 Kolom lain (selalu tampil)
        $columns = array_merge($columns, [

            TextColumn::make('rombel.nama')
                ->label('Rombel')
                ->searchable()
                ->sortable(),

            TextColumn::make('pesertaDidik.nama')
                ->label('Peserta Didik')
                ->searchable()
                ->sortable(),

            IconColumn::make('status_keaktifan')
                ->boolean()
                ->label('Aktif?'),

            TextColumn::make('tanggal_masuk')
                ->date()
                ->sortable(),

            TextColumn::make('tanggal_keluar')
                ->date()
                ->sortable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable(),
        ]);

        return $table
            ->columns($columns)
            ->filters([])
            ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ->bulkActions([]);
    }


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // 🔓 Super admin & admin dinas lihat semua
        if ($user->hasRole(['super_admin', 'admin_dinas'])) {
            return $query;
        }

        // 🔒 Admin sekolah → filter via rombel → sekolah
        if ($user->hasRole('admin_sekolah')) {
            $sekolah = $user->sekolah;

            if (!$sekolah) {
                // admin sekolah tapi belum di-assign ke sekolah
                return $query->whereRaw('1 = 0');
            }

            return $query->whereHas('rombel', function ($q) use ($sekolah) {
                $q->where('sekolah_id', $sekolah->id);
            });
        }

        // role lain tidak boleh lihat data
        return $query->whereRaw('1 = 0');
    }



    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMstAnggotaRombels::route('/'),
            // 'create' => Pages\CreateMstAnggotaRombel::route('/create'),
        ];
    }
}
