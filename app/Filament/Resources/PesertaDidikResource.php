<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Wilayah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PesertaDidik;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

use App\Filament\Resources\PesertaDidikResource\Pages;

class PesertaDidikResource extends Resource
{
    protected static ?string $model = PesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Peserta Didik';
    protected static ?string $pluralModelLabel = 'Peserta Didik';
    protected static ?string $slug = 'data-peserta-didik';
    protected static ?string $navigationGroup = 'Data Pendidikan';



    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Identitas Peserta Didik')->schema([
                    Select::make('sekolah_id')
                        ->label('Sekolah')
                        ->relationship('sekolah', 'nama')
                        ->searchable()
                        ->preload()
                        ->default(fn() => Filament::auth()->user()->sekolah_id)
                        ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                        ->dehydrated()
                        ->required(),

                    TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('nisn')
                        ->label('NISN')
                        ->required()
                        ->maxLength(10),

                    TextInput::make('nik')
                        ->label('NIK')
                        ->required()
                        ->maxLength(20),

                    Radio::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->options([
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan',
                        ])
                        ->inline()
                        ->required(),
                    Select::make('rombongan_belajar_id')
                        ->label('Rombongan Belajar')
                        ->relationship('rombongan_belajar', 'nama_rombel')
                        ->searchable()
                        ->preload()
                        ->required()

                ])->columns(3),

                Fieldset::make('Alamat dan Tempat Lahir')->schema([
                    Select::make('provinsi')
                        ->label('Provinsi')
                        ->options(
                            Wilayah::whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 2")->pluck('nama', 'kode')
                        )
                        ->reactive()
                        ->required(),

                    Select::make('kabupaten')
                        ->label('Kabupaten/Kota')
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
                        ->disabled(fn(callable $get) => !$get('kabupaten')),

                    Select::make('desa_kelurahan')
                        ->label('Desa/Kelurahan')
                        ->options(
                            fn(callable $get) =>
                            $get('kecamatan')
                                ? Wilayah::where('kode', 'like', $get('kecamatan') . '.%')
                                ->whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 10")
                                ->pluck('nama', 'kode')
                                : []
                        )
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(function (callable $get, callable $set) {
                            $desaKode = $get('desa_kelurahan');
                            if ($desaKode) {
                                $set('kode_wilayah', $desaKode);
                            }
                        })
                        ->disabled(fn(callable $get) => !$get('kecamatan')),

                    TextInput::make('alamat_jalan')
                        ->label('Alamat Jalan')
                        ->nullable(),

                    TextInput::make('kode_pos')
                        ->label('Kode Pos')
                        ->maxLength(10)
                        ->nullable(),

                    DatePicker::make('tgl_lahir')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                ])->columns(3),
            ]);
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

                TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->sortable(),

                TextColumn::make('rombongan_belajar.nama_rombel')
                    ->label('Rombel')
                    ->sortable(),

                TextColumn::make('tgl_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('alamat_jalan')
                    ->label('Alamat Jalan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),

                TextColumn::make('desa_kelurahan')
                    ->label('Desa/Kelurahan')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('kabupaten')
                    ->label('Kabupaten/Kota')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('provinsi')
                    ->label('Provinsi')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('kode_pos')
                    ->label('Kode Pos')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter di sini jika perlu
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
            'index' => Pages\ListPesertaDidiks::route('/'),
            'create' => Pages\CreatePesertaDidik::route('/create'),
            'edit' => Pages\EditPesertaDidik::route('/{record}/edit'),
        ];
    }
}
