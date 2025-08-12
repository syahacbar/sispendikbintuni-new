<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MstPesertaDidik;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MstPesertaDidikResource\Pages;
use App\Filament\Resources\MstPesertaDidikResource\RelationManagers;
use Illuminate\Support\Facades\Auth;
use App\Models\MstSekolah;

class MstPesertaDidikResource extends Resource
{
    protected static ?string $model = MstPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Peserta Didik';
    protected static ?string $pluralLabel = 'Peserta Didik';
    protected static ?string $slug = 'data-peserta-didik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
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
                        'Islam'     => 'Islam',
                        'Kristen'   => 'Kristen',
                        'Hindu'     => 'Hindu',
                        'Buddha'    => 'Buddha',
                        'Konghucu'  => 'Konghucu',
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

        if (!$user->hasRole('admin_sekolah')) {
            $columns[] = Tables\Columns\TextColumn::make('rombels.0.sekolah.nama')
                ->label('Nama Sekolah')
                ->sortable()
                ->searchable(query: function (Builder $query, string $search) {
                    $query->whereHas('rombels.sekolah', function ($q) use ($search) {
                        $q->where('nama', 'ILIKE', "%{$search}%");
                    });
                });
        }

        $columns = array_merge($columns, [
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Lengkap')
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
                ->date('d F Y') // Format Indonesia
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
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Kalau role super_admin, tampilkan semua data tanpa filter
        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        // Kalau role admin_sekolah, filter berdasarkan sekolah_id
        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();

            if (! $sekolah) {
                return parent::getEloquentQuery()->whereRaw('1=0'); // Tidak ada data
            }

            return parent::getEloquentQuery()
                ->whereHas('rombels', function ($query) use ($sekolah) {
                    $query->where('sekolah_id', $sekolah->id);
                });
        }

        // Role lain (misal guru, operator, dll) bisa diatur di sini
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
            'index' => Pages\ListMstPesertaDidiks::route('/'),
            'create' => Pages\CreateMstPesertaDidik::route('/create'),
            'edit' => Pages\EditMstPesertaDidik::route('/{record}/edit'),
        ];
    }
}
