<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\MstGtk;
use Filament\Forms\Form;
use App\Models\MstSekolah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MstGtkResource\Pages;

class MstGtkResource extends Resource
{
    protected static ?string $model = MstGtk::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();

        if ($user?->hasRole('admin_sekolah')) {
            return null; // TANPA GROUP
        }

        return 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data GTK';
    protected static ?string $pluralLabel = 'GTK';
    protected static ?string $slug = 'data-gtk';

    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->hasRole('admin_sekolah') ? 20 : 30;
    }

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

                    Forms\Components\Select::make('status_kepegawaian')
                        ->label('Status Pegawai')
                        ->options([
                                'PNS' => 'PNS',
                                'PPPK' => 'PPPK',
                                'Honorer Daerah' => 'Honorer Daerah',
                                'Honorer Sekolah' => 'Honorer Sekolah',
                                'GTY/PTY' => 'GTY/PTY',
                                'Lainnya' => 'Lainnya',
                            ])
                        ->required(),
                    Forms\Components\Select::make('jenis_gtk')
                        ->label('Jenis GTK')
                        ->options([
                                'Guru' => 'Guru',
                                'Kepala Sekolah' => 'Kepala Sekolah',
                                'Tenaga Kependidikan' => 'Tenaga Kependidikan',
                            ])
                        ->required(),
                    Forms\Components\Select::make('pend_terakhir')
                        ->label('Pendidikan Terakhir')
                        ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA' => 'SMA',
                                'D3' => 'Diploma 3 (D3)',
                                'S1' => 'Sarjana (S1)',
                                'S2' => 'Magister (S2)',
                                'S3' => 'Doktor (S3)',
                            ])
                        ->required(),
                    Forms\Components\Select::make('status_keaktifan')
                        ->label('Status Keaktifan')
                        ->options([
                                'Aktif' => 'Aktif',
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
                    TextColumn::make('index')
                        ->label('No. ')
                        ->rowIndex(),
                    Tables\Columns\TextColumn::make('tempat_tugas')
                        ->label('Sekolah')
                        ->visible(fn() => auth()->user()->hasRole('super_admin'))
                        ->formatStateUsing(function ($state) {
                            if (is_iterable($state)) {
                                return collect($state)->pluck('nama')->implode(', ');
                            }
                            return $state;
                        }),

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
                    Tables\Columns\TextColumn::make('status_kepegawaian')
                        ->label('Status Pegawai')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('jenis_gtk')
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
                    Tables\Actions\DeleteAction::make(),
                ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();

            if (!$sekolah) {
                return parent::getEloquentQuery()->whereRaw('1=0');
            }

            return parent::getEloquentQuery()
                ->whereNotNull('tempat_tugas')
                ->where('tempat_tugas', $sekolah->npsn);
        }

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
