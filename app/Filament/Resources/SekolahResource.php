<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Sekolah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\SekolahResource\Pages;
use Illuminate\Support\Str;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Sekolah';
    protected static ?string $pluralModelLabel = 'Sekolah';
    protected static ?string $navigationGroup = 'Data Manajemen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('npsn')
                    ->required()
                    ->maxLength(10),

                TextInput::make('nama')
                    ->required()
                    ->maxLength(100),

                TextInput::make('jenjang')
                    ->required()
                    ->maxLength(50),

                TextInput::make('alamat_jalan')
                    ->label('Alamat')
                    ->nullable(),

                TextInput::make('desa_kelurahan')
                    ->label('Desa/Kelurahan')
                    ->nullable(),

                TextInput::make('kode_pos')
                    ->nullable()
                    ->maxLength(10),

                TextInput::make('kecamatan')
                    ->nullable()
                    ->maxLength(100),

                TextInput::make('kabupaten')
                    ->nullable()
                    ->maxLength(100),

                TextInput::make('provinsi')
                    ->nullable()
                    ->maxLength(100),

                TextInput::make('kode_wilayah')
                    ->nullable()
                    ->maxLength(10),

                Select::make('status_sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                    ])
                    ->required(),

                TextInput::make('akreditasi')
                    ->nullable()
                    ->maxLength(1),

                TextInput::make('email')
                    ->email()
                    ->nullable()
                    ->maxLength(100),

                TextInput::make('telepon')
                    ->nullable()
                    ->maxLength(20),

                TextInput::make('sk_pendirian')
                    ->nullable()
                    ->maxLength(100),

                DatePicker::make('tanggal_sk_pendirian')
                    ->nullable(),

            ])->columns(3);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Sekolah')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenjang')
                    ->label('Jenjang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('alamat_jalan')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('desa_kelurahan')
                    ->label('Desa/Kelurahan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kode_pos')
                    ->label('Kode Pos'),

                Tables\Columns\TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kabupaten')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kabupaten')
                    ->searchable(),

                Tables\Columns\TextColumn::make('provinsi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Provinsi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kode Wilayah'),

                Tables\Columns\TextColumn::make('status_sekolah')
                    ->label('Status Sekolah')
                    ->badge()
                    ->colors([
                        'primary' => 'Negeri',
                        'warning' => 'Swasta',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('akreditasi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Akreditasi'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->limit(30),

                Tables\Columns\TextColumn::make('telepon')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Telepon'),

                Tables\Columns\TextColumn::make('sk_pendirian')
                    ->label('SK Pendirian')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(25),

                Tables\Columns\TextColumn::make('tanggal_sk_pendirian')
                    ->label('Tanggal SK')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}
