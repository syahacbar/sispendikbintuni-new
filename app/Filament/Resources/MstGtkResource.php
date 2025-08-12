<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\MstGtk;
use Filament\Forms\Form;
use App\Models\MstRombel;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MstGtkResource\Pages;

class MstGtkResource extends Resource
{
    protected static ?string $model = MstGtk::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'GTK';
    protected static ?string $pluralLabel = 'GTK';
    protected static ?string $slug = 'data-gtk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->maxLength(20),
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->maxLength(20),
                Forms\Components\TextInput::make('nuptk')
                    ->label('NUPTK')
                    ->maxLength(20),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_lahir')
                    ->label('Tanggal Lahir')
                    ->required()
                    ->native(false)
                    ->maxDate(now()),
                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),

                Forms\Components\Select::make('agama')
                    ->label('Agama')
                    ->options([
                        'Islam'     => 'Islam',
                        'Kristen'   => 'Kristen',
                        'Hindu'     => 'Hindu',
                        'Buddha'    => 'Buddha',
                        'Konghucu'  => 'Konghucu',
                    ])
                    ->required(),

                Forms\Components\Select::make('status_kepegawaian')
                    ->label('Status Pegawai')
                    ->options([
                        'PNS'             => 'PNS',
                        'PPPK'            => 'PPPK',
                        'Honorer Daerah'  => 'Honorer Daerah',
                        'Honorer Sekolah' => 'Honorer Sekolah',
                        'GTY/PTY'         => 'GTY/PTY',
                        'Lainnya'         => 'Lainnya',
                    ])
                    ->required(),
                Forms\Components\Select::make('jenis_gtk')
                    ->label('Jenis GTK')
                    ->required()
                    ->relationship('jenisGtk', 'nama')
                    ->searchable()
                    ->preload(true),
                Forms\Components\Select::make('pend_terakhir')
                    ->label('Pendidikan Terakhir')
                    ->options([
                        'SD'  => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'D3'  => 'Diploma 3 (D3)',
                        'S1'  => 'Sarjana (S1)',
                        'S2'  => 'Magister (S2)',
                        'S3'  => 'Doktor (S3)',
                    ])
                    ->required(),
                Forms\Components\Select::make('status_keaktifan')
                    ->label('Status Keaktifan')
                    ->options([
                        'Aktif'       => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ])
                    ->default('Aktif')
                    ->required()
                    ->visible(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolahMelaluiRombel.nama')
                    ->label('Sekolah')
                    ->visible(fn() => auth()->user()->hasRole('super_admin'))
                    ->formatStateUsing(function ($state) {
                        if (is_iterable($state)) {
                            return collect($state)->pluck('nama')->implode(', ');
                        }
                        return $state;
                    }),

                TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama')
                    ->label('Agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_kepegawaian')
                    ->label('Status Pegawai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisGtk.nama')
                    ->label('Jenis GTK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pend_terakhir')
                    ->label('Pendidikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_keaktifan')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->color(fn(string $state): string => match (strtolower($state)) {
                        'aktif' => 'success',
                        'tidak aktif' => 'danger',
                        default => 'secondary',
                    }),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // super_admin: tampilkan semua + eager load sekolah
        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery()
                ->with('sekolahMelaluiRombel');
        }

        // admin_sekolah: filter sesuai sekolah
        if ($user->hasRole('admin_sekolah')) {
            $sekolah = \App\Models\MstSekolah::where('users_id', $user->id)->first();

            if (! $sekolah) {
                return parent::getEloquentQuery()->whereRaw('1=0'); // tidak ada data
            }

            return parent::getEloquentQuery()
                ->with('sekolahMelaluiRombel')
                ->whereHas('rombels', function ($query) use ($sekolah) {
                    $query->where('sekolah_id', $sekolah->id);
                });
        }

        // role lain: kosongkan
        return parent::getEloquentQuery()->whereRaw('1=0');
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
            'index' => Pages\ListMstGtks::route('/'),
            'create' => Pages\CreateMstGtk::route('/create'),
            'edit' => Pages\EditMstGtk::route('/{record}/edit'),
        ];
    }
}
