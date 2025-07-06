<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use App\Models\Sekolah;
use App\Models\Wilayah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\SekolahResource\Pages;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Sekolah';
    protected static ?string $pluralModelLabel = 'Sekolah';
    protected static ?string $navigationGroup = 'Data Pendidikan';


    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('npsn')
                ->required()
                ->maxLength(10),

            TextInput::make('nama')
                ->required()
                ->maxLength(100),

            TextInput::make('jenjang')
                ->required()
                ->maxLength(50),

            // Wilayah Bertingkat
            Select::make('provinsi')
                ->label('Provinsi')
                ->options(
                    Wilayah::whereRaw("CHAR_LENGTH(REPLACE(kode, '.', '')) = 2")
                        ->pluck('nama', 'kode')
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
                ->nullable()
                ->default(true)
                ->native(false)
                ->seconds(false)
                ->displayFormat('d/m/Y')
                ->default(now())
                ->required(),

        ])->columns(3);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama Sekolah')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenjang')
                    ->label('Jenjang')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('alamat_jalan')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('desa_kelurahan')
                    ->label('Desa/Kelurahan')
                    ->searchable(),

                TextColumn::make('kode_pos')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kode Pos'),

                TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->searchable(),

                TextColumn::make('kabupaten')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Kabupaten')
                    ->searchable(),

                TextColumn::make('provinsi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Provinsi')
                    ->searchable(),

                TextColumn::make('status_sekolah')
                    ->label('Status Sekolah')
                    ->badge()
                    ->colors([
                        'primary' => 'Negeri',
                        'warning' => 'Swasta',
                    ])
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Akun Sekolah')
                    ->formatStateUsing(fn($state) => $state ?? 'Belum ada')
                    ->badge()
                    ->colors([
                        'success' => fn($state) => $state !== null,
                        'danger' => fn($state) => $state === null,
                    ])
                    ->sortable(),
                TextColumn::make('akreditasi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Akreditasi'),

                TextColumn::make('email')
                    ->label('Email')
                    ->limit(30),

                TextColumn::make('telepon')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Telepon'),

                TextColumn::make('sk_pendirian')
                    ->label('SK Pendirian')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(25),

                TextColumn::make('tanggal_sk_pendirian')
                    ->label('Tanggal SK')
                    ->date()
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
                Tables\Actions\Action::make('generateAkun')
                    ->label('Generate Akun')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->visible(fn($record) => $record->user === null && $record->email !== null)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        if (User::where('email', $record->email)->exists()) {
                            Notification::make()
                                ->title('Email sudah digunakan')
                                ->danger()
                                ->send();
                            return;
                        }

                        $password = Str::random(8); // atau bisa pakai default seperti 'password123'

                        $user = User::create([
                            'name' => $record->nama,
                            'email' => $record->email,
                            'password' => Hash::make($password),
                            'sekolah_id' => $record->id,
                        ]);

                        $user->assignRole('admin_sekolah');

                        // Simpan password di log file (jika perlu debug sementara)
                        Log::info("Akun sekolah {$record->nama} dibuat. Email: {$record->email}, Password: {$password}");

                        Notification::make()
                            ->title("Akun berhasil dibuat!")
                            ->body("Email: {$record->email} | Password: {$password}")
                            ->success()
                            ->send();
                    }),

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
