<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstRombelResource\Pages;
use App\Filament\Resources\MstRombelResource\RelationManagers;
use App\Models\MstRombel;
use App\Models\MstSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class MstRombelResource extends Resource
{
    protected static ?string $model = MstRombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();

        if ($user?->hasRole('admin_sekolah')) {
            return null; // TANPA GROUP
        }

        return 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data Rombel';
    protected static ?string $pluralLabel = 'Rombel';
    protected static ?string $slug = 'data-rombongan-belajar';

    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->hasRole('admin_sekolah') ? 30 : 30;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Super admin → semua data
        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        // Admin sekolah → hanya rombel sekolahnya
        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();

            if (!$sekolah) {
                return parent::getEloquentQuery()->whereRaw('1=0');
            }

            return parent::getEloquentQuery()
                ->where('sekolah_id', $sekolah->id);
        }

        return parent::getEloquentQuery()->whereRaw('1=0');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kurikulum_id')
                    ->label('Kurikulum')
                    ->relationship('kurikulum', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('nama')
                    ->label('Nama Rombel')
                    ->maxLength(100)
                    ->required(),

                TextInput::make('tingkat')
                    ->numeric()
                    ->required(),

                TextInput::make('jurusan')
                    ->maxLength(50),

                TextInput::make('kapasitas')
                    ->numeric(),

                Select::make('wali_kelas_ptk_id')
                    ->label('Wali Kelas')
                    ->relationship(
                        'waliKelas',
                        'nama',
                        fn($query) => $query
                            ->where('status_keaktifan', 'Aktif')
                            ->where(
                                'tempat_tugas',
                                auth()->user()->sekolah->npsn
                            )
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('semester_id')
                    ->label('Semester')
                    ->relationship(
                        'semester',
                        'nama_semester',
                        fn($query) => $query->where('is_aktif', true)
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn($record) => "{$record->nama_semester} {$record->tahun_ajaran}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),



                Textarea::make('keterangan')
                    ->columnSpanFull(),
                Toggle::make('status_aktif')
                    ->label('Status Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->searchable()
                    ->sortable()
                    ->visible(fn() => !auth()->user()?->hasRole('admin_sekolah')),

                Tables\Columns\TextColumn::make('kurikulum.nama')
                    ->label('Kurikulum')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Rombel')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tingkat')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kapasitas')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('waliKelas.nama')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('semester.nama_semester')
                    ->label('Semester')
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->semester
                        ? "{$record->semester->nama_semester} {$record->semester->tahun_ajaran}"
                        : '-'
                    )
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('status_aktif')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->openRecordUrlInNewTab(false)
            ->recordUrl(null)
            ->recordAction(null)

            ->filters([
                //
            ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            //     Tables\Actions\DeleteAction::make(),
            // ])

            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
                // ...
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMstRombels::route('/'),
            'create' => Pages\CreateMstRombel::route('/create'),
            'edit' => Pages\EditMstRombel::route('/{record}/edit'),
        ];
    }

}
