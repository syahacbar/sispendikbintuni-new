<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MstPesertaDidik;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MstPesertaDidikResource\Pages;
use App\Models\MstSekolah;

class MstPesertaDidikResource extends Resource
{
    protected static ?string $model = MstPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    public static function getNavigationGroup(): ?string
    {
        $user = auth()->user();

        if ($user?->hasRole('admin_sekolah')) {
            return null; // TANPA GROUP
        }

        return 'Data Master';
    }

    protected static ?string $navigationLabel = 'Data Peserta Didik';
    protected static ?string $pluralLabel = 'Peserta Didik';
    protected static ?string $slug = 'data-peserta-didik';

    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->hasRole('admin_sekolah') ? 30 : 20;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('nipd')
                        ->label('NIPD')
                        ->maxLength(6),
                    Forms\Components\TextInput::make('nisn')
                        ->label('NISN')
                        ->maxLength(10),
                    Forms\Components\TextInput::make('nik')
                        ->label('NIK')
                        ->maxLength(20),
                    Forms\Components\TextInput::make('tempat_lahir')
                        ->maxLength(100),
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
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu',
                            ])
                        ->required(),
                    Forms\Components\Textarea::make('alamat')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('kode_wilayah')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('kode_pos')
                        ->maxLength(10),
                ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();

        $columns = [];

        // Kalau bukan admin_sekolah, tampilkan kolom sekolah
        if (!$user->hasRole('admin_sekolah')) {
            $columns[] = Tables\Columns\TextColumn::make('nama_sekolah')
                ->label('Nama Sekolah')
                ->getStateUsing(
                    fn($record) =>
                    optional($record->rombels->first()?->sekolah)->nama ?? '-'
                )

                ->sortable()
                ->searchable(query: function (Builder $query, string $search) {
                    $query->whereHas('rombels.sekolah', function ($q) use ($search) {
                        $q->where('nama', 'ILIKE', "%{$search}%");
                    });
                });
        }

        $columns = array_merge($columns, [
            Tables\Columns\TextColumn::make('index')
                ->label('No. ')
                ->rowIndex(),
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Lengkap')
                ->searchable(),
            Tables\Columns\TextColumn::make('nipd')
                ->label('NIPD')
                ->searchable(),
            Tables\Columns\TextColumn::make('nisn')
                ->label('NISN')
                ->searchable(),
            Tables\Columns\TextColumn::make('nik')
                ->label('NIK')
                ->searchable(),
            Tables\Columns\TextColumn::make('tempat_lahir')
                ->label('Tempat Lahir')
                ->searchable(),
            Tables\Columns\TextColumn::make('tgl_lahir')
                ->label('Tanggal Lahir')
                ->date('d F Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('jenis_kelamin')
                ->label('JK')
                ->searchable(),
            Tables\Columns\TextColumn::make('agama')
                ->searchable(),
            Tables\Columns\TextColumn::make('wilayah.nama')
                ->label('Alamat')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('kode_pos')
                ->searchable(),
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
        $user = auth()->user();

        // Super admin → semua data
        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        // Admin sekolah → hanya peserta didik sekolahnya
        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();

            if (!$sekolah) {
                return parent::getEloquentQuery()->whereRaw('1=0');
            }

            return parent::getEloquentQuery()
                ->with(['rombels.sekolah'])
                ->whereHas('rombels', function ($q) use ($sekolah) {
                    $q->where('sekolah_id', $sekolah->id);
                });

        }

        return parent::getEloquentQuery()->whereRaw('1=0');
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMstPesertaDidiks::route('/'),
            'create' => Pages\CreateMstPesertaDidik::route('/create'),
            'edit' => Pages\EditMstPesertaDidik::route('/{record}/edit'),
        ];
    }
}
