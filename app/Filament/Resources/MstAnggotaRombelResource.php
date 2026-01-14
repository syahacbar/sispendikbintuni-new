<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstAnggotaRombelResource\Pages;
use App\Filament\Resources\MstAnggotaRombelResource\RelationManagers;
use App\Models\MstAnggotaRombel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
        $user = auth()->user();

        if ($user?->hasRole('admin_sekolah')) {
            return null; // TANPA GROUP
        }

        return 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data Anggota Rombel';
    protected static ?string $pluralLabel = 'Anggota Rombel';
    protected static ?string $slug = 'anggota-rombel';

    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->hasRole('admin_sekolah') ? 70 : 70;
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
                            fn($query) => $query
                                ->where('status_aktif', true)
                                ->when(
                                    auth()->user()?->sekolah_id,
                                    fn($q, $sekolahId) => $q->where('sekolah_id', $sekolahId)
                                )
                        )
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('peserta_didik_id')
                        ->label('Peserta Didik')
                        ->relationship(
                            'pesertaDidik',
                            'nama',
                            fn($query) => $query
                                ->when(
                                    auth()->user()?->sekolah_id,
                                    fn($q, $sekolahId) => $q->where('sekolah_id', $sekolahId)
                                )
                        )
                        ->searchable()
                        ->preload()
                        ->required(),

                    DatePicker::make('tanggal_masuk')
                        ->label('Tanggal Masuk')
                        ->required()
                        ->native(false)
                        ->maxDate(now()),

                    DatePicker::make('tanggal_keluar')
                        ->label('Tanggal Keluar')
                        // ->required()
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
        return $table
            ->columns([
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
                    // ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
                ])
            ->filters([
                    //
                ])
            ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMstAnggotaRombels::route('/'),
            // 'create' => Pages\CreateMstAnggotaRombel::route('/create'),
            // 'edit' => Pages\EditMstAnggotaRombel::route('/{record}/edit'),
        ];
    }
}
