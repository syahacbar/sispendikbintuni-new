<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Wilayah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\WilayahResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class WilayahResource extends Resource
{
    protected static ?string $model = Wilayah::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';
    protected static ?string $navigationLabel = 'Wilayah';
    protected static ?string $modelLabel = 'Wilayah';
    protected static ?string $pluralModelLabel = 'Wilayah';
    protected static ?string $navigationGroup = 'Data Referensi';
    protected static ?string $slug = 'data-wilayah';


    public static function getNavigationSort(): ?int
    {
        return 1;
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            // Pilih Provinsi
            Select::make('provinsi')
                ->label('Provinsi')
                ->options(
                    Wilayah::whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 2")
                        ->pluck('nama', 'kode')
                )
                ->reactive()
                ->required(),

            // Pilih Kabupaten
            Select::make('kabupaten')
                ->label('Kabupaten')
                ->options(
                    fn(callable $get) =>
                    $get('provinsi')
                        ? Wilayah::where('kode', 'like', $get('provinsi') . '.%')
                        ->whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 4")
                        ->pluck('nama', 'kode')
                        : []
                )
                ->reactive()
                ->required()
                ->disabled(fn(callable $get) => !$get('provinsi')),

            // Pilih Kecamatan
            Select::make('kecamatan')
                ->label('Kecamatan')
                ->options(
                    fn(callable $get) =>
                    $get('kabupaten')
                        ? Wilayah::where('kode', 'like', $get('kabupaten') . '.%')
                        ->whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 6")
                        ->pluck('nama', 'kode')
                        : []
                )
                ->reactive()
                ->required()
                ->afterStateUpdated(function (callable $get, callable $set) {
                    $kecKode = $get('kecamatan');

                    if ($kecKode) {
                        $jumlahKelurahan = Wilayah::where('kode', 'like', $kecKode . '.%')
                            ->whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 10")
                            ->count();

                        $newKode = $kecKode . '.' . str_pad($jumlahKelurahan + 1, 4, '0', STR_PAD_LEFT);
                        $set('kode', $newKode);
                    } else {
                        $set('kode', null);
                    }
                })
                ->disabled(fn(callable $get) => !$get('kabupaten')),

            // Input Nama Kelurahan Baru
            TextInput::make('nama')
                ->label('Nama Kelurahan')
                ->required(),
        ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Wilayah')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListWilayahs::route('/'),
            'create' => Pages\CreateWilayah::route('/create'),
            'edit' => Pages\EditWilayah::route('/{record}/edit'),
        ];
    }
}
