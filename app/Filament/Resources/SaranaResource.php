<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sarana;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SaranaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaranaResource\RelationManagers;

class SaranaResource extends Resource
{
    protected static ?string $model = Sarana::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationLabel = 'Sarana';
    protected static ?string $pluralModelLabel = 'Sarana';
    protected static ?string $navigationGroup = 'Data Pendidikan';


    public static function getNavigationSort(): ?int
    {
        return 8;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sekolah_id')
                    ->label('Sekolah')
                    ->relationship('sekolah', 'nama')
                    ->searchable()
                    ->default(fn() => Filament::auth()->user()->sekolah_id)
                    ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                    ->dehydrated(fn() => true)
                    ->required(),
                TextInput::make('r_kelas')
                    ->numeric()
                    ->label('Ruang Kelas')
                    ->default(0),
                TextInput::make('r_perpus')
                    ->numeric()
                    ->label('Perpustakaan')
                    ->default(0),
                TextInput::make('r_lab')
                    ->numeric()
                    ->label('Ruang Lab')
                    ->default(0),
                TextInput::make('r_praktik')
                    ->numeric()
                    ->label('Ruang Praktik')
                    ->default(0),
                TextInput::make('r_pimpinan')
                    ->numeric()
                    ->label('Ruang Pimpinan')
                    ->default(0),
                TextInput::make('r_guru')
                    ->numeric()
                    ->label('Ruang Guru')
                    ->default(0),
                TextInput::make('r_ibadah')
                    ->numeric()
                    ->label('Ruang Ibadah')
                    ->default(0),
                TextInput::make('r_uks')
                    ->numeric()
                    ->label('Ruang UKS')
                    ->default(0),
                TextInput::make('r_toilet')
                    ->numeric()
                    ->label('Toilet')
                    ->default(0),
                TextInput::make('r_gudang')
                    ->numeric()
                    ->label('Gudang')
                    ->default(0),
                TextInput::make('r_sirkulasi')
                    ->numeric()
                    ->label('Sirkulasi')
                    ->default(0),
                TextInput::make('tempat_bermain')
                    ->numeric()
                    ->label('Tempat Bermain')
                    ->default(0),
                TextInput::make('r_tu')
                    ->numeric()
                    ->label('Ruang TU')
                    ->default(0),
                TextInput::make('r_konseling')
                    ->numeric()
                    ->label('Ruang BK')
                    ->default(0),
                TextInput::make('r_osis')
                    ->numeric()
                    ->label('Ruang OSIS')
                    ->default(0),
                TextInput::make('r_bangunan')
                    ->numeric()
                    ->label('Bangunan')
                    ->default(0),
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => !auth()->user()->hasRole('admin_sekolah')),
                TextColumn::make('r_kelas')
                    ->label('Ruang Kelas')
                    ->sortable(),
                TextColumn::make('r_perpus')
                    ->label('Perpustakaan')
                    ->sortable(),
                TextColumn::make('r_lab')
                    ->label('Ruang Lab')
                    ->sortable(),
                TextColumn::make('r_praktik')
                    ->label('Ruang Praktik')
                    ->sortable(),
                TextColumn::make('r_pimpinan')
                    ->label('Ruang Pimpinan')
                    ->sortable(),
                TextColumn::make('r_guru')
                    ->label('Ruang Guru')
                    ->sortable(),
                TextColumn::make('r_ibadah')
                    ->label('Ruang Ibadah')
                    ->sortable(),
                TextColumn::make('r_uks')
                    ->label('Ruang UKS')
                    ->sortable(),
                TextColumn::make('r_toilet')
                    ->label('Toilet')
                    ->sortable(),
                TextColumn::make('r_gudang')
                    ->label('Gudang')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('r_sirkulasi')
                    ->label('Sirkulasi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('tempat_bermain')
                    ->label('Tempat Bermain')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('r_tu')
                    ->label('Ruang TU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('r_konseling')
                    ->label('Ruang BK')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('r_osis')
                    ->label('Ruang OSIS')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('r_bangunan')
                    ->label('Bangunan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSaranas::route('/'),
            'create' => Pages\CreateSarana::route('/create'),
            'edit' => Pages\EditSarana::route('/{record}/edit'),
        ];
    }
}
